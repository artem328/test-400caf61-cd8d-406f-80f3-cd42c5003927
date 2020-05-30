<?php

declare(strict_types=1);

namespace App\Guzzle;

use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Client\ClientExceptionInterface;

final class Psr18ClientException extends \RuntimeException implements ClientExceptionInterface
{
    /**
     * @var GuzzleException
     */
    private $guzzleException;

    public function __construct(
        GuzzleException $guzzleException,
        string $message = '',
        int $code = 0,
        \Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
        $this->guzzleException = $guzzleException;
    }

    public static function fromException(GuzzleException $exception): self
    {
        return new self($exception, $exception->getMessage(), $exception->getCode(), $exception->getPrevious());
    }

    public function getGuzzleException(): GuzzleException
    {
        return $this->guzzleException;
    }
}

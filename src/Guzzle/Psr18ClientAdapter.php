<?php

declare(strict_types=1);

namespace App\Guzzle;

use GuzzleHttp\ClientInterface as GuzzleClientInterface;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

final class Psr18ClientAdapter implements ClientInterface
{
    /**
     * @var GuzzleClientInterface
     */
    private $client;

    public function __construct(GuzzleClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * {@inheritdoc}
     */
    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        try {
            return $this->client->send($request);
        } catch (BadResponseException $e) {
            return $e->getResponse();
        } catch (GuzzleException $e) {
            throw Psr18ClientException::fromException($e);
        }
    }
}

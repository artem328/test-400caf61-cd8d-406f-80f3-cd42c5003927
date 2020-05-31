<?php

declare(strict_types=1);

namespace App\Stock;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Log\LoggerInterface;

final class DataHubCompanyProvider implements CompanyProviderInterface
{
    public const COMPANIES_URL = 'https://pkgstore.datahub.io/core/nasdaq-listings/nasdaq-listed_json/data/a5bc7580d6176d60ac0b2142ca8d7df6/nasdaq-listed_json.json';

    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @var RequestFactoryInterface
     */
    private $requestFactory;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(
        ClientInterface $client,
        RequestFactoryInterface $requestFactory,
        LoggerInterface $logger
    ) {
        $this->client = $client;
        $this->requestFactory = $requestFactory;
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     */
    public function get(): array
    {
        $request = $this->requestFactory->createRequest('GET', self::COMPANIES_URL);

        $response = $this->client->sendRequest($request);

        $payload = $response->getBody()->getContents();

        try {
            $companies = \json_decode($payload, true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            $this->logger->error('Failed to parse json: {message}', ['message' => $e->getMessage(), 'exception' => $e]);

            return [];
        }

        return \array_map(static function (array $company): Company {
            return new Company($company['Symbol'], $company['Company Name']);
        }, $companies);
    }
}

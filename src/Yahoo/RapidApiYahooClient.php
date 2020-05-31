<?php

declare(strict_types=1);

namespace App\Yahoo;

use App\Yahoo\Request\HistoricalDataRequest;
use App\Yahoo\Response\HistoricalDataResponse;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\UriFactoryInterface;
use Psr\Http\Message\UriInterface;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

final class RapidApiYahooClient implements YahooClientInterface
{
    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @var RequestFactoryInterface
     */
    private $requestFactory;

    /**
     * @var UriFactoryInterface
     */
    private $uriFactory;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var string
     */
    private $baseUri;

    /**
     * @var string
     */
    private $apiKey;

    public function __construct(
        ClientInterface $client,
        RequestFactoryInterface $requestFactory,
        UriFactoryInterface $uriFactory,
        SerializerInterface $serializer,
        string $baseUri,
        string $apiKey
    ) {
        $this->client = $client;
        $this->requestFactory = $requestFactory;
        $this->uriFactory = $uriFactory;
        $this->serializer = $serializer;
        $this->baseUri = $baseUri;
        $this->apiKey = $apiKey;
    }

    /**
     * {@inheritdoc}
     */
    public function getHistoricalData(HistoricalDataRequest $request): HistoricalDataResponse
    {
        $query = [
            'symbol' => $request->getSymbol(),
            'period1' => $request->getPeriod1()->format('U'),
            'period2' => $request->getPeriod2()->format('U'),
        ];

        if (null !== $request->getFilter()) {
            $query['filter'] = $request->getFilter();
        }

        if (null !== $request->getFrequency()) {
            $query['filter'] = $request->getFrequency();
        }

        $uri = $this->createUri('/stock/v2/get-historical-data')
            ->withQuery(\http_build_query($query))
        ;
        $httpRequest = $this->createAuthorizedRequest('GET', $uri);
        try {
            $httpResponse = $this->client->sendRequest($httpRequest);
        } catch (ClientExceptionInterface $e) {
            throw new RequestException(\sprintf('Failed to send request to historical data endpoint. %s', $e->getMessage()), 0, $e);
        }

        if (200 !== $httpResponse->getStatusCode()) {
            throw new RequestException(\sprintf('Historical data API respond with %d', $httpResponse->getStatusCode()));
        }

        $body = $httpResponse->getBody()->getContents();

        try {
            $response = $this->serializer->deserialize($body, HistoricalDataResponse::class, 'json', [
                DateTimeNormalizer::FORMAT_KEY => 'U',
            ]);
        } catch (\Exception $e) {
            throw new RequestException(\sprintf('Couldn\'t parse historical response'));
        }

        /* @var HistoricalDataResponse $response */

        return $response;
    }

    private function createAuthorizedRequest(string $method, UriInterface $uri): RequestInterface
    {
        return $this->requestFactory
            ->createRequest($method, $uri)
            ->withAddedHeader('X-RapidAPI-Key', $this->apiKey)
            ;
    }

    private function createUri(string $path): UriInterface
    {
        return $this->uriFactory->createUri($this->baseUri.$path);
    }
}

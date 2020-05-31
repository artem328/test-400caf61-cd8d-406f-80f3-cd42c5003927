<?php

declare(strict_types=1);

namespace App\History;

use App\Yahoo\Request\HistoricalDataRequest;
use App\Yahoo\YahooClientInterface;

final class YahooHistoryProvider implements HistoryProviderInterface
{
    /**
     * @var YahooClientInterface
     */
    private $client;

    public function __construct(YahooClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * {@inheritdoc}
     */
    public function getInRange(string $symbol, \DateTimeImmutable $from, \DateTimeImmutable $to): array
    {
        $response = $this->client->getHistoricalData(new HistoricalDataRequest(
            $symbol,
            $from,
            $to,
            HistoricalDataRequest::FILTER_HISTORY,
            HistoricalDataRequest::FREQUENCY_ONE_DAY
        ));

        $response->sortPrices();

        $data = [];

        foreach ($response->getPrices() as $price) {
            $data[] = new HistoryEntry(
                $symbol,
                $price->getDate(),
                $price->getOpen(),
                $price->getClose(),
                $price->getLow(),
                $price->getHigh(),
                $price->getVolume()
            );
        }

        return $data;
    }
}

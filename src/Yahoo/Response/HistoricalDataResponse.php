<?php

declare(strict_types=1);

namespace App\Yahoo\Response;

final class HistoricalDataResponse
{
    /**
     * @var Price[]
     */
    private $prices;

    /**
     * @param Price[] $prices
     */
    public function __construct(array $prices = [])
    {
        $this->prices = $prices;
    }

    /**
     * @return Price[]
     */
    public function getPrices(): array
    {
        return $this->prices;
    }

    public function sortPrices(string $direction = 'ASC'): void
    {
        \usort($this->prices, static function (Price $price1, Price $price2) use ($direction): int {
            return ($price1->getDate() <=> $price2->getDate()) * ('DESC' === \strtoupper($direction) ? -1 : 1);
        });
    }
}

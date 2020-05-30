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
}

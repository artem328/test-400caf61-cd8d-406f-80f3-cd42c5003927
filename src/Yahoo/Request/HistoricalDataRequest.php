<?php

declare(strict_types=1);

namespace App\Yahoo\Request;

final class HistoricalDataRequest
{
    public const FILTER_HISTORY = 'history';
    public const FILTER_DIV = 'div';
    public const FILTER_SPLIT = 'split';

    public const FREQUENCY_ONE_DAY = '1d';
    public const FREQUENCY_ONE_WEEK = '1wk';
    public const FREQUENCY_ONE_MONTH = '1mo';

    /**
     * @var string
     */
    private $symbol;

    /**
     * @var \DateTimeImmutable
     */
    private $period1;

    /**
     * @var \DateTimeImmutable
     */
    private $period2;

    /**
     * @var string|null
     */
    private $filter;

    /**
     * @var string|null
     */
    private $frequency;

    public function __construct(
        string $symbol,
        \DateTimeImmutable $period1,
        \DateTimeImmutable $period2,
        ?string $filter = null,
        ?string $frequency = null
    ) {
        $this->symbol = $symbol;
        $this->period1 = $period1;
        $this->period2 = $period2;
        $this->filter = $filter;
        $this->frequency = $frequency;
    }

    public function getSymbol(): string
    {
        return $this->symbol;
    }

    public function setSymbol(string $symbol): void
    {
        $this->symbol = $symbol;
    }

    public function getPeriod1(): \DateTimeImmutable
    {
        return $this->period1;
    }

    public function setPeriod1(\DateTimeImmutable $period1): void
    {
        $this->period1 = $period1;
    }

    public function getPeriod2(): \DateTimeImmutable
    {
        return $this->period2;
    }

    public function setPeriod2(\DateTimeImmutable $period2): void
    {
        $this->period2 = $period2;
    }

    public function getFilter(): ?string
    {
        return $this->filter;
    }

    public function setFilter(?string $filter): void
    {
        $this->filter = $filter;
    }

    public function getFrequency(): ?string
    {
        return $this->frequency;
    }

    public function setFrequency(?string $frequency): void
    {
        $this->frequency = $frequency;
    }
}

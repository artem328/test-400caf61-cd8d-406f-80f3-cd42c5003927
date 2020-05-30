<?php

declare(strict_types=1);

namespace App\History;

final class HistoryEntry
{
    /**
     * @var string
     */
    private $symbol;

    /**
     * @var \DateTimeImmutable
     */
    private $date;

    /**
     * @var float
     */
    private $open;

    /**
     * @var float
     */
    private $close;

    /**
     * @var float
     */
    private $low;

    /**
     * @var float
     */
    private $high;

    /**
     * @var int
     */
    private $volume;

    public function __construct(
        string $symbol,
        \DateTimeImmutable $date,
        float $open,
        float $close,
        float $low,
        float $high,
        int $volume
    ) {
        $this->symbol = $symbol;
        $this->date = $date;
        $this->open = $open;
        $this->close = $close;
        $this->low = $low;
        $this->high = $high;
        $this->volume = $volume;
    }

    public function getSymbol(): string
    {
        return $this->symbol;
    }

    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }

    public function getOpen(): float
    {
        return $this->open;
    }

    public function getClose(): float
    {
        return $this->close;
    }

    public function getLow(): float
    {
        return $this->low;
    }

    public function getHigh(): float
    {
        return $this->high;
    }

    public function getVolume(): int
    {
        return $this->volume;
    }
}

<?php

declare(strict_types=1);

namespace App\Yahoo\Response;

final class Price
{
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
    private $high;

    /**
     * @var float
     */
    private $low;

    /**
     * @var float
     */
    private $close;

    /**
     * @var int
     */
    private $volume;

    public function __construct(
        \DateTimeImmutable $date,
        float $open,
        float $high,
        float $low,
        float $close,
        int $volume
    ) {
        $this->date = $date;
        $this->open = $open;
        $this->high = $high;
        $this->low = $low;
        $this->close = $close;
        $this->volume = $volume;
    }

    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }

    public function getOpen(): float
    {
        return $this->open;
    }

    public function getHigh(): float
    {
        return $this->high;
    }

    public function getLow(): float
    {
        return $this->low;
    }

    public function getClose(): float
    {
        return $this->close;
    }

    public function getVolume(): int
    {
        return $this->volume;
    }
}

<?php

declare(strict_types=1);

namespace App\History;

interface HistoryProviderInterface
{
    /**
     * @return HistoryEntry[]
     */
    public function getInRange(string $symbol, \DateTimeImmutable $from, \DateTimeImmutable $to): array;
}

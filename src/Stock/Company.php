<?php

declare(strict_types=1);

namespace App\Stock;

final class Company
{
    /**
     * @var string
     */
    private $symbol;

    /**
     * @var string
     */
    private $name;

    public function __construct(string $symbol, string $name)
    {
        $this->symbol = $symbol;
        $this->name = $name;
    }

    public function getSymbol(): string
    {
        return $this->symbol;
    }

    public function getName(): string
    {
        return $this->name;
    }
}

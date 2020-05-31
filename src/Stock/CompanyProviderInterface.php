<?php

declare(strict_types=1);

namespace App\Stock;

interface CompanyProviderInterface
{
    /**
     * @return Company[]
     */
    public function get(): array;
}

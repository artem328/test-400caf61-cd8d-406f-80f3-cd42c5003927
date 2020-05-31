<?php

declare(strict_types=1);

namespace App\Repository;

use App\Stock\Company;

interface CompanyRepositoryInterface
{
    public function findBySymbol(string $symbol): ?Company;
}

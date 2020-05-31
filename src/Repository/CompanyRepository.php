<?php

declare(strict_types=1);

namespace App\Repository;

use App\Stock\Company;
use App\Stock\CompanyProviderInterface;

final class CompanyRepository implements CompanyRepositoryInterface
{
    /**
     * @var CompanyProviderInterface
     */
    private $provider;

    public function __construct(CompanyProviderInterface $provider)
    {
        $this->provider = $provider;
    }

    /**
     * {@inheritdoc}
     */
    public function findBySymbol(string $symbol): ?Company
    {
        $companies = $this->provider->get();

        foreach ($companies as $company) {
            if (\strtolower($company->getSymbol()) === \strtolower($symbol)) {
                return $company;
            }
        }

        return null;
    }
}

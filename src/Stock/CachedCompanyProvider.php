<?php

declare(strict_types=1);

namespace App\Stock;

use Psr\Cache\CacheItemPoolInterface;

final class CachedCompanyProvider implements CompanyProviderInterface
{
    private const CACHE_KEY = 'companies';

    /**
     * @var CompanyProviderInterface
     */
    private $provider;

    /**
     * @var CacheItemPoolInterface
     */
    private $cacheItemPool;

    /**
     * @var int
     */
    private $ttl;

    public function __construct(CompanyProviderInterface $provider, CacheItemPoolInterface $cacheItemPool, int $ttl)
    {
        $this->provider = $provider;
        $this->cacheItemPool = $cacheItemPool;
        $this->ttl = $ttl;
    }

    /**
     * {@inheritdoc}
     */
    public function get(): array
    {
        $item = $this->cacheItemPool->getItem(self::CACHE_KEY);

        if ($item->isHit()) {
            return $item->get();
        }

        $companies = $this->provider->get();
        $item->set($companies);
        $item->expiresAfter($this->ttl);
        $this->cacheItemPool->save($item);

        return $companies;
    }
}

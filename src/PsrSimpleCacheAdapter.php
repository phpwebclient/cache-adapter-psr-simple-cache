<?php

declare(strict_types=1);

namespace Webclient\Cache\Adapter\PsrSimpleCache;

use Psr\SimpleCache\CacheInterface as SimpleCache;
use Psr\SimpleCache\InvalidArgumentException;
use Webclient\Cache\Contract\CacheInterface;
use Webclient\Cache\Contract\Exception\CacheError;

final class PsrSimpleCacheAdapter implements CacheInterface
{
    private SimpleCache $cache;

    public function __construct(SimpleCache $cache)
    {
        $this->cache = $cache;
    }

    /**
     * @inheritDoc
     */
    public function get(string $key): ?string
    {
        try {
            $value = $this->cache->get($key);
            if (!is_string($value)) {
                return null;
            }
            return $value;
        } catch (InvalidArgumentException $exception) {
            throw new CacheError($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    /**
     * @inheritDoc
     */
    public function set(string $key, string $data, ?int $ttl = null): void
    {
        try {
            $this->cache->set($key, $data, $ttl);
        } catch (InvalidArgumentException $exception) {
            throw new CacheError($exception->getMessage(), $exception->getCode(), $exception);
        }
    }
}

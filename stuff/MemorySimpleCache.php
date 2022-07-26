<?php

declare(strict_types=1);

namespace Stuff\Webclient\Cache\Adapter\PsrSimpleCache;

use DateInterval;
use InvalidArgumentException;
use Psr\SimpleCache\CacheInterface;

final class MemorySimpleCache implements CacheInterface
{
    private array $storage = [];

    public function get(string $key, mixed $default = null): mixed
    {
        if (!$this->has($key)) {
            return $default;
        }
        return $this->storage[$key]['value'] ?? $default;
    }

    public function set(string $key, mixed $value, null|int|DateInterval $ttl = null): bool
    {
        $delta = $this->calculateDelta($ttl);
        if ($delta === 0) {
            return false;
        }
        $item = [
            'value' => $value,
        ];
        if (!is_null($delta)) {
            $item['expires'] = time() + $delta;
        }
        $this->storage[$key] = $item;
        return true;
    }

    public function delete(string $key): bool
    {
        if ($this->has($key)) {
            unset($this->storage[$key]);
        }
        return true;
    }

    public function clear(): bool
    {
        $this->storage = [];
        return true;
    }

    public function getMultiple(iterable $keys, mixed $default = null): iterable
    {
        $result = [];
        foreach ($keys as $key) {
            $result[$key] = $this->get($key, $default);
        }
        return $result;
    }

    public function setMultiple(iterable $values, null|int|DateInterval $ttl = null): bool
    {
        $result = true;
        foreach ($values as $key => $value) {
            if (!$this->set($key, $value, $ttl)) {
                $result = false;
            }
        }
        return $result;
    }

    public function deleteMultiple(iterable $keys): bool
    {
        $result = true;
        foreach ($keys as $key) {
            if (!$this->delete($key)) {
                $result = false;
            }
        }
        return $result;
    }

    public function has(string $key): bool
    {
        if (!array_key_exists($key, $this->storage)) {
            return false;
        }
        if (!array_key_exists('value', $this->storage[$key])) {
            unset($this->storage[$key]);
            return false;
        }
        $expired = false;
        if (array_key_exists('expires', $this->storage[$key])) {
            $expired = time() >= $this->storage[$key]['expires'];
        }
        if ($expired) {
            unset($this->storage[$key]);
            return false;
        }
        return true;
    }

    private function calculateDelta(null|int|DateInterval $ttl): ?int
    {
        if (is_null($ttl)) {
            return null;
        }
        if (is_int($ttl)) {
            return max(0, $ttl);
        }
        if ($ttl instanceof DateInterval) {
            if ($ttl->invert === 1) {
                return 0;
            }
            return $ttl->days * 86400 + $ttl->h * 3600 + $ttl->i * 60 + $ttl->s;
        }
        throw new InvalidArgumentException('ttl must be null, integer or DateInterval');
    }
}

<?php

declare(strict_types=1);

namespace Tests\Webclient\Cache\Adapter\PsrSimpleCache;

use DateInterval;
use PHPUnit\Framework\TestCase;
use Psr\SimpleCache\InvalidArgumentException;
use Stuff\Webclient\Cache\Adapter\PsrSimpleCache\MemorySimpleCache;
use Webclient\Cache\Adapter\PsrSimpleCache\PsrSimpleCacheAdapter;

final class PsrSimpleCacheAdapterTest extends TestCase
{
    /**
     * @throws InvalidArgumentException
     */
    public function testGet(): void
    {
        $simpleCache = new MemorySimpleCache();
        $adapter = new PsrSimpleCacheAdapter($simpleCache);
        $simpleCache->set('get1', 'value1', 5);
        self::assertSame('value1', $adapter->get('get1'));

        $simpleCache->set('get2', 'value2', 0);
        self::assertSame(null, $adapter->get('get2'));

        $simpleCache->set('get3', 'value3', -1);
        self::assertSame(null, $adapter->get('get3'));

        $simpleCache->set('get4', 'value4', new DateInterval('PT1H'));
        self::assertSame('value4', $adapter->get('get4'));

        $interval = new DateInterval('PT1H');
        $interval->invert = 1;
        $simpleCache->set('get5', 'value5', $interval);
        self::assertSame(null, $adapter->get('get5'));

        $simpleCache->set('get6', 'value6');
        self::assertSame('value6', $adapter->get('get6'));

        $simpleCache->set('get7', [1, 2, 3]);
        self::assertSame(null, $adapter->get('get7'));
    }

    /**
     * @throws InvalidArgumentException
     */
    public function testSet(): void
    {
        $simpleCache = new MemorySimpleCache();
        $adapter = new PsrSimpleCacheAdapter($simpleCache);

        $adapter->set('set1', 'value1', 5);
        self::assertSame('value1', $simpleCache->get('set1'));

        $adapter->set('set2', 'value2', 0);
        self::assertSame(null, $simpleCache->get('set2'));

        $adapter->set('set3', 'value3', -1);
        self::assertSame(null, $simpleCache->get('set3'));

        $adapter->set('set4', 'value4');
        self::assertSame('value4', $simpleCache->get('set4'));
    }
}

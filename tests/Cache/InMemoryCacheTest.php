<?php

namespace Tests\Cache;

use g9rga\phpFcm\src\Cache\InMemoryCache;
use PHPUnit\Framework\TestCase;

class InMemoryCacheTest extends TestCase
{
    public function testGetSet()
    {
        $cacheKey = 'test';
        $cacheValue = 'test1';
        $cache = new InMemoryCache();
        $this->assertNull($cache->get($cacheKey));
        $cache->set($cacheKey, $cacheValue, 10);
        $this->assertEquals($cacheValue, $cache->get($cacheKey));
        $cache->set($cacheKey, $cacheValue, -10);
        $this->assertNull($cache->get($cacheKey));
    }

    public function testDelete()
    {
        $cacheKey = 'test';
        $cacheValue = 'test1';
        $cache = new InMemoryCache();
        $cache->set($cacheKey, $cacheValue, 10);
        $cache->delete($cacheKey);
        $this->assertNull($cache->get($cacheKey));
    }

    public function testClear()
    {
        $cacheKey = 'test';
        $cacheValue = 'test1';
        $cache = new InMemoryCache();
        $cache->set($cacheKey, $cacheValue, 10);
        $cache->clear($cacheKey);
        $this->assertNull($cache->get($cacheKey));
    }

    public function testHas()
    {
        $cacheKey = 'test';
        $cacheValue = 'test1';
        $cache = new InMemoryCache();
        $cache->set($cacheKey, $cacheValue, 10);
        $this->assertTrue($cache->has($cacheKey));
    }
}

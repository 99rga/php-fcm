<?php

namespace g9rga\phpFcm\src\Cache;

use g9rga\phpFcm\src\Exception\NotImplementedException;
use Psr\SimpleCache\CacheInterface;

class InMemoryCache implements CacheInterface
{
    /**
     * @var array
     */
    private $cacheData = [];

    /**
     * @param string $key
     * @param null   $default
     *
     * @return mixed|null
     */
    public function get($key, $default = null)
    {
        $data = $this->cacheData[$key] ?? null;
        if (!$data || $data['expired'] < time()) {
            return null;
        } else {
            return $data['value'];
        }
    }

    /**
     * @param string $key
     * @param mixed  $value
     * @param null   $ttl
     *
     * @return bool|void
     */
    public function set($key, $value, $ttl = null)
    {
        $data = [];
        $data['expired'] = time() + $ttl;
        $data['value'] = $value;
        $this->cacheData[$key] = $data;
    }

    /**
     * @param string $key
     *
     * @return bool|void
     */
    public function delete($key)
    {
        unset($this->cacheData[$key]);
    }

    /**
     * @return bool|void
     */
    public function clear()
    {
        $this->cacheData = [];
    }

    /**
     * @param iterable $keys
     * @param null     $default
     * @return iterable|void
     * @throws NotImplementedException
     */
    public function getMultiple($keys, $default = null)
    {
        throw new NotImplementedException();
    }

    /**
     * @param iterable $values
     * @param null     $ttl
     *
     * @return bool|void
     * @throws NotImplementedException
     */
    public function setMultiple($values, $ttl = null)
    {
        throw new NotImplementedException();
    }

    /**
     * @param iterable $keys
     * @return bool|void
     * @throws NotImplementedException
     */
    public function deleteMultiple($keys)
    {
        throw new NotImplementedException();
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    public function has($key)
    {
        return isset($this->cacheData[$key]) && $this->cacheData[$key]['expired'] > time();
    }
}

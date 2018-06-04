<?php

namespace g9rga\phpFcm\src\Cache;

use Psr\SimpleCache\CacheInterface;

class NullCache implements CacheInterface
{
    /**
     * @var array
     */
    private $cacheData = [];

    /**
     * @param string $key
     * @param null   $default
     *
     * @return mixed|void
     */
    public function get($key, $default = null)
    {
        $data = $this->cacheData[$key] ?? null;
        if (!$data || $data['expired'] < time()) {
            return;
        } else {
            return $data;
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
        $data = $this->cacheData[$key] ?? [];
        $data['expired'] = time() + $ttl;
        $data['value'] = $value;
    }

    /**
     * @param string $key
     *
     * @return bool|void
     */
    public function delete($key)
    {
        // TODO: Implement delete() method.
    }

    /**
     * @return bool|void
     */
    public function clear()
    {
        // TODO: Implement clear() method.
    }

    /**
     * @param iterable $keys
     * @param null     $default
     *
     * @return iterable|void
     */
    public function getMultiple($keys, $default = null)
    {
        // TODO: Implement getMultiple() method.
    }

    /**
     * @param iterable $values
     * @param null     $ttl
     *
     * @return bool|void
     */
    public function setMultiple($values, $ttl = null)
    {
        // TODO: Implement setMultiple() method.
    }

    /**
     * @param iterable $keys
     *
     * @return bool|void
     */
    public function deleteMultiple($keys)
    {
        // TODO: Implement deleteMultiple() method.
    }

    /**
     * @param string $key
     *
     * @return bool|void
     */
    public function has($key)
    {
        // TODO: Implement has() method.
    }
}

<?php

namespace Foolz\Cache\Storage;

class Redis extends \Foolz\Cache\Storage
{
    /**
     * Returns the configuration of the storage engine
     *
     * @return  \Foolz\Cache\Config\Redis
     */
    public function getConfig()
    {
        return $this->config;
    }

    public function get($key)
    {
        $result = $this->getConfig()->getConnection()->get($key);

        if ($result === null)
        {
            return \Foolz\Cache\Void::forge();
        }

        return $result;
    }

    public function set($key, $value, $expiration)
    {
        $this->getConfig()->getConnection()->transaction(function($tx) use ($key, $value, $expiration) {
            $tx->set($key, $value);
            $tx->expire($key, $expiration);
        });
    }

    public function delete($key)
    {
        $this->getConfig()->getConnection()->delete($key);
    }

    public function flush()
    {
        $this->getConfig()->getConnection()->flushdb();
    }
}

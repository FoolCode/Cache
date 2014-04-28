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
        $this->getConfig()->getConnection()->setex($key, $expiration, $value);
    }

    public function delete($key)
    {
        $this->getConfig()->getConnection()->del($key);
    }

    public function flush()
    {
        $this->getConfig()->getConnection()->flushdb();
    }
}

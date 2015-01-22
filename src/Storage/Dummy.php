<?php

namespace Foolz\Cache\Storage;

class Dummy extends \Foolz\Cache\Storage
{
    /**
     * Returns the configuration of the storage engine
     *
     * @return  \Foolz\Cache\Config\Dummy
     */
    public function getConfig()
    {
        return $this->config;
    }

    public function get($key)
    {
        return \Foolz\Cache\Void::forge();
    }

    public  function set($key, $value, $expiration)
    {

    }

    public function delete($key)
    {

    }

    public function flush()
    {

    }
}

<?php

namespace Foolz\Cache\Storage;

class Volatile extends \Foolz\Cache\Storage
{
    /**
     * Store the cache in an array
     *
     * @var  array
     */
    public static $storage = [];

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
        if (!isset(static::$storage[$key])) {
            return \Foolz\Cache\Void::forge();
        }

        if (static::$storage[$key]['expiration'] && static::$storage[$key]['expiration'] + static::$storage[$key]['created'] > time()) {
            $this->delete($key);
            
            return $this->get($key);
        }

        return static::$storage[$key]['value'];
    }

    public  function set($key, $value, $expiration)
    {
        static::$storage[$key] = [
            'value' => $value,
            'expiration' => $expiration,
            'created' => time()
        ];
    }

    public function delete($key)
    {
        unset(static::$storage[$key]);
    }

    public function flush()
    {
        static::$storage = [];
    }
}

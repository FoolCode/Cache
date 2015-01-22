<?php

namespace Foolz\Cache;

abstract class Storage
{
    /**
     * The configuration object
     *
     * @var  \Foolz\Cache\Config
     */
    public $config = null;

    /**
     * Sets the configuration for the storage engine
     *
     * @param  $config  A configuration matching the type of the storage engine
     */
    public function setConfig(\Foolz\Cache\Config $config)
    {
        $this->config = $config;
    }

    /**
     * Returns the configuration of the storage engine
     *
     * @return  \Foolz\Cache\Config
     */
    public abstract function getConfig();

    /**
     * Returns the value or Void if not available
     *
     * @param  string  $key  The cache key
     *
     * @return  mixed  The value stored or \Foolz\Cache\Void
     */
    public abstract function get($key);

    /**
     * Sets the value for the key being worked on
     *
     * @param  string  $key         The cache key
     * @param  mixed   $value       The value to set
     * @param  int     $expiration  Duration of the cache in seconds
     */
    public abstract function set($key, $value, $expiration);

    /**
     * Deletes the value stored in the key
     *
     * @param  string  $key  The cache key
     */
    public abstract function delete($key);

    /**
     * Flushes the entire cache (comprehending the one from other applications in some cases)
     */
    public abstract function flush();
}

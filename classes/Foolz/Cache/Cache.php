<?php

namespace Foolz\Cache;

class Cache
{
	/**
	 * The key set for this instance of cache
	 *
	 * @var  null|string
	 */
	protected $key = null;

	/**
	 * The value associated with the key
	 *
	 * @var  mixed
	 */
	protected $value;

	/**
	 * The expiration time in seconds from the moment it's set
	 *
	 * @var  int
	 */
	protected $expiration;

	/**
	 * The storage to be used
	 *
	 * @var  \Foolz\Cache\Storage
	 */
	protected $storage = null;

	/**
	 * The configuration to use
	 *
	 * @var  \Foolz\Cache\Config
	 */
	protected $config = null;

	/**
	 * An array with the configuration instances
	 *
	 * @var  \Foolz\Cache\Config[]
	 */
	protected $instances = [];

	/**
	 * Create a new named instance
	 *
	 * @param \Foolz\Cache\Config  $config         The configuration that
	 * @param string                      $instance_name  The name of the instance
	 */
	public static function instantiate(\Foolz\Cache\Config $config, $instance_name = 'default')
	{
		static::$instances[$instance_name] = $config;
	}

	/**
	 * Destroys an instance
	 *
	 * @param  string  $instance_name  The instance name
	 */
	public static function destroy($instance_name)
	{
		unset(static::$instances[$instance_name]);
	}

	/**
	 * Creates a new instance of the
	 *
	 * @param  string  $key            The key for the stored value
	 * @param  string  $instance_name  The named instance to use
	 */
	public static function item($key, $instance_name = 'default')
	{
		if ( ! isset(static::$instances[$instance_name]))
		{
			throw new \OutOfRangeException('The instance specified doesn\'t exist');
		}

		$new = new static();
		$new->setConfig(static::$instances[$instance_name]);
		$new->setKey($key);
	}

	/**
	 * Sets a configuration
	 *
	 * @param  \Foolz\Cache\Config  $config  The configuration object
	 *
	 * @return  \Foolz\Cache\Cache  The current object
	 */
	public function setConfig(\Foolz\Cache\Config $config)
	{
		$this->config = $config;

		return $this;
	}

	/**
	 * Returns the config
	 *
	 * @return  \Foolz\Cache\Config  The configuration
	 */
	public function getConfig()
	{
		return $this->config;
	}

	/**
	 * Returns the storage engine object or creates it if necessary
	 *
	 * @return  \Foolz\Cache\Storage  The configured Storage object
	 */
	public function getEngine()
	{
		if ($this->engine === null)
		{
			$class = '\Foolz\Cache\Storage\\'.Util::lowercaseToClassName($this->getConfig()->getStorage());

			$this->engine = new $class();
			$this->engine->setConfig($this->getConfig());
		}

		return $this->engine;
	}

	/**
	 * Sets the key
	 *
	 * @param  string  $key  The key
	 *
	 * @return  \Foolz\Cache\Cache  The current object
	 */
	public function setKey($key)
	{
		$this->key = $key;

		return $this;
	}

	/**
	 * Returns the key
	 *
	 * @return  string  The key
	 */
	public function getKey()
	{
		return $this->key;
	}

	/**
	 * Sets the value for the key
	 *
	 * @param  $value       The value to store
	 * @param  $expiration  The time in seconds
	 */
	public function set($value, $expiration)
	{
		$this->getEngine()->set($this->getKey(), $this->getConfig()->getFormat()->encode($value), $expiration);
	}

	/**
	 * Fetches the value set for the key
	 *
	 * @return  mixed                  The value
	 * @throws  \OutOfBoundsException  If the configuration is set to throw an exception, this will be thrown if the value is not found
	 */
	public function get()
	{
		$result = $this->getEngine()->get($this->getKey());

		if ($this->getConfig()->getThrow() && $result instanceof \Foolz\Cache\Void)
		{
			throw new \OutOfBoundsException('The value wasn\'t found for the specified key.');
		}

		return $this->getConfig()->getFormat()->decode($result);
	}

	/**
	 * Deletes the value set for the key
	 *
	 * @return  \Foolz\Cache\Cache  The current object
	 */
	public function delete()
	{
		$this->getEngine()->delete($this->getKey());

		return $this;
	}

	/**
	 * Clears all the contents of the cache. Depending on the engine, it might wipe the cache also for other applications.
	 *
	 * @return  \Foolz\Cache\Cache  The current object
	 */
	public function flush()
	{
		$this->getEngine()->flush($this->getKey());

		return $this;
	}
}
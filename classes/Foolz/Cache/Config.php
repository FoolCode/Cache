<?php

namespace Foolz\Cache;

class Config
{
	/**
	 * The storage engine being used
	 *
	 * @var  null|string
	 */
	protected $storage = null;

	/**
	 * If true, rather than returning Void, an exception will be thrown
	 *
	 * @var  boolean
	 */
	protected $throw = false;

	/**
	 * Returns
	 *
	 * @param  string  $storage
	 *
	 * @return  \Foolz\Cache\Config
	 */
	public static function forge($storage)
	{
		$class = '\Foolz\Cache\Config\\'.$storage;

		// check that we have such a storage engine
		if ( ! class_exists('\Foolz\Cache\Storage\\'.ucfirst($storage)))
		{
			throw new \DomainException('The storage engine selected doesn\'t exist.');
		}

		return new $class();
	}

	/**
	 * Shorthand that allows using IDE suggestions
	 *
	 * @return  \Foolz\Cache\Config\Apc
	 */
	public static function forgeApc()
	{
		return static::forge('apc');
	}

	/**
	 * Shorthand that allows using IDE suggestions
	 *
	 * @return  \Foolz\Cache\Config\Memcached
	 */
	public static function forgeMemcached()
	{
		return static::forge('memcached');
	}

	/**
	 * Shorthand that allows using IDE suggestions
	 *
	 * @return  \Foolz\Cache\Config\Db
	 */
	public static function forgeDb()
	{
		return static::forge('db');
	}

	/**
	 * Shorthand that allows using IDE suggestions
	 *
	 * @return  \Foolz\Cache\Config\File
	 */
	public static function forgeFile()
	{
		return static::forge('file');
	}

	/**
	 * Shorthand that allows using IDE suggestions
	 *
	 * @return  \Foolz\Cache\Config\File
	 */
	public static function forgeDummy()
	{
		return static::forge('dummy');
	}

	/**
	 * Get the selected storage engine
	 *
	 * @return  string                   The name of the storage engine
	 * @throws  \BadMethodCallException  If the storage engine hasn't been set yet
	 */
	public function getStorage()
	{
		if ($this->storage === null)
		{
			throw new \BadMethodCallException('The storage engine was not set.');
		}

		return $this->storage;
	}

	/**
	 * Enables exceptions when the value of a key can't be found
	 *
	 * @param  boolean  $bool  True if it should throw exceptions if the value of a key can't be found, false if it should return Void without throwing exceptions
	 *
	 * @return  \Foolz\Cache\Config  The current object
	 */
	public function setThrow($bool = false)
	{
		$this->throw = $bool;
		return $this;
	}

	/**
	 * Returns the throw configuration
	 *
	 * @return  boolean  True if it should throw exceptions if the value of a key can't be found, false if it should return Void without throwing exceptions
	 */
	public function getThrow()
	{
		return $this->throw;
	}
}
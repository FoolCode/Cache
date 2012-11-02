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
	 * A prefix for the keys so they don't get mixed with variables from other storages
	 *
	 */
	protected $prefix = '';

	/**
	 * Returns an instance for the storage selected
	 *
	 * @param  string  $storage  The name of the storage
	 *
	 * @return  \Foolz\Cache\Config  The Config class specific to the storage
	 * @throws  \DomainException     If the storage engine selected doesn't exist
	 */
	public static function forge($storage)
	{
		$class = '\Foolz\Cache\Config\\'.Util::lowercaseToClassName($storage);

		// check that we have such a storage engine
		if ( ! class_exists($class))
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
	 * Shorthand that allows using IDE suggestions
	 *
	 * @return  \Foolz\Cache\Config\File
	 */
	public static function forgeVolatile()
	{
		return static::forge('volatile');
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
	 * Sets the format to use
	 *
	 * @param  string  $format  The name of the format
	 *
	 * @throws  \DomainException  In case the format doesn't exist
	 */
	public function setFormat($format)
	{
		$class = '\Foolz\Cache\Format\\'.Util::lowercaseToClassName($format);

		// check that we have such a storage engine
		if ( ! class_exists($class))
		{
			throw new \DomainException('The format selected doesn\'t exist.');
		}

		$this->format = new $class();

		return $this;
	}

	/**
	 * Returns the format
	 *
	 * @return  \Foolz\Cache\Format  The format object
	 *
	 * @throws  \BadMethodCallException  If the format wasn't selected
	 */
	public function getFormat()
	{
		if ($this->format === null)
		{
			throw new \BadMethodCallException('The format wasn\'t selected.');
		}

		return $this->format;
	}

	/**
	 * Set a prefix for the keys
	 *
	 * @param  string  $prefix
	 *
	 * @return  \Foolz\Cache\Config  The current object
	 */
	public function setPrefix($prefix)
	{
		$this->prefix = $prefix;

		return $this;
	}

	/**
	 * Returns the set prefix
	 *
	 * @return  string  The prefix
	 */
	public function getPrefix()
	{
		return $this->prefix;
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
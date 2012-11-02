<?php

namespace Foolz\Cache\Config;

class File extends \Foolz\Cache\Config
{
	/**
	 * The name of the storage engine
	 *
	 * @var  string
	 */
	protected $storage = 'file';

	/**
	 * The directory where to store the elements of the cache
	 *
	 * @var  string
	 */
	protected $dir = '';

	/**
	 * Sets the directory
	 */
	public function __construct()
	{
		// sadly we must set $this->dir here regardless of storage engine, as we want to use __DIR__
		$this->dir = __DIR__.'/../../../../resources/cache/';
	}

	/**
	 * Set the directory to use for File cache
	 *
	 * @param type $dir
	 *
	 * @return  \Foolz\Cache\Config  The current object
	 * @throws  \DomainException            If the storage engine doesn't exist or if the directory doesn't exist;
	 */
	public function setDir($dir)
	{
		if ($this->storage !== 'file')
		{
			throw new \DomainException('The method is not compatible with the current storage engine');
		}

		$this->dir = rtrim($dir, '/').'/';

		if ( ! is_dir($this->dir))
		{
			throw new \DomainException('The directory was not found.');
		}

		return $this;
	}

	/**
	 * Returns the directory set for caching
	 *
	 * @return  string  The directory
	 */
	public function getDir()
	{
		return $this->dir;
	}
}
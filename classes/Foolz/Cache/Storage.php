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
	public function getConfig();

	/**
	 * Returns the value or Void if not available
	 *
	 * @return  mixed  The value stored or \Foolz\Cache\Void
	 */
	public function get();

	/**
	 * Sets the value for the key being worked on
	 *
	 * @param  $value  The value to set
	 */
	public function set($value);

	/**
	 * Deletes the value stored in the key
	 */
	public function delete();

	/**
	 * Flushes the entire cache (comprehending the one from other applications in some cases)
	 */
	public function flush();

}
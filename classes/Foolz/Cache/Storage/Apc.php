<?php

namespace Foolz\Cache\Storage;

class Apc extends \Foolz\Cache\Storage
{
	/**
	 * Returns the configuration of the storage engine
	 *
	 * @return  \Foolz\Cache\Config\Apc
	 */
	public function getConfig()
	{
		return $this->config;
	}

	public function get($key)
	{
		$success = false;
		$value = apc_fetch($key, $success);

		if ($success)
		{
			return $value;
		}
		else
		{
			return \Foolz\Cache\Void::forge();
		}
	}

	public function set($key, $value, $expiration)
	{
		apc_store($key, $value, $expiration);
	}

	public function delete($key)
	{
		apc_delete($key);
	}

	public function flush()
	{
		apc_clear_cache('user');
	}
}
<?php

namespace Foolz\Cache\Storage;

class Apc extends \Foolz\Cache\Storage
{
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
			return new \Foolz\Cache\Void;
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
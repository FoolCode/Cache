<?php

namespace Foolz\Cache\Storage;

class Dummy extends \Foolz\Cache\Storage
{
	public function get($key)
	{
		return new \Foolz\Cache\Void;
	}

	public function set($key, $value, $expiration)
	{

	}

	public function delete($key)
	{

	}

	public function flush()
	{

	}
}
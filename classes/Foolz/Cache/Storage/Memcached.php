<?php

namespace Foolz\Cache\Storage;

class Memcached extends \Foolz\Cache\Storage
{
	/**
	 * Returns the configuration of the storage engine
	 *
	 * @return  \Foolz\Cache\Config\Memcached
	 */
	public function getConfig()
	{
		return $this->config;
	}

	public function get($key)
	{
		$result = $this->getConfig()->getConnection()->get($key);

		if ($result === false && $this->getConfig()->getConnection()->getResultCode() === \Memcached::RES_NOTFOUND)
		{
			return \Foolz\Cache\Void::forge();
		}

		return $result;
	}

	public function set($key, $value, $expiration)
	{
		$this->getConfig()->getConnection()->set($key, $value, $expiration);
	}

	public function delete($key)
	{
		$this->getConfig()->getConnection()->delete($key);
	}

	public function flush()
	{
		$this->getConfig()->getConnection()->flush();
	}
}
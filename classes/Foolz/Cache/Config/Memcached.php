<?php

namespace Foolz\Cache\Config;

class Memcached
{
	/**
	 * The name of the storage engine
	 *
	 * @var  string
	 */
	protected $storage = 'memcached';

	/**
	 * The Memcached object
	 *
	 * @var  \Memcached
	 */
	protected $connection = null;

	/**
	 * The servers to connect to
	 *
	 * @var  array
	 */
	public $servers = [
		[
			'host' => '127.0.0.1',
			'port' => 11211,
			'weight' => 100
		]
	];

	/**
	 * Returns the connected Memcached object
	 *
	 * @return  \Memcached         The connected Memcached
	 * @throws  \RuntimeException  In case the servers can't be contacted
	 */
	public function getConnection()
	{
		if ($this->connection === null)
		{
			$this->connection = new \Memcached();
			$this->connection->addServers($this->servers);
			if ($this->connection->getVersion() === false)
			{
				throw new \RuntimeException('The Memcached server could not be reached.');
			}
		}

		return $this->connection;
	}

	/**
	 * Adds a server to the array of available servers
	 *
	 * @param  string  $host    The hostname or IP to the server
	 * @param  int     $port    The port to the server
	 * @param  int     $weight  The weight of the server specified
	 *
	 * @return  \Foolz\Cache\Config\Memcached  The current object
	 */
	public function addServer($host = '127.0.0.1', $port = 11211, $weight = 100)
	{
		$this->servers[] = ['host' => $host, 'port' => $port, $weight => 100];

		return $this;
	}

	/**
	 * Resets the list of servers and allows adding new servers
	 *
	 * @param  array  $array  Pass empty array to reset the list. Pass an array of associative arrays to set several servers [['host' => '127.0.0.1', 'port' => 11211, 'weight' => 100]]. All keys must be present.
	 *
	 * @return  \Foolz\Cache\Config\Memcached  The current object
	 * @throws  \InvalidArgumentException             If a key wasn't specified in the array
	 */
	public function setServers(Array $array = [])
	{
		// empty the array
		$this->servers = [];

		$keys = ['host', 'port', 'weight'];

		foreach ($array as $server)
		{
			foreach ($keys as $key)
			{
				if ( ! isset($server[$key]))
				{
					throw new \InvalidArgumentException('Missing array key: '.$key);
				}
			}

			$this->addServer($server['host'], $server['port'], $server['weight']);
		}

		return $this;
	}
}
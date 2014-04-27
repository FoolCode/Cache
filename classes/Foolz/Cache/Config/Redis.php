<?php

namespace Foolz\Cache\Config;

use Predis\Client;
use Predis\CommunicationException;

class Redis extends \Foolz\Cache\Config
{
    /**
     * The name of the storage engine
     *
     * @var  string
     */
    protected $storage = 'redis';

    /**
     * The Memcached object
     *
     * @var  Client
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
            'port' => 6379
        ]
    ];

    public $preferences = [];

    /**
     * Returns the connected Memcached object
     *
     * @return  Client         The connected Memcached
     * @throws  \RuntimeException  In case the servers can't be contacted
     */
    public function getConnection()
    {
        if ($this->connection === null)
        {
            $this->connection = new Client($this->servers);

            try {
                $this->connection->connect();
            }
            catch (CommunicationException $exception) {
                throw new \RuntimeException('The Redis server could not be reached.');
            }
        }

        return $this->connection;
    }

    /**
     * Adds a server to the array of available servers
     *
     * @param  array|string  $mixed  Server details
     *
     * @return  \Foolz\Cache\Config\Redis  The current object
     */
    public function addServer($mixed)
    {
        $this->servers[] = $mixed;

        return $this;
    }

    /**
     * Resets the list of servers and allows adding new servers
     *
     * @param  array  $array  Pass empty array to reset the list. Pass an array of associative arrays to set several servers [['host' => '127.0.0.1', 'port' => 11211, 'weight' => 100]]. All keys must be present.
     *
     * @return  \Foolz\Cache\Config\Redis  The current object
     * @throws  \InvalidArgumentException             If a key wasn't specified in the array
     */
    public function setServers(Array $array = [])
    {
        // empty the array
        $this->servers = $array;

        return $this;
    }

    /**
     * Sets preferences for this Redis Client connection
     *
     * @param array $array The preferences that can be passed to predis
     */
    public function setPreferences(Array $array = [])
    {
        $this->preferences =$array;
    }
}

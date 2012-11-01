<?php

namespace Foolz\Cache\Config;

class Db extends \Foolz\Cache\Config
{
	/**
	 * The name of the storage engine
	 *
	 * @var  string
	 */
	protected $storage = 'db';

	/**
	 * The Doctrine DBAL Connection
	 *
	 * @var  \Doctrine\DBAL\Connection
	 */
	protected $connection = null;

	/**
	 * The name of the table where the storage is available
	 *
	 * @var  null|string
	 */
	protected $table = null;

	/**
	 * Set a Doctrine connection to use the database
	 *
	 * @param  \Doctrine\DBAL\Connection  $connection  A Doctrine DBAL Connection
	 *
	 * @return  \Foolz\Cache\Config\Db  The current object
	 */
	public function setConnection(\Doctrine\DBAL\Connection $connection)
	{
		$this->connection = $connection;

		return $this;
	}

	/**
	 * Returns the Doctrine DBAL connection
	 *
	 * @return  \Doctrine\DBAL\Connection
	 * @throws  \BadMethodCallException
	 */
	public function getConnection()
	{
		if ($this->connection === null)
		{
			throw new \BadMethodCallException('The connection wasn\'t set');
		}

		return $this->connection;
	}

	/**
	 * The table used for the storage
	 *
	 * @param  string  $string  The name of the table
	 *
	 * @return \Foolz\Cache\Config\Db
	 */
	public function setTable($table)
	{
		$this->table = $table;

		return $this;
	}

	/**
	 * Get the database table name
	 *
	 * @return  string                   The database table name
	 * @throws  \BadMethodCallException  In case the table wasn't set
	 */
	public function getTable()
	{
		if ($this->table === null)
		{
			throw new \BadMethodCallException('The database table wasn\'t set.');
		}

		return $this->table;
	}

}
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

	/**
	 * Creates the table necessary to store the cache
	 * Notice that MySQL must be >5.5 and it will use utf8mb4/utf8mb4_general_ci for extra compatibility with 4byte characters
	 * It is suggested to copy this code in your application to customize it further.
	 *
	 * @return  \Foolz\Cache\Config\Db   The current
	 * @throws  \BadMethodCallException
	 */
	public function createTable()
	{
		if ($this->getTable() === null)
		{
			throw new \BadMethodCallException('The name of the table wasn\'t set.');
		}

		$sm = $this->getConnection()->getSchemaManager();

		$schema = $sm->createSchema();
		$table = $schema->createTable($this->getTable());

		if ($this->getConnection()->getDriver()->getName() == 'pdo_mysql')
		{
			$table->addOption('charset', 'utf8mb4');
		}

		$table->addColumn('id', 'integer', ['unsigned' => true, 'autoincrement' => true, 'notnull' => false]);
		$table->addColumn('key', 'string', ['length' => 128]);
		$table->addColumn('value', 'text');
		$table->addColumn('created', 'integer', ['unsigned' => true]);
		$table->addColumn('expiration', 'integer', ['unsigned' => true]);
		$table->setPrimaryKey(['key']);
		$table->addUniqueIndex(['key'], 'key_index');

		$sql_arr = $schema->getMigrateFromSql($sm->createSchema(), $sm->getDatabasePlatform());

		foreach ($sql_arr as $sql)
		{
			$this->getConnection()->query($sql);
		}

		return $this;
	}
}
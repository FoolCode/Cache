<?php

require_once __DIR__.'/Storage.php';

use \Foolz\Cache\Cache,
	\Foolz\Cache\Config;

class DbTest extends Storage
{
	public $storage = 'db';

	public function setUp()
	{
		$connection = \Doctrine\DBAL\DriverManager::getConnection(['pdo' => new PDO('sqlite::memory:')]);

		$config = Config::forgeDb()
			->setTable('testing')
			->setConnection($connection)
			->createTable()
			->setFormat('smart_json');

		Cache::instantiate($config);
	}
}
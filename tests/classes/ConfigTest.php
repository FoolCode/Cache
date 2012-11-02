<?php

use \Foolz\Cache\Config;

class ConfigTest extends PHPUnit_Framework_TestCase
{
	public function testForge()
	{
		$this->assertInstanceOf('Foolz\Cache\Config\Dummy', Config::forge('dummy'));
	}

	/**
	 * @expectedException \DomainException
	 */
	public function testForgeThrows()
	{
		Config::forge('thiscouldntexist');
	}

	public function testForgeStorage()
	{
		$this->assertInstanceOf('Foolz\Cache\Config\Dummy', Config::forgeDummy());
		$this->assertInstanceOf('Foolz\Cache\Config\Volatile', Config::forgeVolatile());
		$this->assertInstanceOf('Foolz\Cache\Config\Apc', Config::forgeApc());
		$this->assertInstanceOf('Foolz\Cache\Config\Db', Config::forgeDb());
		$this->assertInstanceOf('Foolz\Cache\Config\File', Config::forgeFile());
		$this->assertInstanceOf('Foolz\Cache\Config\Memcached', Config::forgeMemcached());
	}
}
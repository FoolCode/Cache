<?php

require_once __DIR__.'/Storage.php';

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

	public function testGetStorage()
	{
		$this->assertSame('dummy', Config::forgeDummy()->getStorage());
	}

	/**
	 * @expectedException \BadMethodCallException
	 */
	public function testGetStorageThrows()
	{
		$this->assertSame('dummy', (new Config())->getStorage());
	}

	public function testGetSetFormat()
	{
		$config = Config::forgeDummy();
		$config->setFormat('plain');
		$this->assertInstanceOf('Foolz\Cache\Format\Plain', $config->getFormat());
	}

	/**
	 * @expectedException \DomainException
	 */
	public function testSetFormat()
	{
		$config = Config::forgeDummy();
		$config->setFormat('thisbetternotexist');
	}

	/**
	 * @expectedException \BadMethodCallException
	 */
	public function testGetFormat()
	{
		$config = Config::forgeDummy();
		$config->getFormat();
	}

	public function testGetSetPrefix()
	{
		$config = Config::forgeDummy();
		$config->setPrefix('foolz_');
		$this->assertSame('foolz_', $config->getPrefix());
	}

	public function testGetSetThrow()
	{
		$config = Config::forgeDummy();
		$this->assertFalse($config->getThrow());
		$config->setThrow(true);
		$this->assertTrue($config->getThrow());
		$config->setThrow(false);
		$this->assertFalse($config->getThrow());
	}
}
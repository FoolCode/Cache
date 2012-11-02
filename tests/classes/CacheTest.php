<?php

use \Foolz\Cache\Cache,
	\Foolz\Cache\Config;

class CacheTest extends PHPUnit_Framework_TestCase
{
	public function testInstantiate()
	{
		$config = Config::forgeDummy();

		Cache::instantiate($config, 'dummydefault');

		// if it doesn't exist, it will error - we don't want it to error
		Cache::item('just_testing', 'dummydefault');

		Cache::destroy('dummydefault');
	}

	/**
	 * @expectedException \OutOfRangeException
	 */
	public function testDestroy()
	{
		Cache::instantiate(Config::forgeDummy(), 'dummydefault');
		Cache::destroy('dummydefault');

		Cache::item('just_testing', 'dummydefault');
	}

	public function testForge()
	{
		Cache::instantiate(Config::forgeDummy(), 'dummydefault');
		$this->assertInstanceOf('Foolz\Cache\Cache', Cache::forge('dummydefault'));
	}

	public function testItem()
	{
		Cache::instantiate(Config::forgeDummy(), 'dummydefault');
		$item = Cache::item('just_testing', 'dummydefault');

		$this->assertSame('just_testing', $item->getKey());
	}

	public function testGetSetConfig()
	{
		$dummy = Config::forgeDummy();
		Cache::instantiate($dummy, 'dummydefault');

		$this->assertSame($dummy, Cache::forge('dummydefault')->getConfig());

		$apc = Config::forgeApc();
		$instance = Cache::forge('dummydefault')->setConfig($apc);

		$this->assertSame($apc, $instance->getConfig());
	}

	public function testGetEngine()
	{
		Cache::instantiate(Config::forgeDummy(), 'dummydefault');
		$this->assertInstanceOf('Foolz\Cache\Storage', Cache::forge('dummydefault')->getEngine());
		$this->assertInstanceOf('Foolz\Cache\Storage\Dummy', Cache::forge('dummydefault')->getEngine());
	}

	public function testGetSetKey()
	{
		Cache::instantiate(Config::forgeDummy(), 'dummydefault');
		$forged = Cache::forge('dummydefault');

		$forged->setKey('test');
		$this->assertSame('test', $forged->getKey());

		$forged->setKey(123);
		$this->assertSame('123', $forged->getKey());
	}

	public function testGetSet()
	{
		Cache::instantiate(Config::forgeVolatile()->setFormat('plain'), 'volatiledefault');

		$this->assertSame(\Foolz\Cache\Void::forge(), Cache::item('test', 'volatiledefault')->get());

		Cache::item('test', 'volatiledefault')->set('the_value', 0);

		$this->assertSame('the_value', Cache::item('test', 'volatiledefault')->get());
	}

	public function testGetSetPrefix()
	{
		Cache::instantiate(Config::forgeVolatile()->setFormat('plain')->setPrefix('foolz_'), 'volatiledefault');

		$this->assertSame(\Foolz\Cache\Void::forge(), Cache::item('test', 'volatiledefault')->get());

		Cache::item('test', 'volatiledefault')->set('the_value', 0);

		$this->assertSame('the_value', Cache::item('test', 'volatiledefault')->get());
	}


	/**
	 * @expectedException \OutOfBoundsException
	 */
	public function testGetThrows()
	{
		Cache::instantiate(Config::forgeVolatile()->setFormat('plain')->setThrow(true), 'volatiledefault');

		$this->assertSame(\Foolz\Cache\Void::forge(), Cache::item('test1000', 'volatiledefault')->get());
	}

	public function testDelete()
	{
		Cache::instantiate(Config::forgeVolatile()->setFormat('plain'), 'volatiledefault');

		Cache::item('test', 'volatiledefault')->set('the_value', 0);
		Cache::item('test', 'volatiledefault')->delete();

		$this->assertSame(\Foolz\Cache\Void::forge(), Cache::item('test', 'volatiledefault')->get());
	}

	public function testFlush()
	{
		Cache::instantiate(Config::forgeVolatile()->setFormat('plain'), 'volatiledefault');

		Cache::item('test', 'volatiledefault')->set('the_value', 0);
		Cache::item('test2', 'volatiledefault')->set('the_value2', 0);
		Cache::item('test3', 'volatiledefault')->set('the_value3', 0);
		Cache::item('test4', 'volatiledefault')->set('the_value4', 0);
		Cache::forge('volatiledefault')->flush();

		$this->assertSame(\Foolz\Cache\Void::forge(), Cache::item('test', 'volatiledefault')->get());
		$this->assertSame(\Foolz\Cache\Void::forge(), Cache::item('test2', 'volatiledefault')->get());
		$this->assertSame(\Foolz\Cache\Void::forge(), Cache::item('test3', 'volatiledefault')->get());
		$this->assertSame(\Foolz\Cache\Void::forge(), Cache::item('test4', 'volatiledefault')->get());
	}
}
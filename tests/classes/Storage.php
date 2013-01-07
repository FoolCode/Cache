<?php

require_once __DIR__.'/Storage.php';

use \Foolz\Cache\Cache,
	\Foolz\Cache\Config;

class Storage extends PHPUnit_Framework_TestCase
{
	public $storage = '';

	public $format = 'smart_json';

	public function setUp()
	{
		Cache::instantiate(Config::forge($this->storage)->setFormat($this->format));
	}

	public function testGetSetConfig()
	{
		Cache::forge()->getEngine();
	}

	public function testGetVoid()
	{
		$this->assertSame(\Foolz\Cache\Void::forge(), Cache::item('bevoid')->get('shouldntexist'));
	}

	public function testGetSet()
	{
		Cache::item('getsetconfig')->set('value');
		$this->assertSame('value', Cache::item('getsetconfig')->get());
	}

	public function testDelete()
	{
		Cache::item('getsetconfig')->set('value');
		Cache::item('getsetconfig')->delete();

		$this->assertSame(\Foolz\Cache\Void::forge(), Cache::item('bevoid')->get('shouldntexist'));
	}

	public function testFlush()
	{
		Cache::item('getsetconfig1')->set('value');
		Cache::item('getsetconfig2')->set('value');
		Cache::item('getsetconfig3')->set('value');

		Cache::forge()->flush();

		$this->assertSame(\Foolz\Cache\Void::forge(), Cache::item('bevoid')->get('shouldntexist'));
	}
}
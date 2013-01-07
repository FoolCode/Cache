<?php

require_once __DIR__.'/Storage.php';

class FormatsTest extends PHPUnit_Framework_TestCase
{
	public function testArrayJson()
	{
		$format = new \Foolz\Cache\Format\ArrayJson;

		$obj = new stdClass();
		$obj->test = 'value';

		$result = $format->encode($obj);
		$this->assertSame(['test' => 'value'], $format->decode($result));

		$result = $format->encode(['test2' => 'value2']);
		$this->assertSame(['test2' => 'value2'], $format->decode($result));

		$result = $format->encode('string');
		$this->assertSame('string', $format->decode($result));

		$result = $format->encode(12345);
		$this->assertSame(12345, $format->decode($result));
	}

	public function testObjectJson()
	{
		$format = new \Foolz\Cache\Format\ObjectJson;

		$obj = new stdClass();
		$obj->test = 'value';

		$result = $format->encode($obj);
		$this->assertSame('value', $format->decode($result)->test);

		$result = $format->encode(['test2' => 'value2']);
		$this->assertSame('value2', $format->decode($result)->test2);

		$result = $format->encode('string');
		$this->assertSame('string', $format->decode($result));

		$result = $format->encode(12345);
		$this->assertSame(12345, $format->decode($result));
	}

	public function testSmartJson()
	{
		$format = new \Foolz\Cache\Format\SmartJson;

		$obj = new stdClass();
		$obj->test = 'value';

		$result = $format->encode($obj);
		$this->assertSame('value', $format->decode($result)->test);

		$result = $format->encode(['test2' => 'value2']);
		$this->assertSame('value2', $format->decode($result)['test2']);

		$result = $format->encode('string');
		$this->assertSame('string', $format->decode($result));

		$result = $format->encode(12345);
		$this->assertSame(12345, $format->decode($result));
	}

	public function testSerialized()
	{
		$format = new \Foolz\Cache\Format\Serialized;

		$obj = new stdClass();
		$obj->test = 'value';

		$result = $format->encode($obj);
		$this->assertSame('value', $format->decode($result)->test);

		$result = $format->encode(['test2' => 'value2']);
		$this->assertSame('value2', $format->decode($result)['test2']);

		$result = $format->encode('string');
		$this->assertSame('string', $format->decode($result));

		$result = $format->encode(12345);
		$this->assertSame(12345, $format->decode($result));
	}
}
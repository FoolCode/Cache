<?php

require_once __DIR__.'/Storage.php';

class DummyTest extends Storage
{
	public $storage = 'dummy';

	public function testGetSet()
	{

	}
}
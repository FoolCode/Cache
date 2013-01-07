<?php

require_once __DIR__.'/Storage.php';

class ApcTest extends Storage
{
	public $storage = 'apc';
}
<?php

namespace Foolz\Cache\Format;

class ObjectJson extends \Foolz\Cache\Format
{
	public function encode($content)
	{
		return json_encode($content);
	}

	public function decode($string)
	{
		return json_decode($string);
	}
}
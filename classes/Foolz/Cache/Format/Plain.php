<?php

namespace Foolz\Cache\Format;

class Plain extends \Foolz\Cache\Format
{
	public function encode($content)
	{
		return $content;
	}

	public function decode($string)
	{
		return $string;
	}
}
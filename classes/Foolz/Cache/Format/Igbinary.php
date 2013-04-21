<?php

namespace Foolz\Cache\Format;

class Igbinary extends \Foolz\Cache\Format
{
	public function encode($content)
	{
		return igbinary_serialize($content);
	}

	public function decode($string)
	{
		return igbinary_unserialize($string);
	}
}
<?php

namespace Foolz\Cache;

abstract class Format
{
	/**
	 * Converts the string to the format
	 *
	 * @param  mixed  $content  The content to process
	 *
	 * @return  string  The encoded content in a string
	 */
	public abstract function encode($content);

	/**
	 * Converts the string from the format
	 *
	 * @param  string  $string  The string to process
	 *
	 * @return  mixed  The original content
	 */
	public abstract function decode($string);
}
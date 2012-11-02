<?php

namespace Foolz\Cache;

class Void
{
	/**
	 * We don't need more than one of these
	 *
	 * @var  \Foolz\Cache\Void
	 */
	public static $instance = null;

	/**
	 * Returns the instance of Void
	 *
	 * @return  \Foolz\Cache\Void  The instance
	 */
	public static function forge()
	{
		if (static::$instance === null)
		{
			static::$instance = new \Foolz\Cache\Void;
		}

		return static::$instance;
	}
}
<?php

namespace Foolz\Cache\Storage;

class File extends \Foolz\Cache\Storage
{
	/**
	 * Returns the configuration of the storage engine
	 *
	 * @return  \Foolz\Cache\Config\File
	 */
	public function getConfig()
	{
		return $this->config;
	}

	public function get($key)
	{
		$path = $this->getConfig()->getDir().urlencode($key);

		if (file_exists($path.'.cache'))
		{
			$result = file_get_contents($path.'.cache');
		}
		else
		{
			return \Foolz\Cache\Void::forge();
		}

		$expiration = 0;
		if (file_exists($path.'.expiration'))
		{
			$expiration = file_get_contents($path.'.expiration');
		}

		if ($expiration && time() < $expiration + filemtime($path.'.expiration'))
		{
			return \Foolz\Cache\Void::forge();
		}

		return $result;
	}

	public function set($key, $value, $expiration)
	{
		$path = $this->getConfig()->getDir().urlencode($key);

		file_put_contents($path.'.cache', $value);

		if ($expiration > 0)
		{
			file_put_contents($path.'.expiration', $value);
		}
		elseif (file_exists($path.'.expiration'))
		{
			unlink($path.'.expiration');
		}
	}

	public function delete($key)
	{
		$path = $this->getConfig()->getDir().urlencode($key);
		if (file_exists($path.'.cache'))
		{
			unlink($path.'.cache');
		}

		if (file_exists($path.'.expiration'))
		{
			unlink($path.'.expiration');
		}
	}

	public function flush()
	{
		static::flushDir($this->getConfig()->getDir());
	}

	/**
	 * Empties a directory
	 *
	 * @param  string  $path  The directory to empty
	 */
	protected static function flushDir($path)
	{
		$fp = opendir($path);

		while (false !== ($file = readdir($fp)))
		{
			// Remove '.', '..'
			if (in_array($file, array('.', '..')))
			{
				continue;
			}

			$filepath = $path.'/'.$file;

			if (is_dir($filepath))
			{
				static::flushDir($filepath);

				// removing dir here won't remove the root dir, just as we want it
				rmdir($filepath);
				continue;
			}
			else if (is_file($filepath))
			{
				unlink($filepath);
			}
		}

		closedir($fp);
	}
}
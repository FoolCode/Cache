<?php

namespace Foolz\Cache\Format;

class SmartJson extends Format
{
	public function encode($content)
	{
		if (is_object($content))
		{
			$content = ['type' => 'object', 'content' => $content];
		}
		else
		{
			$content = ['type' => 'array', 'content' => $content];
		}

		return json_encode($content);
	}


	public function decode($string)
	{
		$result = json_decode($string, true);

		// were we lucky to get array?
		if ($result['type'] === 'array')
		{
			return $result['content'];
		}

		// it actually was an object
		return json_decode($string)->content;
	}
}
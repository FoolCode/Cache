<?php

namespace Foolz\Cache\Format;

class ArrayJson extends \Foolz\Cache\Format
{
    public function encode($content)
    {
        return json_encode($content);
    }

    public function decode($string)
    {
        return json_decode($string, true);
    }
}

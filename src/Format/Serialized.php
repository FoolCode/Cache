<?php

namespace Foolz\Cache\Format;

class Serialized extends \Foolz\Cache\Format
{
    public function encode($content)
    {
        return serialize($content);
    }

    public function decode($string)
    {
        return unserialize($string);
    }
}

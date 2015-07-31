<?php

namespace Jules\Config\Adapter;

class Ini
{
    public static function parse($configFile)
    {
        return json_decode(json_encode(parse_ini_file($configFile, true)));;
    }
}
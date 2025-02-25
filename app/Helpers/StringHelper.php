<?php

namespace App\Helpers;

class StringHelper
{
    public static function getShortTitle($string, $length = 20, $append = "...")
    {
        return (strlen($string) > $length) ? substr($string, 0, $length) . $append : $string;
    }
}
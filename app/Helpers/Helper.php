<?php

    /**
     * Truncates a string to a specified length and appends a suffix if needed
     * 
     * @param string $string The input string to be shortened
     * @param int $length Maximum length of the output string (default: 20)
     * @param string $append String to append if truncation occurs (default: "...")
     * @return string Shortened string with append string if truncated
     */
    if (!function_exists('getShortTitle')) {
        function getShortTitle($string, $length = 20, $append = "...")
        {
            return (strlen($string) > $length) ? substr($string, 0, $length) . $append : $string;
        }
    }
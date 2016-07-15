<?php

namespace Note\Helpers;

class DataHelper
{
    /**
     * @param string $pattern
     * @param string $string
     * @return string
     */
    public static function strong($pattern, $string)
    {
        $result =  str_ireplace($pattern, "<strong>$pattern</strong>", $string);

        return $result;
    }
}
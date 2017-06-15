<?php

class Helper
{
    /**
     * @param string $fileName exm: css/style.css
     * @return string
     */
    public static function asset($fileName)
    {
        return URL.'/static/'.$fileName;
    }

    /**
     * @param string $fileName
     * @return array|mixed
     */
    protected static function resolveExtension($fileName)
    {
        $extension = explode('.',$fileName);
        $extension = end($extension);

        return $extension;
    }

    /**
     * @param string $pattern
     * @param string $string
     * @return string
     */
    public static function strong($pattern, $string)
    {
        $pattern = preg_quote($pattern, '/');
        return preg_replace("/$pattern/iu", "<strong>$0</strong>", $string, 1);
    }

    /**
     * @param $string
     * @return string|mixed
     */
    public static function escapeLike($string)
    {
        $search = array( '\\', '%', '_');
        $replace   = array('\\\\\\', '\%', '\_');

        return str_replace($search, $replace, $string);
    }
}

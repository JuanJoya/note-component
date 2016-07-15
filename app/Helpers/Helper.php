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
}

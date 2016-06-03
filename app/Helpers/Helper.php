<?php

class Helper
{
    public static function asset($fileName)
    {
        return URL.'/static/'.$fileName;
    }

    protected static function resolveExtension($fileName)
    {
        $extension = explode('.',$fileName);
        $extension = end($extension);

        return $extension;
    }
}

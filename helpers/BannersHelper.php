<?php

/**
 *
 */
class BannersHelper
{
    /**
     * @return array|false
     */
    private static function getFiles()
    {
        return array_diff(scandir(App::site()->bannersPath), ['.', '..']);

    }

    /**
     * @return string
     */
    public static function randomImage()
    {
        $files = self::getFiles();
        return  App::site()->bannersPath . '/' . $files[array_rand($files)];

    }
}
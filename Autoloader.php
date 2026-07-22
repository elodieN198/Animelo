<?php

namespace App;

class Autoloader
{
    public static function register()
    {
        spl_autoload_register([self::class, 'autoload']);
    }

    public static function autoload($class)
    {
        $class = str_replace('App\\', '', $class);
        $class = str_replace('\\', '/', $class);
        $file = __DIR__ . '/App/' . $class . '.php';

        if (file_exists($file)) {
            require $file;
        }
    }
}
<?php

/*
 * This work is license under
 * Creative Commons Attribution-ShareAlike 3.0 Unported License
 * http://creativecommons.org/licenses/by-sa/3.0/
 */

spl_autoload_register(function($class)
{
    $file = __DIR__.'/../src/'.strtr($class, '\\', '/').'.php';
    if (file_exists($file)) {
        require $file;
        return true;
    }
});

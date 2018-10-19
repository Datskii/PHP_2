<?php

namespace app\services;

class Autoloader
{
    public function loadClass($className)
    {
        $className = str_replace(["app\\", "\\"], [ROOT_DIR, '/'], $className);
        $className .= ".php";

        if (file_exists($className)) {
            include $className;
        }
    }

}
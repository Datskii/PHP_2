<?php

// Поключаем файлы конфигурации и функции.
require __DIR__ . "/../config/config.php";


// Подключаем класс автозагрузки.
include $_SERVER['DOCUMENT_ROOT'] . "/../services\Autoloader.php";

// Регистрируем заданную функцию в качестве автозагрузчика классов.
spl_autoload_register([new app\services\Autoloader('app'), 'loadClass']);

// Получаем имена controller and action.
$controllerName = $_GET['c'] ?: DEFAULT_CONTROLLER;
$actionName = $_GET['a'];

// Получаем имя класса.
$controllerClass = CONTROLLERS_NAMESPACE . "\\" . ucfirst($controllerName) . "Controller";

if (class_exists($controllerClass)) {
    $controller = new $controllerClass;
    $controller->run($actionName);
}
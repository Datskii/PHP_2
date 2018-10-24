<?php

namespace app\services;

/**
 * Class Autoloader отвечает за подключение требуемого класса.
 * @package services
 */
class Autoloader
{
    /** @var - Префикс к пространству имен. */
    private $prefix;

    /**
     * Autoloader constructor.
     * @param $prefix - Префикс, который добавляем к пространству имен.
     */
    public function __construct($prefix)
    {
        $this->prefix = $prefix;
    }

    /**
     * Метод получает полное имя класса с пространствами имен (если они есть), вырезает из него
     * заданный префикс 'app',а из полученного результата формирует путь к файлу класса
     * и подключает его.
     * @param $className - Имя класса (и пространства имен), которое требуется загрузить.
     */
    public function loadClass($className)
    {
        // Проверяем использует ли класс namespace prefix.
        $len = strlen($this->prefix);
        if (strncmp($this->prefix, $className, $len) !== 0) {
            // Если нет то выходим из автозагрузчика.
            return;
        }
        // Получаем относительное имя класса.
        $relative_class = substr($className, $len);
        // Создаем путь до файла с искомым классом.
        $fileName = $_SERVER['DOCUMENT_ROOT'] . "/../" . $relative_class . ".php";
        // Если файл существует, то подключаем его.
        if (file_exists($fileName)) {
            require $fileName;
        }
    }
}
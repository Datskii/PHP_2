<?php

namespace app\services;

use app\traits\TSingleton;

/**
 * Class Db - Содержит свойства и методы отвечающие за соединение с базой данных.
 * @package app\services
 */
class Db
{
    // Поключаем trait Singleton.
    use TSingleton;

    /** @var array - Массив параметров для соединения с базой данных. */
    private $config = [
        'driver' => 'mysql',
        'host' => 'localhost',
        'login' => 'root',
        'password' => '',
        'database' => 'geek_advanced',
        'charset' => 'utf8',
    ];

    /** @var null|array - Массив таблиц в базе данных */
    private $arrTables = null;

    /** @var null|array - Ассоциативный массив из всех таблиц и их полей в базе данных. */
    private $arrColumnsInTables = null;

    /** @var null - Свойство в котором будет храниться соединение с базой данных. */
    protected $conn = null;

    /**
     * Метод проверяет установлено ли соединение между PHP и сервером базы данных. Если соединение не установлено, то
     * устанавливает и возвращает его. Если соединение уже установлено, просто возвращает его.
     * @return null|\PDO соединение между PHP и сервером базы данных.
     */
    protected function getConnection() {
        if (is_null($this->conn)) {
            $this->conn = new \PDO(
                $this->prepareDsnString(),
                $this->config['login'],
                $this->config['password']
            );
            $this->conn->setAttribute(
                \PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC
            );
        }
        return $this->conn;
    }

    /**
     * Приватный метод возвращает подготовленную строку DSN.
     * @return string
     */
    private function prepareDsnString(): string {
        return sprintf("%s:host=%s;dbname=%s;charset=%s",
            $this->config['driver'],
            $this->config['host'],
            $this->config['database'],
            $this->config['charset']
        );
    }

    /**
     * Метод выполняет выполняет подготовленный запрос и возвращает результирующий набор.
     * @param string $sql - Строка запроса.
     * @param array $params - Параметры к переменным запроса.
     * @return bool|\PDOStatement Возвращается результирующий набор или false в случае неудачи.
     */
    private function query($sql, array $params = []) {
        $pdoStatement = $this->getConnection()->prepare($sql);
        $pdoStatement->execute($params);
        return $pdoStatement;
    }

    /**
     * Метод возвращает из базы строку в виде заданном в режиме выборки.
     * @param string $sql - Строка запроса.
     * @param array $params - Параметры к переменным запроса.
     * @return mixed В случае успешного выполнения возвращается значение в зависти от режима выборки,
     * в случае неудачи, возвращает false.
     */
    public function queryOne(string $sql, array $params = []) {
        return $this->query($sql, $params)->fetch();
    }

    /**
     * Метод возвращает из базы строки в виде заданном в режиме выборки.
     * @param string $sql - Строка запроса.
     * @param array $params - Параметры к переменным запроса.
     * @return array Возвращает массив, содержащий все строки результирующего набора в виде заданном в режиме выборки.
     */
    public function queryAll(string $sql, array $params = []) {
        return $this->query($sql, $params)->fetchAll();
    }

    /**
     * Метод возвращает результат выборки в виде объекта заданного класса.
     * @param string $sql - Строка запроса.
     * @param $class - Класс от которого будет создан объект выборки.
     * @param array $params - Параметры к переменным запроса.
     * @return mixed Возвращает результат в виде объекта, имена свойств которого совпадают с именами столбцов.
     */
    public function queryObject(string $sql, $class, array $params = []) {
        $smtp = $this->query($sql, $params);
        $smtp->setFetchMode(\PDO::FETCH_CLASS, $class);
        return $smtp->fetch();
    }

    /**
     * Метод возвращает массив результатов выборки в виде объектов заданного класса.
     * @param string $sql - Строка запроса.
     * @param $class - Класс от которого будет создан объект выборки.
     * @param array $params - Параметры к переменным запроса.
     * @return array Возвращает массив результатов выборки в виде объектов, имена свойств которых совпадают с именами
     *   столбцов.
     */
    public function queryArrObject(string $sql, $class, array $params = []) {
        $smtp = $this->query($sql, $params);
        $smtp->setFetchMode(\PDO::FETCH_CLASS, $class);
        return $smtp->fetchAll();
    }

    /**
     * Метод позволяет выполнять запросы не связанные с выборкой данных и возвращением результатов.
     * @param string $sql - Строка запроса.
     * @param array $params - Параметры к переменным запроса.
     */
    public function execute(string $sql, array $params = []) {
        $this->query($sql, $params);
    }

    /**
     * Метод возвращает ID последней вставленной строки в базу данных.
     * @return string Возвращает ID последней вставленной строки в базу данных.
     */
    public function lastInsertId(){
        return $this->getConnection()->lastInsertId();
    }

    /**
     * Метод проверяет наличие массива всех таблиц базы данных в переменной.
     * Если есть, то возвращает его, если нет получает.
     * @return array Возвращает массив всех таблиц в базе данных.
     */
    public function getArrTables() {
        if (is_null($this->arrTables)) {
            return $this->arrTables();
        }
        return $this->arrTables;
    }

    /**
     * Метод возвращает список всех полей заданной таблицы. Метод проверяет существование таблицы в базе данных, если
     * есть, то проверяет получены ли уже для этой таблицы поля, если да, то возвращает их, если нет, то получает их.
     * @param $table - Название таблицы для которой нужно получить список полей.
     * @return array Список полей таблицы.
     */
    public function getArrColumnsInTable($table) {
        // Если заданная таблица существует в базе данных, то возвращаем массив полей в ней.
        if (in_array($table, $this->getArrTables())) {
            if (is_null($this->arrColumnsInTables) || !array_key_exists($table, $this->arrColumnsInTables)) {
                $this->arrAllColumnsInTable($table);
            }
            return $this->arrColumnsInTables[$table];
        }
    }

    /**
     * Метод возвращает массив всех таблиц в базе данных.
     * @return array Список таблиц.
     */
    private function arrTables() {
        $smtp = $this->query("SHOW TABLES;");
        $this->arrTables = $smtp->fetchAll(\PDO::FETCH_COLUMN);
        return $this->arrTables;
    }

    /**
     * Метод возвращает список всех полей заданной таблицы.
     * @param $table - Название таблицы для которой нужно получить список полей.
     * @return array Список полей таблицы.
     */
    private function arrColumns($table) {
        $smtp = $this->query("DESCRIBE {$table}");
        return $smtp->fetchAll(\PDO::FETCH_COLUMN);
    }

    /**
     * Метод получает все поля заданной таблицы и добавляет их в общий ассоциативный массив.
     * @param $table - Название таблицы для которой нужно получить список полей.
     */
    private function arrAllColumnsInTable($table) {
        $this->arrColumnsInTables[$table] = $this->arrColumns($table);
    }

}
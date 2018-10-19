<?php

namespace app\services;

use app\traits\TSingleton;

class Db
{
    use TSingleton;

    private $config = [
        'driver' => 'mysql',
        'host' => 'localhost',
        'login' => 'root',
        'password' => '',
        'database' => 'shop_basket',
        'charset' => 'utf8'
    ];

    protected $conn = null;

    protected function getConnection()
    {
        if (is_null($this->conn)) {
            $this->conn = new \PDO(
                $this->prepareDsnString(),
                $this->config['login'],
                $this->config['password']
            );

            $this->conn->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
        }

        return $this->conn;
    }

    // "SELECT * FROM products WHERE id = :id"  0 OR 1 = 1

    /*
     * [ ':id' => 1]
     */
    private function query(string $sql, array $params = [])
    {
        /** @var \PDOStatement $pdoStatement */
        $pdoStatement = $this->getConnection()->prepare($sql);
        $pdoStatement->execute($params);
        return $pdoStatement;
    }

    public function queryOne(string $sql, array $params = [])
    {
        return $this->queryAll($sql, $params)[0];
    }

    public function queryAll(string $sql, array $params = [])
    {
        return $this->query($sql, $params)->fetchAll();
    }

    public function queryObject($sql, $params = [], $class)
    {
        $smtp = $this->query($sql, $params);
        $smtp->setFetchMode(\PDO::FETCH_CLASS, $class);
        return $smtp->fetch();
    }

    public function execute(string $sql, array $params = [])
    {
        $this->query($sql, $params);
    }
    public function lastInsertId(){
        return $this->getConnection()->lastInsertId();
    }

    private function prepareDsnString(): string
    {
        //mysql:host=$host;dbname=$db;charset=$charset
        return sprintf("%s:host=%s;dbname=%s;charset=%s",
            $this->config['driver'],
            $this->config['host'],
            $this->config['database'],
            $this->config['charset']
        );
    }
}
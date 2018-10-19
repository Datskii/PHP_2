<?php

namespace app\models;

use app\services\Db;

abstract class Model implements IModel
{
    private $db;

    public function __construct()
    {
        $this->db = Db::getInstance();
    }

    public function getOne($id)
    {
        $table = $this->getTableName();
        $sql = "SELECT * FROM {$table} WHERE id = :id";
        return $this->db->queryObject($sql, [':id' => $id], get_called_class());
    }

    public function getAll()
    {
        $table = $this->getTableName();
        $sql = "SELECT * FROM {$table}";
        return $this->db->queryAll($sql);
    }

    public function delete()
    {
        $table = $this->getTableName();
        $sql = "DELETE FROM {$table} where id = :id";
        $this->db->execute($sql, [':id' => $this->id]);
    }

    public function insert()
    {
        $columns = [];
        $params = [];

        foreach ($this as $key => $value) {
            if ($key == "db") {
                continue;
            }
            $params[":{$key}"] = $value;
            $columns[] = "{$key}";
        }
        $columns = implode(",", $columns);
        $placeholders = implode(",", array_keys($params));

        $table = $this->getTableName();
        $sql = "INSERT INTO {$table}({$columns}) VALUES ({$placeholders})";
        $this->db->execute($sql, $params);
        $this->id = $this->db->lastInsertId();
        var_dump($sql);
    }

    public function update()
    {
        $table = $this->getTableName();
        $sql = "SELECT * FROM {$table} WHERE id = :id";
        $lastData = Db::getInstance()->queryOne($sql, [':id' => $this->id]);
        $arr = $this->getValues();
        $values = $arr['values'];
        $newData = [];
        foreach ($lastData as $key => $value) {
            if ($values[$key] != $value) {
                $newData[$key] = $values[$key];
            }
        }
        $sql = "UPDATE {$table} SET ";
        $sqlArr = [];
        foreach ($newData as $key => $data) {
            array_push($sqlArr, "$key = '$data'");
        }
        $sql .= implode(", ", $sqlArr) . " where id = {$this->id}";
        $this->db->execute($sql, $values);
    }

    public function save(){
        if (is_null($this->id)) {
			return $this->insert();
		} else {
            return $this->update();
        }
    }


}

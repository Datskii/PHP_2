<?php

namespace app\models;

/**
 * Interface IModel
 * @package app\models
 */
interface IModel
{
    /** Метод получает из базы данных элемент и возвращает его в виде объекта класса. */
    public static function getOne($id);

    /** Метод получает из базы данных массив элементов и возвращает их в виде объекта класса. */
    public static function getAll();

    /** Метод возвращает название таблицы в базе данных для текущего класса. */
    public static function getTableName();

    /** Метод удаляет из базы данных информацию о текущем объекте. */
    public function delete();

    /** Метод вставляет данные текущего объекта в базу данных. */
    public function insert();

    /** Метод обновляет данные текущего объекта в базе данных. */
    public function update();

    /** Метод определяет какую операцию нужно запустить для объекта: insert или update */
    public function save();

}
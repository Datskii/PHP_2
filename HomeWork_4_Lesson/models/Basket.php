<?php

namespace app\models;

/**
 * Class Basket определяет свойства и методы для работы с корзиной.
 * @package app\models
 */
class Basket extends DataModel
{
    public $id;
    public $id_prod;
    public $id_user;
    public $amount;

    /**
     * Метод возвращает название таблицы в базе данных для текущего класса.
     * @return string Название таблицы для данного класса.
     */
    public static function getTableName()
    {
        return "basket";
    }
}
<?php

namespace app\models;

/**
 * Class Product определяет свойства и методы для работы с товарами. Получение информации о товарах в каталоге,
 * подробную информацию о товаре, изменение и удаление товара и т.д.
 * @package app\models
 */
class Product extends DataModel
{
    protected $id;
    protected $name;
    protected $description;
    protected $price;
    protected $img;
    protected $hide;

    /**
     * Метод возвращает название таблицы в базе данных для текущего класса.
     * @return string Название таблицы для данного класса.
     */
    public static function getTableName()
    {
        return 'products';
    }

    /**
     * Функция получает список фотографий товара из базы и возвращает его.
     * @param int $id - id конкретного товара.
     * @return array|null Возвращается список фотографий конкретного товара в виде ассоциативного массива.
     */
    public function getProductImg($id)
    {
        // Составляем строку запроса.
        $sql = "SELECT img FROM product_img wHERE id_prod = :id_prod";
        // Выполняем наш запрос.
        return $this->db->queryAll($sql, [':id_prod' => $id]);
    }
}
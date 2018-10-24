<?php
namespace app\controllers;

use app\models\Basket;

/**
 * Class BasketController
 * @package app\controllers
 */
class BasketController extends Controller
{
    /**
     * Метод выводит html страницу корзины.
     */
    public function actionIndex(){
        // Получаем объект товара.
        $model = Basket::getAll();
        // Выводим html страницу с полным описание товара.
        echo $this->render("basket", ["model"=>$model]);
    }

}
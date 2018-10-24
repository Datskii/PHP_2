<?php

namespace app\controllers;

use app\models\Product;


/**
 * Class ProductController
 * @package app\controllers
 */
class ProductController extends Controller
{
    /**
     * Метод выводит html страницу каталога.
     */
    public function actionIndex(){
        // Получаем объект товара.
        $model = Product::getAll();
        // Выводим html страницу с полным описание товара.
        echo $this->render("catalog", ["model"=>$model]);
    }

    /**
     * Метод выводит html страницу с полным описание товара.
     */
    public function actionCard(){
        // Получаем ID товара.
        $id = $_GET["id"];
        // Получаем объект товара.
        $model = Product::getOne($id);
        // Получаем массив картинок для товара.
        $modelImg = $model->getProductImg($id);
        // Выводим html страницу с полным описание товара.
        echo $this->render("card", ["model"=>$model,"modelImg"=>$modelImg]);
    }
}
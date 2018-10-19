<?php

include $_SERVER['DOCUMENT_ROOT'] . "/../config/main.php";
include ROOT_DIR . "services/Autoloader.php";

spl_autoload_register([new \app\services\Autoloader(), 'loadClass']);



$product = new \app\models\Product();
//$product= $product->getOne(2);
//$product->name = "Video-card";
//$product->description = "Видеокарта GeForce RTX 2080 TI 'NVIDIA'";
//$product->price = '400';
//$product->delete();



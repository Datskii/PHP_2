<?php
class Product
{
    public $id;
    public $article;
    public $category;
    public $title;
    public $description;
    public $price;
    public $guarantee;
    public $country;
    public $count;
    public function __construct($article, $category, $title, $description, $price, $guarantee, $country, $count)
    {
        $this->article = $article;
        $this->category = $category;
        $this->title = $title;
        $this->description = $description;
        $this->price = $price;
        $this->guarantee = $guarantee;
        $this->country = $country;
        $this->count = $count;
    }
    public function view()
    {
        echo "
            <hr><h2>Карточка товара</h2>
            <b>Артикул:</b> $this->article<br>
            <b>Категория:</b> $this->category<br>
            <b>Наименование:</b> $this->title<br>
            <b>Описание:</b> $this->description<br>
            
            
            <b>Цена:</b> $this->price руб.<br>
            <b>Гарантия:</b> $this->guarantee мес.<br>
            <b>Страна-производитель:</b> $this->country<br>
            <b>Количество на складе:</b> $this->count шт.<br>
        ";
    }
    // Списание товара со склада
    public function removeFromStock($number)
    {
        echo "<hr><h2>Списание со склада</h2>";
        if (($this->count - $number) < 0) {
            echo "<b>Недостаточное количество товара на складе для списания: $number шт.!</b><br>";
        } else {
            $this->count -= $number;
            echo "<b>Списание товара $this->title в количестве $number шт. выполнено успешно!</b><br>";
        }
        echo "<b>Остаток на складе:</b> $this->count шт.<br>";
    }
}
// Уцененый товар (брак, не комплект)
class Discount extends Product
{
    public $state;
    public $complete;
    public $functionality;
    public $package;
    public $reason;
    function __construct($article, $category, $title, $description, $price, $guarantee, $country, $count,
                         $state, $complete, $functionality)
    {
        parent::__construct($article, $category, $title, $description, $price, $guarantee, $country, $count);
        $this->state = $state;
        $this->complete = $complete;
        $this->functionality = $functionality;
    }
    public function view()
    {
        parent::view();
        echo "
            <b>Состояние:</b> $this->state<br>
            <b>Комплектность:</b> $this->complete<br>
            <b>Функциональность:</b> $this->functionality<br>";

    }
}
/*Стандартный товар*/
$good1 = new Product(326166, "Неттопы", "Lenovo ThinkCentre M710q",
    "ПЭВМ Lenovo ThinkCentre M710q <10MRS04600> Intel Core i3-7100T 4ГБ RAM 128Гб SSD DOS",
    28087, 12, "Китай", "7");
$good1->view();
$good1->removeFromStock(10);
$good1->removeFromStock(2);
/*Уцененный товар*/
$good2 = new Discount(4142497, "Ноутбуки", "MSI GT72 2QE-1488RU Dominator Pro, 9S7-178131-1488",
    "MSI GT72 2QE-1488RU Dominator Pro, 9S7-178131-1488, 17.3\" (1920x1080), 12GB, 1000GB, Intel Core i7-5700HQ(2.7), DVD±RW DL, 4GB NVIDIA GeForce GTX980M, LAN, WiFi, Bluetooth, Win8.1; Отремонтированный",
    82830, 2, "Китай", 2,
    "незначительные следы эксплуатации (мелкие потертости, царапины)", "полная", "полностью исправен");
$good2->view();
$good2->removeFromStock(3);
$good2->removeFromStock(1);
var_dump($good1);
var_dump($good2);
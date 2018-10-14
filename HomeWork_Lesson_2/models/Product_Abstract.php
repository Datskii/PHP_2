<?php


namespace app\models;


abstract class Product_Abstract extends Model
{

    public $article;
    public $category;
    public $title;
    public $description;
    public $size;
    public $weight;
    public $guarantee;
    public $country;
    public $count;
    public $total;



    public function __construct($article = null, $category = null, $title = null, $description = null,
                                $size = null, $weight = null, $guarantee = null, $country = null,
                                $count = null, $total = null)
    {
        $this->article = $article;
        $this->category = $category;
        $this->title = $title;
        $this->description = $description;
        $this->size = $size;
        $this->weight = $weight;
        $this->guarantee = $guarantee;
        $this->country = $country;
        $this->count = $count;
        $this->total = $total;
    }

    abstract public function getPrice($number);

    public function getTotal()
    {
        return $this->total;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Datskii
 * Date: 20.10.2018
 * Time: 2:09
 */

namespace app\models;


class Category extends Model
{
    protected $id;
    public $name;
    public $description;

    public function __construct($name, $description)
    {
        parent::__construct();
        $this->name = $name;
        $this->description = $description;
    }


    public function getTableName()
    {
        return 'category';
    }
}
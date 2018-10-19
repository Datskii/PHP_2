<?php


namespace app\models;


class Order extends Model
{
    protected $id;
    public $userId;
    public $cost;
    protected $status;
    protected $date;

    public function __construct($userId, $cost)
    {
        parent::__construct();
        $this->userId = $userId;
        $this->cost = $cost;
        $this->status = 'new';
        $this->date = date('H:m d-m-Y');
    }
    public function getTableName()
    {
        return 'order';
    }
}
<?php


class Purchase
{
    private  $conn;
    private $table='purchases';
    //User Prop
    public $id;
    public $user_id;
    public $d_id;
    public $d_price;
    public $created_at;


    //Constructor with DB
    public function __construct($db)
    {
        $this->conn=$db;
    }
}
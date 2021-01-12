<?php


class Dress
{
    private $conn;
    private $table = 'dress';
    //User Prop
    public $d_id;
    public $d_type;
    public $d_color;
    public $d_price;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    function getDress()
    {
        $query = "Select * from " . $this->table;
        $stmt = $this->conn->prepare($query);
        if ($stmt->execute()) {
            return true;
        }
    }
    function deleteDress()
    {
        $query = "delete from " . $this->table ."where d_id = ".$this->d_id;
        $stmt = $this->conn->prepare($query);
        if ($stmt->execute()) {
            return true;
        }
    }
}
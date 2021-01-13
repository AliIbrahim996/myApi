<?php


class Dress
{
    private $conn;
    private $table = 'dress';
    //Dress Prop
    public $d_id;
    public $d_type;
    public $d_color;
    public $d_price;

    public function __construct($db)
    {
        $this->conn = $db;
    }
    function setDressInfo($d_id){
        $query = "Select * from " . $this->table.
            " where d_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $d_id);
        $stmt->execute();
        $num=$stmt->rowCount();
        if($num>0){
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->d_price=$row['d_price'];
            $this->d_id=$row['d_id'];
            $this->d_color=$row['d_color'];
            $this->d_type=$row['d_type'];
        }
    }
    function getDresses()
    {
        $query = "Select * from " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    function deleteDress()
    {
        $query = "delete from " . $this->table ." where d_id = ".$this->d_id;
        $stmt = $this->conn->prepare($query);
        if ($stmt->execute()) {
            return true;
        }
    }
    function addDress($data){
        $this->d_type = $data->d_type;
        $this->d_color = $data->d_color;
        $this->d_price = $data->d_price;
        // insert query
        $query = "INSERT INTO " . $this->table . "
            SET
                d_type = ?,
                d_color = ?,
                d_price = ?";

        // prepare the query
        $stmt = $this->conn->prepare($query);
        // sanitize
        $this->d_type=htmlspecialchars(strip_tags($this->d_type));
        $this->d_color=htmlspecialchars(strip_tags($this->d_color));
        $this->d_price=htmlspecialchars(strip_tags($this->d_price));
        // bind the values
        $stmt->bindParam(1, $this->d_type);
        $stmt->bindParam(2, $this->d_color);
        $stmt->bindParam(3, $this->d_price);
        if($stmt->execute()){
            return true;
        }
        return false;
    }
}
<?php


class Cart
{
    private  $conn;
    private $table='cart';
    //Cart Prop
    public $id;
    public $user_id;
    public $d_id;
    public $created_at;

    //Constructor with DB
    public function __construct($db)
    {
        $this->conn=$db;
    }

    public function setCartData($data){

        $this->d_id=$data->dress_id;
        $this->user_id=$data->user_id;
        $this->created_at=$data->created_at;

        $this->d_id=htmlspecialchars(strip_tags($this->d_id));
        $this->user_id=htmlspecialchars(strip_tags($this->user_id));
        $this->created_at=htmlspecialchars(strip_tags( $this->created_at));
    }

    public function insertData(){
        $query="Insert into ".$this->table."
        SET 
        user_id = ?,
        dress_id = ?,
        created_at = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1,$this->user_id);
        $stmt->bindParam(2,$this->d_id);
        $stmt->bindParam(4,$this->created_at);
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

}
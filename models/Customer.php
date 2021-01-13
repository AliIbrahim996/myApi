<?php


class Customer
{
    private  $conn;
    private $table='customer';
    //Customer Prop
    public $id;
    public $c_name;
    public $u_id;
    public $location;
    public $phoneNum;
    public $hasPaymentMethod;
    public $cardId;

    public function __construct($db)
    {
        $this->conn=$db;
    }

    function create($uId,$data){


        // insert query
        $query = "INSERT INTO " . $this->table . "
            SET
                user_id = ?,
                customer_name = ?,
                phoneNumber = ?,
                location = ?,
                hasPaymentMethod = ?,
                card_id = ?
               ";

        $this->u_id = $uId;
        $this->c_name=$data->c_name;
        $this->location=$data->c_location;
        $this->phoneNum=$data->c_phoneNum;
        $this->hasPaymentMethod = $data->hasPayMethod;
        $this->cardId = $data->cardId;

        // prepare the query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->u_id=htmlspecialchars(strip_tags($this->u_id));
        $this->c_name=htmlspecialchars(strip_tags($this->c_name));
        $this->phoneNum=htmlspecialchars(strip_tags($this->phoneNum));
        $this->location=htmlspecialchars(strip_tags($this->location));
        $this->hasPaymentMethod=htmlspecialchars(strip_tags($this->hasPaymentMethod));
        $this->cardId=htmlspecialchars(strip_tags($this->cardId));

        // bind the values
        $stmt->bindParam(1, $uId);
        $stmt->bindParam(2, $data->c_name);
        $stmt->bindParam(3, $data->c_phoneNum);
        $stmt->bindParam(4, $data->c_location);
        $stmt->bindParam(5, $data->hasPayMethod);
        $stmt->bindParam(6, $data->cardId);
        // execute the query, also check if query was successful
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    function getCustomeres(){
        $query="Select * from ".$this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }


    public function setUId($u_email)
    {
        $query= "select userID from users where user_email = ?";
        $stmt = $this->conn->prepare( $query );

        // bind value
        $stmt->bindParam(1, $u_email);
        $stmt->execute();
        $num=$stmt->rowCount();
        if($num>0){
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->u_id = $row['userID'];
        }
    }
    function delete($u_email){
        $this->setUId($u_email);
        $query= "Delete from ".$this->table
            ."where user_Id = ?";
        $stmt = $this->conn->prepare( $query );

        // bind value
        $stmt->bindParam(1, $this->u_id);
        // execute the query
        if($stmt->execute()){
            return true;
        }
        return false;
    }
    public function setCutomerInfo($email){
        $this->setUId($email);
        $query="select * from ".$this->table.
            "where user_id = ?";
        $stmt=$this->conn->prepare($query);
        $stmt->bindParam(1, $this->u_id);
        $stmt->execute();
        $num=$stmt->rowCount();
        if($num>0){
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->cardId=$row['card_id'];
            $this->hasPaymentMethod=$row['hasPaymentMethod'];
            $this->c_name=$row['customer_name'];
            $this->phoneNum=$row['phoneNumber'];
            $this->location=$row['location'];
        }
    }
    public function hasPaymentMethod()
    {
        return $this->hasPaymentMethod;
    }
}
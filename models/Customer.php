<?php


class Customer
{
    private  $conn;
    private $table='customer';
    //User Prop
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

    function getCustomer(){
        $query="Select * from ".$this->table;
        $stmt = $this->conn->prepare($query);
        if($stmt->execute()){
            return true;
        }

        return false;
    }

    function delete($u_id){
        $query= "Delete from ".$this->table
            ."where user_Id = ?";
        $stmt = $this->conn->prepare( $query );

        // bind value
        $stmt->bindParam(1, $u_id);

        // execute the query
        if($stmt->execute()){
            return true;
        }
        return false;
    }
}
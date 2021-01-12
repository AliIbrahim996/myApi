<?php

class User{
    private  $conn;
    private $table='users';
    //User Prop
    public $id;
    public $f_name;
    public $l_name;
    public $email;
    public $pass;


    //Constructor with DB
    public function __construct($db)
    {
        $this->conn=$db;
    }
    function getUsers(){
        $query="Select * from ".$this->table;
        $stmt = $this->conn->prepare($query);
        if($stmt->execute()){
            return true;
        }

        return false;
    }
    //Create user method
    function create(){

        // insert query
        $query = "INSERT INTO " . $this->table_name . "
            SET
                first_name = :firstname,
                last_name = :lastname,
                email = :email,
                password = :password";

        // prepare the query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->f_name=htmlspecialchars(strip_tags($this->f_name));
        $this->l_name=htmlspecialchars(strip_tags($this->l_name));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->pass=htmlspecialchars(strip_tags($this->pass));

        // bind the values
        $stmt->bindParam(':first_name', $this->f_name);
        $stmt->bindParam(':last_name', $this->l_name);
        $stmt->bindParam(':email', $this->email);

        // hash the password before saving to database
        $password_hash = password_hash($this->pass, PASSWORD_BCRYPT);
        $stmt->bindParam(':password', $password_hash);

        // execute the query, also check if query was successful
        if($stmt->execute()){
            return true;
        }

        return false;
    }
    function delete(){

    }
    function emailExists(){

        // query to check if email exists
        $query = "SELECT userId, first_name, last_name, password
            FROM " . $this->table_name . "
            WHERE email = ?
            LIMIT 0,1";

        // prepare the query
        $stmt = $this->conn->prepare( $query );

        $this->email=htmlspecialchars(strip_tags($this->email));

        // bind value
        $stmt->bindParam(1, $this->email);

        // execute the query
        $stmt->execute();

        // get number of rows
        $num = $stmt->rowCount();
        if($num>0){

            // get record values
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // assign values to object properties
            $this->id = $row['userId'];
            $this->f_name = $row['first_name'];
            $this->l_name = $row['last_name'];
            $this->pass = $row['password'];

            // return true because email exists in the database
            return true;
        }

        // return false if email does not exist in the database
        return false;
    }

    public function isAdmin()
    {
        $query="Select isAdmin from privs where user_id = ".$this->id;
        $stmt = $this->conn->prepare($query);
    }
}

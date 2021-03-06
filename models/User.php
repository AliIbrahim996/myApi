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
    public $isAdm;


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
        $query = "INSERT INTO " . $this->table . "
            SET
                first_name = ?,
                last_name = ?,
                user_email = ?,
                password = ?,
                user_role = ?";


        // prepare the query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->f_name=htmlspecialchars(strip_tags($this->f_name));
        $this->l_name=htmlspecialchars(strip_tags($this->l_name));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->pass=htmlspecialchars(strip_tags($this->pass));
        $this->isAdm=htmlspecialchars(strip_tags($this->isAdm));
        // bind the values
        $stmt->bindParam(1, $this->f_name);
        $stmt->bindParam(2, $this->l_name);
        $stmt->bindParam(3, $this->email);

        // hash the password before saving to database
        $password_hash = password_hash($this->pass, PASSWORD_BCRYPT);
        $stmt->bindParam(4, $password_hash);
        $stmt->bindParam(5, $this->isAdm);

        // execute the query, also check if query was successful
        if($stmt->execute()) {;
            return true;
        }

        return false;
    }

    /**
     * @param mixed $id
     */

    function getUserId(){
        // query to check if email exists
        $query = "SELECT userId
            FROM " . $this->table . "
            WHERE user_email = ?
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
        if($num>0) {

            // get record values
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // assign values to object properties
            $this->id = $row['userId'];
        }
    }
    function delete($email){
        $query= "Delete from ".$this->table
            ."where user_email = ?";
        $stmt = $this->conn->prepare( $query );
        $this->email=$email;
        $this->email=htmlspecialchars(strip_tags($this->email));

        // bind value
        $stmt->bindParam(1, $this->email);

        // execute the query
        if($stmt->execute()){
            return true;
        }
        return false;
    }
    function emailExists($email){

        // query to check if email exists
        $query = "SELECT userId, first_name, last_name, password,user_role
            FROM " . $this->table . "
            WHERE user_email = ?
            LIMIT 0,1";

        // prepare the query
        $stmt = $this->conn->prepare( $query );
        $this->email = $email;
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
            $this->isAdm = $row['user_role'];
            // return true because email exists in the database
            return true;
        }

        // return false if email does not exist in the database
        return false;
    }

    public function isAdmin()
    {
        $query="Select user_role FROM " . $this->table . "
            WHERE user_email = ?
            LIMIT 0,1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->email);
        $stmt->execute();
        $num = $stmt->rowCount();
        if($num>0) {

            // get record values
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            //echo "isAdmin ".$row['user_role'];
            if($row['user_role']){
                return true;
            }
            else
            {
                return false;
            }
        }
    }

}

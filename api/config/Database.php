<?php


class Database
{
    //DB parms
    private $host='localhost';
    private $db_name='kfashion';
    private $username='root';
    private $password='';
    private $conn;

    //DB Conn

    /**
     * @return mixed
     */
    public function connect()
    {
        $this->conn=null;
        try {
            $this->conn = new PDO('mysql:127.0.0.1=localhost;port=3306;dbname= '.$this->db_name,
                $this->username,$this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        }
        catch (PDOException $e){
            echo  'Connection Error: '.$e->getMessage();
        }

        return $this->conn;
    }
}
<?php
class viewDresses{
    private $dress;
    public function __construct()
    {
        $database= new Database();
        $db = $database->connect();
        $dress=new Dress($db);
    }
    function viewDresses(){
        $this->dress-> getDress();
    }
}

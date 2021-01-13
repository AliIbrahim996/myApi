<?php
include  '../showDresses.php';
class viewDresses{
    private $dress;
    public function __construct()
    {
        $database= new Database();
        $db = $database->connect();
        $this->dress=new Dress($db);
    }
    function viewDresses()
    {
        $result = $this->dress->getDresses();
        viewDresses($result);
    }
}

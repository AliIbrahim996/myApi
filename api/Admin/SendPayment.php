<?php
include "../headers.php";

include "../sendPayment.php";
include "../../models/Purchase.php";
class SendPayment implements sendPay {
    public $data;
    private $purchase;
    public function __construct()
    {
        $this->data = json_decode(file_get_contents("php://input"));
        $database= new Database();
        $db = $database->connect();
        $this->purchase=new Purchase($db);
    }

    public function sendPay()
    {

        $this->purchase->setPurchaseData($this->data);
       if($this->purchase->insertData())
        return true;
       else
           return false;
    }
}
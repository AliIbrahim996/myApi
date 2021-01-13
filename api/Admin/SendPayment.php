<?php
include "../headers.php";
require '../userAuth/isAdmin.php';
include "../sendPayment.php";
include "../PaymentData.php";
include "../../models/Purchase.php";
class SendPayment implements sendPay {
    private $data;
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
        $this->purchase->insertData();
        // TODO: Implement sendPay() method.
        http_response_code(200);
        echo json_encode(array("message" => "purchase done."));
    }
}
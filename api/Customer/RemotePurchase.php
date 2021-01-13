<?php
include "../headers.php";
require '../userAuth/login.php';
include '../Customer/RemotePaymentMethod.php';
include '../sendPayment.php';
include_once '../config/Database.php';
include_once '../../models/Customer.php';
include_once '../../models/Dress.php';
include_once '../../models/Cart.php';
class RemotePurchase implements sendPay {

private $data;
private $customer;
private $dress;
private $cart;
public function __construct()
{
    $this->data = json_decode(file_get_contents("php://input"));
    $database= new Database();
    $db = $database->connect();
    $this->customer =new Customer($db);
    $this->dress =new Customer($db);
    $this->cart=new Cart($db);
}

    function purchaseDress(){
    if(!empty($this->data->email))
    {
        $flag =hasPayMethod($this->data->email);
        if($flag){
            $this->sendPay();
        }
        else{
            http_response_code(401);
            echo json_encode(array("message" => "No Remote payment Method"));
        }
    }
    }

    function addToCart(){
        if(!empty($this->data->email)&& !empty($this->data->d_id)) {
            $this->customer->setCutomerInfo($this->data->email);
            $this->dress->setDressInfo($this->data->d_id);
            $cart_data=array(
                "user_id" =>$this->customer->u_id,
                "dress_id" =>$this->dress->d_id,
                "created_at" =>time()
            );
            $this->cart->setCartData($cart_data);
            $this->cart->insertData();
            http_response_code(200);
            echo json_encode(array("message" => "added to cart."));
        }
    }

    public function sendPay()
    {
        if(!empty($this->data->email)&& !empty($this->data->d_id)){
            $this->customer->setCutomerInfo($this->data->email);
            $this->dress->setDressInfo($this->data->d_id);
            $p_data=array(
                "user_id" =>$this->customer->u_id,
                "dress_id" =>$this->dress->d_id,
                "price" =>$this->dress->d_price,
                "created_at" =>time(),
            );
            echo json_encode($p_data);
            http_response_code(200);
            echo json_encode(array("message" => "send Payment remotly."));
        }

    }
}

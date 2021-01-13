<?php
include "../headers.php";
include '../userAuth/login.php';
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
    $this->dress =new Dress($db);
    $this->cart=new Cart($db);
}

    function purchaseDress(){
    if(!empty($this->data->email))
    {
        if(logIn()){
            $flag =hasPayMethod($this->data->u_id);
            if($flag){
               return $this->sendPay();
            }
            else{
                return json_encode(array(
                    "flag" => 0,
                    "message" => "Customer has no payment method! "
                ));
            }
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
                "created_at" =>date("Y/m/d")
            );
            $this->cart->setCartData($cart_data);
            $this->cart->insertData();
            http_response_code(200);
            return json_encode(array(
                "cart_data" => $cart_data,
                "flag" => 1,
                "message" => "added to cart"
            ));
        }
    }

    public function sendPay()
    {
        if(!empty($this->data->email)&& !empty($this->data->d_id)){
            $this->customer->setCutomerInfo($this->data->u_id);
            $this->dress->setDressInfo($this->data->d_id);
            $p_data=array(
                "user_id" =>$this->data->email,
                "dress_id" =>$this->dress->d_id,
                "price" =>$this->dress->d_price,
                "created_at" =>date("Y/m/d")
            );

            return json_encode(array(
                "Payment_info" => $p_data,
                    "flag" =>1,
                    "message" => "send Payment remotely Done!")
            );
        }
    }
}

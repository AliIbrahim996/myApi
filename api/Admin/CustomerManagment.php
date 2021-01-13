<?php
include "../headers.php";
include_once '../config/Database.php';
include_once '../../models/Customer.php';

 class CustomerManagment{

     private $customer;
     private $data;
     public function __construct()
     {
         $database= new Database();
         $db = $database->connect();
         $this->customer =new Customer($db);
         $this->data = json_decode(file_get_contents("php://input"));
     }

     public function getCustomerInfo(){
         return $this->customer->getCustomeres();
     }

     public function deleteCustomer(){

         if(!empty($this->data->u_id)) {
            $flag= $this->customer->delete($this->data->u_id);
            if($flag) {
                // set response code
                http_response_code(200);

                // display message: Customer deleted Successful
               echo json_encode(array(
                    "LogIn_Info" => array(
                        "email" => $this->data->email,
                        "is_admin" => "yes",
                        "message" => "successful loggedIn"
                    ),
                    "message" => "Customer deleted Successful."));
            }
                else{
                    // set response code
                    http_response_code(400);

                    // display message: Unable to delete Customer
                    json_encode(array(
                        "message" => "Unable to delete Customer.")
                    );
                }
            }
         else{
             http_response_code(400);

             // display message: Unable to delete Customer! userId is empty! login first!
             json_encode(array("message" => "Unable to delete Customer! userId is empty! login first!."));
         }
     }

     public function addCustomer(){

         if(!empty($this->data->c_name)&&
             !empty($this->data->c_location) &&
             !empty($this->data->c_phoneNum) &&
             !empty($this->data->hasPayMethod) &&
             !empty($this->data->cardId)&&
             empty($this->data->userId)){
             $this->customer->setUId($this->data->u_id);
             $flag=$this->customer->create($this->data);
             if($flag){
                 // set response code
                 http_response_code(200);

                 // display message: Customer creted Successful
                 echo json_encode(array(
                     "LogIn_Info" => array(
                         "email" => $this->data->email,
                         "is_admin" => "yes",
                         "message" => "successful loggedIn"
                     ),
                     "message" => "Customer creted Successful."));
             }
             else{
                 // set response code
                 http_response_code(400);

                 // display message: Unable to create Customer
                 echo json_encode(
                     array(
                         "LogIn_Info" => array(
                         "email" => $this->data->email,
                         "is_admin" => "yes",
                         "message" => "successful loggedIn"
                     ),
                         "message" => "Unable to create Customer."));
             }
         }
         else{
             // set response code
             http_response_code(400);

             // display message: Unable to create Customer! check your data!
             echo json_encode(array("message" => "Unable to create Customer! check your data!."));
         }

     }
 }

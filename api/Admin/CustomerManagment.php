<?php
header("Access-Control-Allow-Origin: http://localhost/SCIT/test");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


include_once '../config/Database.php';
include_once '../../models/Customer.php';
require '../userAuth/isAdmin.php';
 class CustomerManagment{

     private $customer;
     public function __construct()
     {
         $database= new Database();
         $db = $database->connect();
         $customer =new Customer($db);
     }

     public function getCustomerInfo(){
         return $this->customer->getCustomeres();
     }

     public function deleteCustomer(){
         if(isset($_SESSION['userId'])) {
            $flag= $this->customer->delete($_SESSION['userId']);
            if($flag) {
                // set response code
                http_response_code(200);

                // display message: user was created
                echo json_encode(array("message" => "Customer deleted Successful."));
            }
                else{
                    // set response code
                    http_response_code(400);

                    // display message: unable to create user
                    echo json_encode(array("message" => "Unable to delete Customer."));
                }
            }
         else{
             http_response_code(400);

             // display message: unable to create user
             echo json_encode(array("message" => "Unable to delete Customer! userId is empty! login first!."));
         }
     }

     public function addCustomer(){
         $data = json_decode(file_get_contents("php://input"));
         if(!!empty($data->c_name) &&
             !empty($data->c_location) &&
             !empty($data->c_phoneNum) &&
             !empty($data->hasPayMethod) &&
             !empty($data->cardId)&&
         isset($_SESSION ['userId'])){
             $u_id=$_SESSION ['userId'];
             $flag=$this->customer->create($u_id,$data);
             if($flag){
                 // set response code
                 http_response_code(200);

                 // display message: user was created
                 echo json_encode(array("message" => "Customer creted Successful."));
             }
             else{
                 // set response code
                 http_response_code(400);

                 // display message: unable to create user
                 echo json_encode(array("message" => "Unable to create Customer."));
             }
         }
         else{
             // set response code
             http_response_code(400);

             // display message: unable to create user
             echo json_encode(array("message" => "Unable to create Customer! check your data!."));
         }

     }
 }

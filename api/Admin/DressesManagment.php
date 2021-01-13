<?php
header("Access-Control-Allow-Origin: http://localhost/SCIT/test");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


include_once '../config/Database.php';
include_once '../../models/Dress.php';
require '../userAuth/isAdmin.php';
class DressesManagment
{

    private $dress;
    private  $data;
    public function __construct()
    {
        $database= new Database();
        $db = $database->connect();
        $this->dress=new Dress($db);
        $this->data = json_decode(file_get_contents("php://input"));
    }
    function viewDresses(){
       return $this->dress->getDresses();
    }
    function deleteDress(){
        // get posted data

        $this->dress->d_id=$this->data->d_id;
        if(
            !empty($this->dress->d_id)
            && $this->dress->delete()
        ){

            // set response code
            http_response_code(200);

            // display message: Dress deleted Successful
            echo json_encode(array("message" => "Dress deleted Successful."));
        }
    // message if unable to create
        else{

            // set response code
            http_response_code(400);

            // display message: Unable to delete dress
            echo json_encode(array("message" => "Unable to delete dress."));
        }
    }
    function addDress(){
         $flag=$this->dress->addDress($this->data);
        if($flag){
            http_response_code(200);

            // display message: Dress added Successful
            echo json_encode(array("message" => "Dress added Successful."));
        }
        else{
            // set response code
            http_response_code(400);

            // display message: Unable to add dress
            echo json_encode(array("message" => "Unable to add dress."));
        }
    }
}
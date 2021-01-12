<?php
header("Access-Control-Allow-Origin: http://localhost/SCIT/test/api/userAuth/isAdmin.php");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


include_once '../config/Database.php';
include_once '../../models/Dress.php';

class DressesManagment
{

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
    function deleteDress(){
        // get posted data
        $data = json_decode(file_get_contents("php://input"));
        $this->dress->d_id=$data->d_id;
        if(
            !empty($this->dress->d_id)
            && $this->dress->delete()
        ){

            // set response code
            http_response_code(200);

            // display message: user was created
            echo json_encode(array("message" => "Dress deleted Successful."));
        }
    // message if unable to create
        else{

            // set response code
            http_response_code(400);

            // display message: unable to create user
            echo json_encode(array("message" => "Unable to delete dress."));
        }
    }
    function addDress(){
        $data = json_decode(file_get_contents("php://input"));
    }
}
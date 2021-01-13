<?php
// required headers
include "../headers.php";
require 'login.php';

//init DB & Connect

include_once '../config/Database.php';
include_once '../../models/User.php';

//init DB & Connect
$database= new Database();
$db = $database->connect();

// instantiate user object
$user = new User($db);
$data = json_decode(file_get_contents("php://input"));
if (!empty($data->email) && !empty($data->password))
{
    $user->email=$data->email;
   if($user->isAdmin()){
       // set response code
       http_response_code(200);

       // tell the user login failed
       echo json_encode(array("message" => "user is an Admin."));
   }
   else{
       // set response code
       http_response_code(401);

       // tell the user login failed
       echo json_encode(array("message" => "user is not an Admin."));
   }

}
else{

    // set response code
    http_response_code(401);

    // tell the user login failed
    echo json_encode(array("message" => "error in email or password!."));
}
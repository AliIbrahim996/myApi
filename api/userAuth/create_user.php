<?php

// required headers
header("Access-Control-Allow-Origin: http://localhost/SCIT/test");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


include_once '../config/Database.php';
include_once '../../models/User.php';

//init DB & Connect
$database= new Database();
$db = $database->connect();

// instantiate user object
$user = new User($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

// set user property values

    $user->f_name = $data->first_name;
    $user->l_name = $data->last_name;
    $user->email = $data->email;
    $user->pass = $data->password;
// create the user
if(!empty($user->f_name) &&
    !empty($user->l_name) &&
    !empty($user->email) &&
    !empty($user->pass) && $user->create() ){

    // set response code
    http_response_code(200);

    // display message: user was created
    echo json_encode(array("message" => "User was created."));
}
// message if unable to create user
else{

    // set response code
    http_response_code(400);

    // display message: unable to create user
    echo json_encode(array("message" => "Unable to create user."));
}



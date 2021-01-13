<?php

// required headers
include "../headers.php";


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
    $user->isAdm=$data->isAdmin;

// create the user
if(!empty($user->f_name) &&
    !empty($user->l_name) &&
    !empty($user->email) &&
    !empty($user->pass) &&
    !empty($user->isAdm) &&
    $user->create() ){

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



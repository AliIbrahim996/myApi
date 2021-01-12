<?php

// required headers
header("Access-Control-Allow-Origin: http://localhost/SCIT/Train");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

//init DB & Connect
$database= new Database();
$db = $database->connect();

// instantiate user object
$user = new User($db);



$data = json_decode(file_get_contents("php://input"));

$user->email = $data->email;
$email_exists = $user->emailExists();

include '../config/core.php';
include_once '../libs/src/BeforeValidException.php';
include_once '../libs/src/ExpiredException.php';
include_once '../libs/src/SignatureInvalidException.php';
include_once '../libs/src/JWT.php';
use \Firebase\JWT\JWT;
// check if email exists and if password is correct

// show error reporting
error_reporting(E_ALL);

// set your default time-zone
date_default_timezone_set('Asia/Damascus');

// variables used for jwt
$key = "myKey";
$issued_at = time();
$expiration_time = $issued_at + (60 * 60); // valid for 1 hour
$issuer = "http://localhost/SCIT/Train";
if($email_exists && password_verify($data->password, $user->pass)) {

    $token = array(
        "iat" => $issued_at,
        "exp" => $expiration_time,
        "iss" => $issuer,
        "data" => array(
            "userId" => $user->id,
            "first_name" => $user->f_name,
            "last_name" => $user->l_name,
            "email" => $user->email
        )
    );

    // set response code
    http_response_code(200);

    // generate jwt
    $jwt = JWT::encode($token, $key);
    echo json_encode(
        array(
            "message" => "Successful login.",
            "jwt" => $jwt
        )
    );
}
// login failed
else{

    // set response code
    http_response_code(401);

    // tell the user login failed
    echo json_encode(array("message" => "Login failed."));
}


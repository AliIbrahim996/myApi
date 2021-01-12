<?php
// required headers
header("Access-Control-Allow-Origin: http://localhost/SCIT/test");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require 'login.php';
//init DB & Connect

if (isset ($_SESSION ['userId']) && $row ["role"] = 1)
{
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
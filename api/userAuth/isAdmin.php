<?php
// required headers
header("Access-Control-Allow-Origin: http://localhost/SCIT/test/api/userAuth/login.php");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/Database.php';
include_once '../../models/User.php';

//init DB & Connect
$database= new Database();
$db = $database->connect();
$user = new User($db);
$is_admin = $user->isAdmin();

<?php
header("Access-Control-Allow-Origin: http://localhost/SCIT/Train/api/userAuth/isAdmin.php");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


include_once '../config/Database.php';
include_once '../../models/User.php';
include_once '../../models/Dress.php';
//init DB & Connect
$database= new Database();
$db = $database->connect();

//Init objects
$dress= new Dress($db);
$users=new User($db);

$dress->getDress();
$users->getUsers();



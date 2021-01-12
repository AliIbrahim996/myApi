<?php
header("Access-Control-Allow-Origin: http://localhost/SCIT/test/api/userAuth/isAdmin.php");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


include_once '../config/Database.php';
include_once '../../models/Customer.php';
include_once '../../models/Dress.php';
//init DB & Connect
$database= new Database();
$db = $database->connect();

//Init objects
$dress= new Dress($db);

$customers=new Customer($db);

$result=$dress->getDress();

$result=$customers->getCustomers();



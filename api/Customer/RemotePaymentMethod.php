<?php
include "../headers.php";
include_once '../config/Database.php';
include_once '../../models/Customer.php';
 function hasPayMethod($email){
     $database= new Database();
     $db = $database->connect();
     $customer =new Customer($db);
     $customer->setCutomerInfo($email);
     return $customer->hasPaymentMethod();
 }
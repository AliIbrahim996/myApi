<?php
include "../headers.php";
include_once '../config/Database.php';
include_once '../../models/Customer.php';
 function hasPayMethod($id){
     $database= new Database();
     $db = $database->connect();
     $customer =new Customer($db);
     $customer->setCutomerInfo($id);
     return $customer->hasPaymentMethod();
 }
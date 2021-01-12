<?php
header("Access-Control-Allow-Origin: http://localhost/SCIT/test");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


include_once '../config/Database.php';
include_once '../../models/User.php';
require '../userAuth/isAdmin.php';
 class CustomeManagment{
     private $users;
     public function __construct()
     {
         $database= new Database();
         $db = $database->connect();
         $users=new User($db);
     }

     public function getCustomerInfo(){
         $this->users->getUsers();
     }

     public function deleteUser(){
         $this->users->delete();
     }
 }

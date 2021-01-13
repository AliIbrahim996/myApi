<?php

include "../headers.php";
include_once '../config/Database.php';
include_once '../../models/User.php';
require '../userAuth/isAdmin.php';

class UsersManagment
{
    private $users;
    private $data;

    public function __construct()
    {
        $database= new Database();
        $db = $database->connect();
        $this->users=new User($db);
        $this->data = json_decode(file_get_contents("php://input"));
    }

    public function getUsersInfo(){
        $this->users->getUsers();
    }

    public function deleteUser(){
        if(!empty($this->data->email)) {
            $this->users->delete($this->data->email);
        }
    }
}
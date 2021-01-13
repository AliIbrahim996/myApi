<?php
include_once 'CustomerManagment.php';
include '../userAuth/isAdmin.php';

if(isAdmin()){
    $c=new CustomerManagment();
    $c->deleteCustomer();
}
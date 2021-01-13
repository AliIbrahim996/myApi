<?php

include_once 'DressesManagment.php';
include '../userAuth/isAdmin.php';

if(isAdmin()){
    $d=new DressesManagment();
    $d->deleteDress();
}

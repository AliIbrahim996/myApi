<?php

include '../userAuth/isAdmin.php';
include 'SendPayment.php';

if(isAdmin()){
    $sP=new SendPayment();
    if($sP->sendPay()){
        http_response_code(200);
        echo json_encode(array(
                "message" => "purchase done for Customer with ID = ".$sP->data->u_id
            )
        );
    }
    else{
        http_response_code(400);
        echo json_encode(array(
                "message" => "purchase failed for Customer with ID = ".$sP->data->u_id
            )
        );
    }
}
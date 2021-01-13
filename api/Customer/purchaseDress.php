<?php

include "RemotePurchase.php";

$p=new RemotePurchase();
$result = json_decode($p->purchaseDress());

if($result->flag){
    echo json_encode(
        array(
            "Payment_info: " => $result->Payment_info,
            "Message: " => $result->message
            )
    );
}
else{
    echo json_encode(
        array(
            "Message" => $result->message
        )
    );
}
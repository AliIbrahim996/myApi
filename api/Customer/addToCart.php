<?php

include "RemotePurchase.php";

$p=new RemotePurchase();
$result = json_decode($p->addToCart());

if($result->flag){
    echo json_encode(
        array(
            "Cart Info: " => $result->cart_data,
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

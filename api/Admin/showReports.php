<?php
header("Access-Control-Allow-Origin: http://localhost/SCIT/test/api/userAuth/isAdmin.php");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require '../userAuth/isAdmin.php';

include_once  'CustomerManagment.php';
include_once 'DressesManagment.php';
include '../showDresses.php';

$cManage=new CustomerManagment();
$dManage=new DressesManagment();
//Init objects

$result = $dManage->viewDresses();
viewDresses($result);

$result=$cManage->getCustomerInfo();
$num= $result->rowCount();

if($num>0){
    $customers_arr= array();
    $customers_arr['data']=array();
    while ($row = $result->fetch(PDO::FETCH_ASSOC)){
        $customer_item=array(
            'id' => $row['user_id'],
            'name' => $row['customer_name'] ,
            'PhoneNum' =>$row['phoneNumber'] ,
            'Location' =>$row[' location'] ,
            'hasPaymentMethod' =>$row['hasPaymentMethod'] ,
            'card_id' =>$row['card_id'] ,
        );
        array_push($customers_arr['data'],$customer_item);
    }
    json_encode($customers_arr);
}
else{
    http_response_code(404);

    // tell the user login failed
    echo json_encode(array("message" => "No data found."));
}



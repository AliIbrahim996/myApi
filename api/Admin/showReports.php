<?php

include "../headers.php";

include_once  'CustomerManagment.php';
include_once 'DressesManagment.php';
include "../userAuth/isAdmin.php";

if(isAdmin()){
    $cManage=new CustomerManagment();
    $dManage =new DressesManagment();
//Init objects

    $dresses_arr=array();
    $dresses_arr['data'] = array();
    $result=$dManage->viewDresses();
    $num= $result->rowCount();

    if($num>0){

        while ($row = $result->fetch(PDO::FETCH_ASSOC)){
            $dress_item=array(
                'id' => $row['d_id'],
                'Type' => $row['d_type'] ,
                'Color' =>$row['d_color'],
                'Price' => $row['d_price'].'$'
            );
            array_push($dresses_arr['data'],$dress_item);
        }
    }
    else{
        $dress_item=array(
            "Message" => "No data found!"
        );
        array($dresses_arr['data'],$dress_item);
    }

    $result=$cManage->getCustomerInfo();
    $num= $result->rowCount();
    $customers_arr= array();
    $customers_arr['data']=array();
    $flag="";
    if($num>0){
        while ($row = $result->fetch(PDO::FETCH_ASSOC)){
            if($row['hasPaymentMethod']){
                $flag="yes";
            }
            else{
                $flag="No";
            }
            $customer_item=array(
                'id' => $row['user_id'],
                'name' => $row['customer_name'] ,
                'PhoneNum' =>$row['phoneNumber'] ,
                'Location' => $row['Location'] ,
                'hasPaymentMethod' =>$flag ,
                'card_id' =>$row['card_id'] ,
            );
            array_push($customers_arr['data'],$customer_item);
        }
    }
    else{
        http_response_code(404);

        // tell the user login failed
        echo json_encode(array("message" => "No data found."));
        return 0;
    }
   echo json_encode(array(
            "Customers_Info" =>$customers_arr,
            "Dresses_Info" => $dresses_arr)
    );

}




<?php

function viewDresses($result){
    $num= $result->rowCount();

    if($num>0){
        $dress_arr= array();
        $dress_arr['data']=array();
        while ($row = $result->fetch(PDO::FETCH_ASSOC)){
            $dress_item=array(
                'id' => $row['d_id'],
                'type' => $row['d_type'] ,
                'color' =>$row['d_color'] ,
                'price' =>$row['d_price'] ,
            );
            array_push($dress_arr['data'],$dress_item);
        }
        json_encode($dress_arr);
    }
    else{
        http_response_code(404);

        // tell the user login failed
        echo json_encode(array("message" => "No data found."));
    }
}

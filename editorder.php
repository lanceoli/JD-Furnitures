<?php
require 'connectDB.php';
session_start();
$order_num = $_GET['orno'];
$status = "";


$errormessage = "";

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $status = $_POST["status"];
 

    $_SESSION['status'] = $_POST['status'];


    if(empty(trim($status)) ){
        header('Location: orderinfo.php?orno=' . $order_num . '&error=missing');
        exit();
    }

    do{
        /*if ( empty($last_name) || empty($first_name) || empty($middle_name) || empty($birthday) || empty($email) || empty($phone) || empty($res_loc) || empty($bus_loc) || empty($mode_pay) ){
            $errormessage = "You have missed a field";
            break;
        }*/
        $sql = "UPDATE ORDERS SET STATUS = '$status' WHERE ORDER_NUM = '$order_num';";

        $result = $connection->query($sql);

        
        
       
    }while(false);

    header('Location: orderinfo.php?orno=' . $order_num);

}        





?>
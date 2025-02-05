<?php
require 'connectDB.php';
session_start();
$CUST_NUM = "";
$STATUS = "";
$EST_DATE = "";
$MODE_OF_PAY = "";
$ADD_INFO = "";
$ORDER_DATE = "";
$ORDER_COST = "0.00";
$newFurniture = "";

$errormessage = "";
$err_ln = "";


if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $CUST_NUM = $_POST["CUST_NUM"];
    $STATUS = $_POST["STATUS"];
    $EST_DATE = $_POST["EST_DATE"];
    $MODE_OF_PAY = $_POST["MODE_OF_PAY"];
    $ADD_INFO = $_POST["ADD_INFO"];
    $newFurniture = $_POST["newFurniture"];
    
    $_SESSION['CUST_NUM'] = $_POST["CUST_NUM"];
    $_SESSION['STATUS'] = $_POST["STATUS"];
    $_SESSION['EST_DATE'] = $_POST["EST_DATE"];
    $_SESSION['MODE_OF_PAY'] = $_POST["MODE_OF_PAY"];
    $_SESSION['ADD_INFO'] = $_POST["ADD_INFO"];

  
    if(empty(trim($CUST_NUM)) || empty(trim($STATUS)) ||
    empty(trim($EST_DATE)) || empty(trim($MODE_OF_PAY))){
        header('Location: UT-create_order.php?error=missing');
        exit();
    }

    do{

        $STATUSstring = "";
        switch($STATUS) {
            case '0':
                $STATUSstring = "Pending";
                break;
            case '1':
                $STATUSstring = "Shipping";
                break;
            case '2':
                $STATUSstring = "Delivered";
                break;
        }
        $sql = "INSERT INTO orders (CUST_NUM, ORDER_DATE, EST_DATE, STATUS, ADD_INFO, ORDER_COST)
                VALUES ('$CUST_NUM', CURDATE(), '$EST_DATE', '$STATUSstring', '$ADD_INFO', '$ORDER_COST')";
        $result = $connection->query($sql);

        $CUST_NUM = "";
        $STATUS = "";
        $EST_DATE = "";
        $MODE_OF_PAY = "";
        $ADD_INFO = "";
        $ORDER_DATE = "";

        $_SESSION['CUST_NUM'] = null;
        $_SESSION['STATUS'] = null;
        $_SESSION['EST_DATE'] = null;
        $_SESSION['MODE_OF_PAY'] = null;
        $_SESSION['ADD_INFO'] = null;

        $sql = "SELECT MAX(ORDER_NUM) AS newOrder FROM orders";
        $result = $connection->query($sql);
        $row = $result->fetch_assoc();
        $order_num = $row['newOrder'];

        if($newFurniture == 0) {
            header("Location: UT-create_product.php?ORDER_NUM=" . $order_num);
        }
        elseif($newFurniture == 1) { 
            header("Location: UT-create_product.php?ORDER_NUM=" . $order_num);
        }
    }while(false);
}




?>
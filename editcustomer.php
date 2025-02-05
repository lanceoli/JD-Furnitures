<?php
require 'connectDB.php';
session_start();
$cust_num = $_GET['cust'];
$last_name = "";
$first_name = "";
$middle_name = "";
$birthday = "";
$email = "";
$phone = "";
$company = "";
$res_loc = "";
$bus_loc = "";
$mode_pay = "";
$add_info = "";

$errormessage = "";

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $last_name = $_POST["last-name"];
    $first_name = $_POST["first-name"];
    $middle_name = $_POST["middle-name"];
    $birthday = $_POST["birthday"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $company = $_POST["company"];
    $res_loc = $_POST["res-loc"];
    $bus_loc = $_POST["bus-loc"];
    $mode_pay = $_POST["mode-pay"];
    $add_info = $_POST["add-info"];

    $_SESSION['last-name'] = $_POST['last-name'];
    $_SESSION['first-name'] = $_POST['first-name'];
    $_SESSION['middle-name'] = $_POST['middle-name'];
    $_SESSION['birthday'] = $_POST['birthday'];
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['phone'] = $_POST['phone'];
    $_SESSION['company'] = $_POST['company'];
    $_SESSION['res-loc'] = $_POST['res-loc'];
    $_SESSION['bus-loc'] = $_POST['bus-loc'];
    $_SESSION['mode-pay'] = $_POST['mode-pay'];
    $_SESSION['add-info'] = $_POST['add-info'];

    if(empty(trim($last_name)) || empty(trim($first_name)) || 
    empty(trim($middle_name)) || empty(trim($birthday)) || 
    empty(trim($email)) || empty(trim($phone)) || 
    empty(trim($company)) || empty(trim($res_loc)) || 
    empty(trim($bus_loc)) || empty(trim($mode_pay))){
        header('Location: customerEdit.php?cust=' . $cust_num . '&error=missing');
        exit();
    }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        header('Location: customerEdit.php?cust=' . $cust_num . '&error=notem');
        exit();
    }

    do{
        /*if ( empty($last_name) || empty($first_name) || empty($middle_name) || empty($birthday) || empty($email) || empty($phone) || empty($res_loc) || empty($bus_loc) || empty($mode_pay) ){
            $errormessage = "You have missed a field";
            break;
        }*/
        $sql = "UPDATE CUSTOMERS SET LAST_NAME = '$last_name', FIRST_NAME = '$first_name', MIDDLE_NAME = '$middle_name', BIRTHDAY = '$birthday', EMAIL = '$email', PHONE = '$phone', COMPANY = '$company', COMPANY_LOCATION = '$bus_loc', RESIDENT_LOCATION = '$res_loc', MODE_OF_PAY = '$mode_pay', ADD_INFO = '$add_info' WHERE CUST_NUM = '$cust_num';";

        $result = $connection->query($sql);

        $last_name = "";
        $first_name = "";
        $middle_name = "";
        $birthday = "";
        $email = "";
        $phone = "";
        $company = "";
        $res_loc = "";
        $bus_loc = "";
        $mode_pay = "";
        $add_info = "";

        $sql = "SELECT * FROM customers WHERE CUST_NUM=" . $cust_num;
        $result = $connection->query($sql);
        $row = $result->fetch_assoc();
        $cust_link = "Location: customer.php?cust=" . $cust_num;

        $filename = $cust_num;
        $ext = pathinfo($_FILES["edit-img"]["name"],  PATHINFO_EXTENSION);
        $destination = __DIR__ . "/assets/customer_img/" . $filename . "." . $ext;
        if(file_exists($_FILES['edit-img']['tmp_name'])){
            unlink(__DIR__ . "/assets/customer_img/" . $row["IMG"]);
        }
        

        if(!move_uploaded_file($_FILES["edit-img"]["tmp_name"], $destination)){
            header($cust_link);
            exit();
        }

        $sql = 'UPDATE customers SET IMG = "' . $filename . '.' . $ext . '" WHERE  CUST_NUM = ' . $filename;
        $result = $connection->query($sql);
        unset($_SESSION['last-name']);
        unset($_SESSION['first-name']);
        unset($_SESSION['middle-name']);
        unset($_SESSION['birthday']);
        unset($_SESSION['email']);
        unset($_SESSION['phone']);
        unset($_SESSION['company']);
        unset($_SESSION['res-loc']);
        unset($_SESSION['bus-loc']);
        unset($_SESSION['mode-pay']);
        unset($_SESSION['add-info']);
        header($cust_link);
    }while(false);

}        





?>
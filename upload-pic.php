<?php
require 'connectDB.php';
session_start();
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
$err_ln = "";


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
        header('Location: create.php?error=missing');
        exit();
    }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        header('Location: create.php?error=notem');
        exit();
    }elseif($_FILES["create-img"]["error"] == UPLOAD_ERR_NO_FILE){
        header('Location: create.php?error=noimg');
        exit();
    }

    do{
        /*if ( empty($last_name) || empty($first_name) || empty($middle_name) || empty($birthday) || empty($email) || empty($phone) || empty($res_loc) || empty($bus_loc) || empty($mode_pay) ){
            $errormessage = "You have missed a field";
            break;
        }*/
    


        $sql = "INSERT INTO customers (LAST_NAME, FIRST_NAME, MIDDLE_NAME, BIRTHDAY, COMPANY, COMPANY_LOCATION, PHONE, EMAIL, RESIDENT_LOCATION, MODE_OF_PAY, ADD_INFO)" . "VALUES ('$last_name', '$first_name', '$middle_name', '$birthday', '$company', '$bus_loc', '$phone', '$email', '$res_loc', '$mode_pay', '$add_info')";
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

   
        $sql = "SELECT MAX(CUST_NUM) FROM customers";
        $result = $connection->query($sql);
        $row = $result->fetch_assoc();

        $filename = $row["MAX(CUST_NUM)"];
        $ext = pathinfo($_FILES["create-img"]["name"],  PATHINFO_EXTENSION);
        $destination = __DIR__ . "/assets/customer_img/" . $filename . "." . $ext;

        if(!move_uploaded_file($_FILES["create-img"]["tmp_name"], $destination)){
            exit("cant move file");
        }

        $sql = 'UPDATE customers SET IMG = "' . $filename . '.' . $ext . '" WHERE  CUST_NUM = ' . $filename;
        $result = $connection->query($sql);

        $_SESSION['last-name'] = null;
        $_SESSION['first-name'] = null;
        $_SESSION['middle-name'] = null;
        $_SESSION['birthday'] = null;
        $_SESSION['email'] = null;
        $_SESSION['phone'] = null;
        $_SESSION['company'] = null;
        $_SESSION['res-loc'] = null;
        $_SESSION['bus-loc'] = null;
        $_SESSION['mode-pay'] = null;
        $_SESSION['add-info'] = null;

        header("Location: index.php");
    }while(false);
}




?>
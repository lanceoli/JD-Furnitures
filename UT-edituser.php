<?php
require 'connectDB.php';
session_start();
$emp_num = $_GET['emp'];
$last_name = "";
$first_name = "";
$middle_name = "";
$username = "";
$password = "";


$errormessage = "";

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $last_name = $_POST["last-name"];
    $first_name = $_POST["first-name"];
    $middle_name = $_POST["middle-name"];
    $username = $_POST["username"];
    $password = $_POST["password"];

    $_SESSION['last-name'] = $_POST['last-name'];
    $_SESSION['first-name'] = $_POST['first-name'];
    $_SESSION['middle-name'] = $_POST['middle-name'];
    $_SESSION['username'] = $_POST['username'];
    $_SESSION['password'] = $_POST['password'];

    if(empty(trim($last_name)) || empty(trim($first_name)) || 
    empty(trim($middle_name)) || empty(trim($username)) || 
    empty(trim($password)) ){
        header('Location: UT-userEdit.php?emp=' . $emp_num . '&error=missing');
        exit();
    }

    do{
        /*if ( empty($last_name) || empty($first_name) || empty($middle_name) || empty($birthday) || empty($email) || empty($phone) || empty($res_loc) || empty($bus_loc) || empty($mode_pay) ){
            $errormessage = "You have missed a field";
            break;
        }*/
        $sql = "UPDATE employees SET LAST_NAME = '$last_name', FIRST_NAME = '$first_name', MIDDLE_NAME = '$middle_name', USERNAME = '$username', PASSWORD = '$password' WHERE id = '$emp_num';";

        $result = $connection->query($sql);

        $last_name = "";
        $first_name = "";
        $middle_name = "";
        $username = "";
        $password = "";


        $sql = "SELECT * FROM employees WHERE id=" . $emp_num;
        $result = $connection->query($sql);
        $row = $result->fetch_assoc();
        $cust_link = "Location: UT-userinfo.php?emp=" . $emp_num;

        $filename = $emp_num;
        $ext = pathinfo($_FILES["edit-img"]["name"],  PATHINFO_EXTENSION);
        $destination = __DIR__ . "/assets/employee_img/" . $filename . "." . $ext;
        if(file_exists($_FILES['edit-img']['tmp_name'])){
        unlink(__DIR__ . "/assets/employee_img/" . $row["IMG"]);
        }
        
        if(!move_uploaded_file($_FILES["edit-img"]["tmp_name"], $destination)){
            header($cust_link);
            exit();
        }

        $sql = 'UPDATE employees SET IMG = "' . $filename . '.' . $ext . '" WHERE  id = ' . $filename;
        $result = $connection->query($sql);
        $_SESSION['last-name'] = null;
        $_SESSION['first-name'] = null;
        $_SESSION['middle-name'] = null;
        $_SESSION['username'] = null;
        $_SESSION['password'] = null;
        header($cust_link);
    }while(false);

}




?>
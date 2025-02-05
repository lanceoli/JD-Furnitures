<?php
require 'connectDB.php';
session_start();
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
    empty(trim($password))){
        header('Location: UT-AVcreate.php?error=missing');
        exit();
    }elseif($_FILES["create-img"]["error"] == UPLOAD_ERR_NO_FILE){
        header('Location: UT-AVcreate.php?error=noimg');
        exit();
    }

    do{
        /*if ( empty($last_name) || empty($first_name) || empty($middle_name) || empty($birthday) || empty($email) || empty($phone) || empty($res_loc) || empty($bus_loc) || empty($mode_pay) ){
            $errormessage = "You have missed a field";
            break;
        }*/

        $sql = "INSERT INTO employees (LAST_NAME, FIRST_NAME, MIDDLE_NAME, USERNAME, PASSWORD)" . "VALUES ('$last_name', '$first_name', '$middle_name', '$username', '$password')";
        $result = $connection->query($sql);

        $last_name = "";
        $first_name = "";
        $middle_name = "";
        $username = "";
        $password = "";

        $sql = "SELECT MAX(id) FROM employees";
        $result = $connection->query($sql);
        $row = $result->fetch_assoc();
        
        $filename = $row["MAX(id)"];
        $ext = pathinfo($_FILES["create-img"]["name"],  PATHINFO_EXTENSION);
        $destination = __DIR__ . "/assets/employee_img/" . $filename . "." . $ext;
        
        if(!move_uploaded_file($_FILES["create-img"]["tmp_name"], $destination)){
            exit("cant move file");
        }
        
        $sql = 'UPDATE employees SET IMG = "' . $filename . '.' . $ext . '" WHERE  id = ' . $filename;
        $result = $connection->query($sql);

        $_SESSION['last-name'] = null;
        $_SESSION['first-name'] = null;
        $_SESSION['middle-name'] = null;
        $_SESSION['username'] = null;
        $_SESSION['password'] = null;
        header("Location: UT-adminview.php");

    }while(false);
}




?>
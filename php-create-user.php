<?php
include "db-conn-login.php";

$last_name = "";
$first_name = "";
$middle_name = "";
$user_name = "";
$password = "";
$confirm_password = "";

$errormessage = "";

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $last_name = $_POST["last-name"];
    $first_name = $_POST["first-name"];
    $middle_name = $_POST["middle-name"];
    $user_name = $_POST["user-name"];
    $password = $_POST["passwords"];
    $confirm_password = $_POST["confirmation"];

    do{
        /*if ( empty($last_name) || empty($first_name) || empty($middle_name) || empty($birthday) || empty($email) || empty($phone) || empty($res_loc) || empty($bus_loc) || empty($mode_pay) ){
            $errormessage = "You have missed a field";
            break;
        }*/

        $sql = "INSERT INTO EMPLOYEES (LAST_NAME, FIRST_NAME, MIDDLE_NAME, USERNAME, PASSWORD, CONFIRM_PASSWORD)" . "VALUES ('$last_name', '$first_name', '$middle_name', '$user_name', '$password', '$confirm_password')";
        $result = $conn->query($sql);

        $last_name = "";
        $first_name = "";
        $middle_name = "";
        $user_name = "";
        $password = "";
        $confirm_password = "";

   

    }while(false);
}

$sql = "SELECT MAX(id) FROM EMPLOYEES";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$filename = $row["MAX(id)"];
$ext = pathinfo($_FILES["create-img"]["name"],  PATHINFO_EXTENSION);
$destination = __DIR__ . "/assets/employee_img/" . $filename . "." . $ext;

if(!move_uploaded_file($_FILES["create-img"]["tmp_name"], $destination)){
    exit("cant move file");
}

$sql = 'UPDATE EMPLOYEES SET IMG = "' . $filename . '.' . $ext . '" WHERE  id = ' . $filename;
$result = $conn->query($sql);

header("Location: index.php");
?>
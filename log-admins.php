<?php
include "connectDB.php";
session_start();
if (isset($_POST['aname']) && isset($_POST['password'])){

    function validate($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    $aname = validate($_POST['aname']);
    $pass = validate($_POST['password']);

    if(empty($aname)){
        header("Location:login-admin.php?error=Username is required");
        exit();

    }elseif (empty($pass)) {
        header("Location:login-admin.php?error=Password is required");
        exit();
    }else{
        $sql = "SELECT * FROM admins WHERE ADMIN_ID='$aname' AND PASSWORD='$pass'";

        $result = mysqli_query($connection, $sql);

        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            if ($row['ADMIN_ID'] === $aname && $row['PASSWORD'] === $pass) {
                $_SESSION["status"] = true;
                header("Location:UT-admin.php");
        exit();
            }else{
                header("Location:login-admin.php?error=Incorrect Username or Password");
                exit();
            }
            
        }else{
            header("Location:login-admin.php?error=Incorrect Username or Password");
            exit();
        }
    }

}else{
    header("Location:login.php?error");
    exit();
}

?>
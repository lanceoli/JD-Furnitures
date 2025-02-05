<?php
include "connectDB.php";
session_start();
if (isset($_POST['ename']) && isset($_POST['password'])){

    function validate($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    $ename = validate($_POST['ename']);
    $pass = validate($_POST['password']);

    if(empty($ename)){
        header("Location:login.php?error=Username is required");
        exit();

    }elseif (empty($pass)) {
        header("Location:login.php?error=Password is required");
        exit();
    }else{
        $sql = "SELECT * FROM employees WHERE USERNAME='$ename' AND PASSWORD='$pass'";

        $result = mysqli_query($connection, $sql);

        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            if ($row['USERNAME'] === $ename && $row['PASSWORD'] === $pass) {
                $_SESSION["status"] = true;
                header("Location:index.php");
        exit();
            }else{
                header("Location:login.php?error=Incorrect Username or Password");
                exit();
            }
            
        }else{
            header("Location:login.php?error=Incorrect Username or Password");
            exit();
        }
    }

}else{
    header("Location:login.php?error");
    exit();
}

?>
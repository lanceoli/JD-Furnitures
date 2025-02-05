<?php require 'connectDB.php';
// $emp_id = 2;
session_start();
if($_SESSION["status"] != true)
{
    header("location:login.php");
}
$emp_num = $_GET['emp'];

$emprow = "SELECT * FROM employees WHERE id = $emp_num";
$empdata = $connection->query($emprow);

if (!$empdata){
    die("Invalid query: " . $connection->error);
}
$employee = $empdata->fetch_assoc();
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="userEdit.css">
    <title>Document</title>
</head>
<body>
<nav class="site-nav grid"> 
    <a href="ut-userinfo.php?emp=<?php echo $emp_num ?>"><img src="assets/img/Back.png" alt=""></a>
    <p>Edit Employee Info</p>
</nav>
<script src="scripts.js"></script>  
<form action="UT-edituser.php?emp=<?php echo $emp_num ?>" method="post" enctype="multipart/form-data">
<div class="forms">
    <?php
        if(isset($_GET['error'])){

                $error = $_GET['error'];


                if ($error == "missing"){
                        echo '<p class="error">Not all fields are filled!</p> 
                        <style>form .create-bar .create-button{border-color:red; border-style:solid;}</style>';
                }
                if ($error == "noimg"){
                        echo '<p class="error">Please insert an image!</p>
                        <style>form .ins-img{border-color:red; border-style:solid;}</style>';
                }
                
        }
        ?>
    <div class="ins-img">
        <img class="prof-img" src="assets/employee_img/<?php echo $employee["IMG"] ?>" onclick="triggerClick2()" id="profileIMG">
           <!-- <label for="create-img">Add Image</label> -->
            <input type="file" name="edit-img" id="edit-img" accept="image/*" onchange="displayImage(this)">
    </div>
    <p class="edit-cat">Employee Credentials</p>
    <div class="edit-form">
            <p>Username</p>
            <input type="text" name="username" id="username" value="<?php echo $employee["USERNAME"]?>">
    </div>
    <div class="edit-form">
            <p>Password</p>
            <input type="text" name="password" id="password" value="<?php echo $employee["PASSWORD"]?>">
    </div>

    <p class="edit-cat">Personal Information</p>
    <div class="edit-form">
            <p>Last Name</p>
            <input type="text" name="last-name" id="last-name"onkeydown="return /[a-zA-Z]/i.test(event.key)" value="<?php echo $employee["LAST_NAME"]?>">
    </div>
    <div class="edit-form">
            <p>First Name</p>
            <input type="text" name="first-name" id="first-name"onkeydown="return /[a-zA-Z]/i.test(event.key)" value="<?php echo $employee["FIRST_NAME"]?>">

    </div>
    <div class="edit-form">
            <p>Middle Name</p>
            <input type="text" name="middle-name"  id="middle-name" onkeydown="return /[a-zA-Z]/i.test(event.key)" value="<?php echo $employee["MIDDLE_NAME"]?>">
    </div>


    
    </div>

    <div class="edit-bar">
        <button type="submit" class="edit-button"><p>Finish</p></button>
    </div>
</form>

</body>
</html>
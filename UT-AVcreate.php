<?php
session_start();
if($_SESSION["status"] != true)
{
    header("location:login.php");
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="create.css">
    <title>Create User | JD Records</title>
</head>
<body>
<nav class="site-nav grid"> 
    <a href="UT-adminview.php"><img src="assets/img/Back.png" alt=""></a>
    <p>Create Record</p>
</nav>

<form action="UT-upload-pic.php" method="post" enctype="multipart/form-data">
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
        <img src="assets/placeholder.png" onclick="triggerClick()" id="profileIMG">
           <!-- <label for="create-img">Add Image</label> -->
            <input type="file" name="create-img" id="create-img" accept="image/*" onchange="displayImage(this)">
    </div>

    <p class="create-cat">Personal Information</p>
    <div class="create-form">
            <p>Last Name</p>
            <input type="text" name="last-name" id="last-name"onkeydown="return /[a-zA-Z]/i.test(event.key)" value="<?php if(isset($_SESSION['last-name'])){
                echo $_SESSION['last-name'];}
                else{echo "";} ?>">
    </div>
    <div class="create-form">
            <p>First Name</p>
            <input type="text" name="first-name" id="first-name"onkeydown="return /[a-zA-Z]/i.test(event.key)" value="<?php if(isset($_SESSION['first-name'])){
                echo $_SESSION['first-name'];}
                else{echo "";} ?>">

    </div>
    <div class="create-form">
            <p>Middle Name</p>
            <input type="text" name="middle-name"  id="middle-name" onkeydown="return /[a-zA-Z]/i.test(event.key)" value="<?php if(isset($_SESSION['middle-name'])){
                echo $_SESSION['middle-name'];}
                else{echo "";} ?>">
    </div>

    <p class="create-cat">Employee Credentials</p>
    <div class="create-form">
            <p>Username</p>
            <input type="text" name="username" id="username" value="<?php if(isset($_SESSION['username'])){
                echo $_SESSION['username'];}
                else{echo "";} ?>">
    </div>
    <div class="create-form">
            <p>Password</p>
            <input type="text" name="password" id="password" value="<?php if(isset($_SESSION['password'])){
                echo $_SESSION['password'];}
                else{echo "";} ?>">
    </div>
    
    </div>

    <script src="scripts.js"></script>    

    <div class="create-bar">
        <button type="submit" class="create-button"><p>Create</p></button>
        <!--<div class="create-button"><p>Create</p></div>-->
    </div>
</form>
<?php
        $_SESSION['last-name'] = null;
        $_SESSION['first-name'] = null;
        $_SESSION['middle-name'] = null;
        $_SESSION['username'] = null;
        $_SESSION['password'] = null;
?>
</body>
</html>
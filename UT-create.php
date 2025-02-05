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
    <title>Create Record | JD Records</title>
</head>
<body>
<nav class="site-nav grid"> 
    <a href="UT-admin.php"><img src="assets/img/Back.png" alt=""></a>
    <p>Create Record</p>
</nav>


<form action="upload-pic-admin.php" method="post" enctype="multipart/form-data">
    <div class="forms">

    <?php
        if(isset($_GET['error'])){

                $error = $_GET['error'];


                if ($error == "missing"){
                        echo '<p class="error">Not all fields are filled!</p> 
                        <style>form .create-bar .create-button{border-color:red; border-style:solid;}</style>';
                }
                if ($error == "notem"){
                    echo '<p class="error">Email is not valid!</p> 
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
    <div class="create-form ln">
            <p>Last Name</p>
            <input type="text" name="last-name" id="last-name" onkeydown="return /[a-zA-Z]/i.test(event.key)" value="<?php if(isset($_SESSION['last-name'])){
                echo $_SESSION['last-name'];}
                else{echo "";} ?>">
    </div>
    <div class="create-form">
            <p>First Name</p>
            <input type="text" name="first-name" id="first-name" onkeydown="return /[a-zA-Z]/i.test(event.key)" value="<?php if(isset($_SESSION['first-name'])){
                echo $_SESSION['first-name'];}
                else{echo "";} ?>">

    </div>
    <div class="create-form">
            <p>Middle Name</p>
            <input type="text" name="middle-name"  id="middle-name" onkeydown="return /[a-zA-Z]/i.test(event.key)" value="<?php if(isset($_SESSION['middle-name'])){
                echo $_SESSION['middle-name'];}
                else{echo "";} ?>">
    </div>
    <div class="create-form">
            <p>Birthday</p>
            <input type="date" name="birthday" id="birthday" value="<?php if(isset($_SESSION['birthday'])){
                echo $_SESSION['birthday'];}
                else{echo "";} ?>">
    </div>

    <p class="create-cat">Contact & Business Information</p>
    <div class="create-form">
            <p>Email</p>
            <input type="text" name="email" id="email" onkeypress="return event.charCode != 32" value="<?php if(isset($_SESSION['email'])){
                echo $_SESSION['email'];}
                else{echo "";} ?>">
    </div>
    <div class="create-form">
            <p>Phone Number</p>
            <input type="number" name="phone" id="phone" value="<?php if(isset($_SESSION['phone'])){
                echo $_SESSION['phone'];}
                else{echo "";} ?>">
    </div>
    <div class="create-form">
            <p>Company</p>
            <input type="text" name="company" id="company" value="<?php if(isset($_SESSION['company'])){
                echo $_SESSION['company'];}
                else{echo "";} ?>">
    </div>
    <div class="create-form">
            <p>Residential Location</p>
            <input type="text" name="res-loc" id="res-loc" value="<?php if(isset($_SESSION['res-loc'])){
                echo $_SESSION['res-loc'];}
                else{echo "";} ?>">
    </div>
    <div class="create-form">
            <p>Business Location</p>
            <input type="text" name="bus-loc" id="bus-loc" value="<?php if(isset($_SESSION['bus-loc'])){
                echo $_SESSION['bus-loc'];}
                else{echo "";} ?>">
    </div>
    <div class="create-form">
            <p>Mode of Payment</p>
            <input type="text" name="mode-pay" id="mode-pay" value="<?php if(isset($_SESSION['mode-pay'])){
                echo $_SESSION['mode-pay'];}
                else{echo "";} ?>">
    </div>
    <div class="create-form">
            <p>Additional Information</p>
            <input type="text" name="add-info" id="add-info" value="<?php if(isset($_SESSION['add-info'])){
                echo $_SESSION['add-info'];}
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
        $_SESSION['birthday'] = null;
        $_SESSION['email'] = null;
        $_SESSION['phone'] = null;
        $_SESSION['company'] = null;
        $_SESSION['res-loc'] = null;
        $_SESSION['bus-loc'] = null;
        $_SESSION['mode-pay'] = null;
        $_SESSION['add-info'] = null;
?>
</body>
</html>
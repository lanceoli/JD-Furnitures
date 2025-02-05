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
    <title>Add Order | JD Records</title>
</head>
<body>
<nav class="site-nav grid"> 
    <a href="UT-adminorders.php"><img src="assets/img/Back.png" alt=""></a>
    <p>Create Record</p>
</nav>

<form action="upload-pic.php" method="post" enctype="multipart/form-data">
    <div class="forms">

    
    <div class="ins-img">
            <label for="create-img">Add Image</label>
            <input type="file" name="create-img" id="create-img">
    </div>

    <p class="create-cat">Personal Information</p>
    <div class="create-form">
            <p>Last Name</p>
            <input type="text" name="last-name" id="last-name">
    </div>
    <div class="create-form">
            <p>First Name</p>
            <input type="text" name="first-name" id="first-name">

    </div>
    <div class="create-form">
            <p>Middle Name</p>
            <input type="text" name="middle-name"  id="middle-name">
    </div>
    <div class="create-form">
            <p>Birthday</p>
            <input type="date" name="birthday" id="birthday">
    </div>

    <p class="create-cat">Contact & Business Information</p>
    <div class="create-form">
            <p>Email</p>
            <input type="email" name="email" id="email">
    </div>
    <div class="create-form">
            <p>Phone Number</p>
            <input type="number" name="phone" id="phone">
    </div>
    <div class="create-form">
            <p>Company</p>
            <input type="text" name="company" id="company">
    </div>
    <div class="create-form">
            <p>Residential Location</p>
            <input type="text" name="res-loc" id="res-loc">
    </div>
    <div class="create-form">
            <p>Business Location</p>
            <input type="text" name="bus-loc" id="bus-loc">
    </div>
    <div class="create-form">
            <p>Mode of Payment</p>
            <input type="text" name="mode-pay" id="mode-pay">
    </div>
    <div class="create-form">
            <p>Additional Information</p>
            <input type="text" name="add-info" id="add-info">
    </div>
    </div>

    <div class="create-bar">
        <button type="submit" class="create-button"><p>Create</p></button>
        <!--<div class="create-button"><p>Create</p></div>-->
    </div>
</form>

</body>
</html>
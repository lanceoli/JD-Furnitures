<?php require 'connectDB.php';
$cust_num = $_GET['cust'];
session_start();
if($_SESSION["status"] != true)
{
    header("location:login.php");
}
$custrow = "SELECT * FROM customers WHERE CUST_NUM = $cust_num";
$custdata = $connection->query($custrow);

if (!$custdata){
    die("Invalid query: " . $connection->error);
}
$customer = $custdata->fetch_assoc();
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="customerEdit.css">
    <title>Document</title>
</head>
<body>
<nav class="site-nav grid"> 
    <a href="UT-customer.php?cust=<?php echo $cust_num ?>"><img src="assets/img/Back.png" alt=""></a>
    <p>Edit Customer Info</p>
</nav>

<form action="UT-editcustomer.php?cust=<?php echo $cust_num ?>" method="post" enctype="multipart/form-data">
<?php 
if(isset($_GET['error'])){

        $error = $_GET['error'];

        if ($error == "noimg"){
                echo '<p class="error">Please insert an image!</p>
                <style>form .ins-img{border-color:red; border-style:solid;}</style>';
        }
        if ($error == "missing"){
                echo '<p class="error">Not all fields are filled!</p> 
                <style>form .create-bar .create-button{border-color:red; border-style:solid;}</style>';
        }
        if ($error == "notem"){
            echo '<p class="error">Email is not valid!</p> 
            <style>form .create-bar .create-button{border-color:red; border-style:solid;}</style>';
    }
        
}

echo''?>

    <div class="forms">
    <div class="ins-img">
        <img class="prof-img" src="assets/customer_img/<?php echo $customer["IMG"] ?>" onclick="triggerClick2()" id="profileIMG">
            <label for="edit-img">Edit Image</label>
            <input type="file" name="edit-img" id="edit-img" accept="image/*" onchange="displayImage(this)">
    </div>

    <p class="edit-cat">Personal Information</p>
    <div class="edit-form">
            <p>Last Name</p>
            <input type="text" name="last-name" id="last-name" onkeydown="return /[a-zA-Z]/i.test(event.key)" value="<?php echo $customer["LAST_NAME"]?>">
    </div>
    <div class="edit-form">
            <p>First Name</p>
            <input type="text" name="first-name" id="first-name"onkeydown="return /[a-zA-Z]/i.test(event.key)" value="<?php echo $customer["FIRST_NAME"]?>">

    </div>
    <div class="edit-form">
            <p>Middle Name</p>
            <input type="text" name="middle-name"  id="middle-name" onkeydown="return /[a-zA-Z]/i.test(event.key)" value="<?php echo $customer["MIDDLE_NAME"]?>">
    </div>
    <div class="edit-form">
            <p>Birthday</p>
            <input type="date" name="birthday" id="birthday" value="<?php echo $customer["BIRTHDAY"]?>">
    </div>

    <p class="edit-cat">Contact & Business Information</p>
    <div class="edit-form">
            <p>Email</p>
            <input type="email" name="email" id="email" value="<?php echo $customer["EMAIL"]?>">
    </div>
    <div class="edit-form">
            <p>Phone Number</p>
            <input type="number" name="phone" id="phone" value="<?php echo $customer["PHONE"]?>">
    </div>
    <div class="edit-form">
            <p>Company</p>
            <input type="text" name="company" id="company" value="<?php echo $customer["COMPANY"]?>">
    </div>
    <div class="edit-form">
            <p>Residential Location</p>
            <input type="text" name="res-loc" id="res-loc" value="<?php echo $customer["RESIDENT_LOCATION"]?>">
    </div>
    <div class="edit-form">
            <p>Business Location</p>
            <input type="text" name="bus-loc" id="bus-loc" value="<?php echo $customer["COMPANY_LOCATION"]?>">
    </div>
    <div class="edit-form">
            <p>Mode of Payment</p>
            <input type="text" name="mode-pay" id="mode-pay" value="<?php echo $customer["MODE_OF_PAY"]?>">
    </div>
    <div class="edit-form">
            <p>Additional Information</p>
            <input type="text" name="add-info" id="add-info" value="<?php echo $customer["ADD_INFO"]?>">
    </div>
    </div>

    <script src="scripts.js"></script>  
    <div class="edit-bar">
        <button type="submit" class="edit-button"><p>Finish</p></button>
        <!--<div class="edit-button"><p>Finish</p></div>-->
    </div>

</form>

</body>
</html>
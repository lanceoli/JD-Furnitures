<?php require 'connectDB.php';
session_start();
if($_SESSION["status"] != true)
{
    header("location:login.php");
    exit();
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="product.css">
    <title>Create Record | JD Records</title>
</head>
<body>
<nav class="site-nav grid"> 
    <a href="create_order.php"><img src="assets/img/Back.png" alt=""></a>
    <p>Add Products</p>
</nav>

<form action="UT-add-product.php" method="post" enctype="multipart/form-data" onkeydown="return stopFormSubmission(event)">
    

    <div class="forms">
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
        }
    ?> 
    <?php
        echo 
        '
        <div class="ins-img">
            <img src="assets/placeholder.png" onclick="triggerClick()" id="profileIMG">
            <input type="file" name="create-img" accept="image/*" onchange="displayImage(this)" id="create-img">
        </div>

        <p class="create-cat">Basic Details</p>
        <div class="create-form">
                <p>Furniture Name</p>
                <input type="text" name="FURNITURE_NAME" id="furniture-name" value="';
                    if (isset($_SESSION["FURNITURE_NAME"])) {
                        echo $_SESSION["FURNITURE_NAME"];
                    }
                        else echo ""; echo '">
        </div>
        <div class="create-form">
                <p>Price</p>
                <input type="number" name="PRICE" id="price" value="';
                    if (isset($_SESSION["PRICE"])) {
                        echo $_SESSION["PRICE"];
                    }
                        else echo ""; echo '">
        </div>
        <div class="create-form">
                <p>Quantity</p>
                <input type="number" name="QUANTITY" id="quantity" value="';
                    if (isset($_SESSION["QUANTITY"])) {
                        echo $_SESSION["QUANTITY"];
                    }
                        else echo ""; echo '">
        </div>

        <p class="create-cat">Design Details</p>
        <div class="create-form">
                <p>Material</p>
                <input type="text" name="MATERIAL" id="material" value="';
                    if (isset($_SESSION["MATERIAL"])) {
                        echo $_SESSION["MATERIAL"];
                    }
                        else echo ""; echo '">
        </div>
        <div class="create-form">
                <p>Color</p>
                <input type="text" name="COLOR" id="color" value="';
                    if (isset($_SESSION["COLOR"])) {
                        echo $_SESSION["COLOR"];
                    }
                        else echo ""; echo '">
        </div>
        <div class="create-form">
                <p>Style</p>
                <input type="text" name="STYLE" id="style" value="';
                    if (isset($_SESSION["STYLE"])) {
                        echo $_SESSION["STYLE"];
                    }
                        else echo ""; echo '">
        </div>
        <div class="create-form">
                <p>Features</p>
                <input type="text" name="FEATURES" id="features" value="';
                    if (isset($_SESSION["FEATURES"])) {
                        echo $_SESSION["FEATURES"];
                    }
                        else echo ""; echo '">
        </div>
        <input type="hidden" name="ORDER_NUM" value='; echo $_GET['ORDER_NUM']; echo '>
        <input type="hidden" name="newFurniture" value=0>

        ';
    ?>
    <script src="scripts.js"></script>
    <script src="product.js"></script>
    <script> 
    </script>
    </br>
    </br>

    <div class = "add-product-div">
        <button type="submit" class="create-button"><p>Add Product</p></button>
    </div>


    </div>

    <div class="create-bar">
        <!-- <button type="submit" class="create-button"><p>Create</p></button> -->
        <a class="create-button" href="UT-adminorders.php"><p>Finalize</p></a>

        <!--<div class="create-button"><p>Create</p></div>-->
    </div>
</form>

</body>
</html>
<?php require 'connectDB.php';
session_start();
if($_SESSION["status"] != true)
{
    header("location:login.php");
}
$data = "SELECT * FROM furnitures";
$result = $connection->query($data);

if (!$result){
    die("Invalid query: " . $connection->error);
}
//session_destroy();
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="create_order.css">
    <link rel="stylesheet" href="product.css">
    <title>Create Record | JD Records</title>
</head>
<body>
<nav class="site-nav grid"> 
    <a href="index.php"><img src="assets/img/Back.png" alt=""></a>
    <p>Add Existing Furniture</p>
</nav>

<form action="add-order.php" method="post" enctype="multipart/form-data" oninput="range1value.value = progress.valueAsNumber" 
onkeydown="return stopFormSubmission(event)">
    <script src="scripts.js"></script>
    <div class="forms">

    <?php
        if(isset($_GET['error'])){

                $error = $_GET['error'];

                if ($error == "missing"){
                        echo '<p class="error">Not all fields are filled!</p> 
                        <style>form .create-bar .create-button{border-color:red; border-style:solid;}</style>';
                }
        }
    ?>

    <div class="create-form">
    <p>Choose Existing Furniture</p>
    <p>
        <select name="FURNITURE_ID" id="furniture">
                <option value="">
                <?php
                        $furniture = $connection->query($data);
                        while($furniture = $result->fetch_assoc()){
                                $selectedFurniture = $furniture['FURNITURE_ID'];
                                echo '<option value="' . $furniture["FURNITURE_ID"] . '" ';
                                if(isset($_SESSION['FURNITURE_ID']) && $_SESSION['FURNITURE_ID'] == $Furniture) echo 'selected';
                                echo '>'. $furniture["FURNITURE_NAME"] .'</option>
                                ';
                        }
                ?>
        </select> 
    </p>  
    <br>
    </div>
    <br>
    <div class="ins-img">
            <img src="assets/placeholder.png" onclick="triggerClick()" id="profileIMG">
            <input type="file" name="create-img" accept="image/*" onchange="displayImage(this)" id="create-img" readonly>
        </div>
    
        
        <p class="create-cat">Basic Details</p>
        <div class="create-form">
                <p>Furniture Name</p>
                <input type="text" name="FURNITURE_NAME" id="furniture-name" value="" readonly>
                   
        </div>
        <div class="create-form">
                <p>Price</p>
                <input type="text" name="PRICE" id="price" value="" readonly>
        </div>
        <div class="create-form">
                <p>Quantity</p>
                <input type="text" name="QUANTITY" id="quantity" value="" readonly>
        </div>

        <p class="create-cat">Design Details</p>
        <div class="create-form">
                <p>Material</p>
                <input type="text" name="MATERIAL" id="material" value="" readonly>
        </div>
        <div class="create-form">
                <p>Color</p>
                <input type="text" name="COLOR" id="color" value="" readonly>
        </div>
        <div class="create-form">
                <p>Style</p>
                <input type="text" name="STYLE" id="color" value="" readonly>
        </div>
        <div class="create-form">
                <p>Features</p>
                <input type="text" name="FEATURES" id="features" value="" readonly>
        </div>

        <input type="hidden" name="ORDER_NUM" value=<?php echo $_GET['ORDER_NUM']?>></input>
        <input type="hidden" name="finalize" value=0></input>

        <div class = "add-product-div">
                <button type="button" class="create-button"  onclick="displayAdd()"><p>Add Product</p></button>
        </div>
        <div class="create-bar">
                <div class = "create-bar">
                        <a class="create-button" href="orders.php"><p>Finalize</p></a>
                </div>
        </div>

        <div id="confirmationModal" class="modal">
        </div>

        <div id="furnitureModal" class="modal">
                <div class="modal-content">
                        <span class="close" id="close">&times;</span>
                        <div id="redirectionType">
                                <button type="submit" class="create-button" name="newFurniture" value="0"><p>Add an existing furniture</p></button>
                                <button type="submit" class="create-button" name="newFurniture" value="1"><p>Add new furniture</p></button>
                        </div>
                </div>
        </div>
</form>

<script src="order.js"></script>

</body>
</html>
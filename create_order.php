<?php require 'connectDB.php';
session_start();
unset($_SESSION["FURNITURE_NAME"]);
unset($_SESSION["PRICE"]);
unset($_SESSION["QUANTITY"]);
unset($_SESSION["MATERIAL"]);
unset($_SESSION["COLOR"]);
unset($_SESSION["STYLE"]);
unset($_SESSION["FEATURES"]);

if($_SESSION["status"] != true)
{
    header("location:login.php");
}
$data = "SELECT * FROM customers";
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
    <link rel="stylesheet" href="create.css">
    <link rel="stylesheet" href="create_order.css">
    <title>Create Record | JD Records</title>
</head>
<body>
<nav class="site-nav grid"> 
    <a href="orders.php"><img src="assets/img/Back.png" alt=""></a>
    <p>Add Order</p>
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

    <p class="create-cat">Order Details</p>
    <div class="create-form">
    <p>Customer</p>
    <p>
        <select name="CUST_NUM" id="customer">
                <option value="">
                <?php
                        $cus_row_qty = $connection->query($data);
                        while($customer = $result->fetch_assoc()){
                                $selectedCustomer = $customer['CUST_NUM'];
                                echo '<option value="' . $customer["CUST_NUM"] . '" ';
                                if(isset($_SESSION['CUST_NUM']) && $_SESSION['CUST_NUM'] == $selectedCustomer) echo 'selected';
                                echo '>'. $customer["LAST_NAME"] .'</option>
                                ';
                        }
                ?>
        </select> 
    </p>  
    <br>
    </div>
    <div class="create-form">
            <p>Order Progress</p>
            <script>
                window.onload = function() {
                        var progress = document.getElementById('progress');
                        var rangeValueDisplay = document.getElementById('rangeValueDisplay');
                        rangeValueDisplay.textContent = progress.value;
                };
            </script>
            <p><output name="range1value" for="range1" id="rangeValueDisplay"></output></p>
            <input type="range" name="STATUS" id="progress" step="1" min=0 max=2 value=
                <?php
                        if(isset($_SESSION["STATUS"])) {
                                echo $_SESSION["STATUS"];
                        }
                        else {
                                echo '0';
                        }
                ?>>
    </div>
    <div class="create-form">
            <p>Estimated Delivery Date</p>
            <p>
                <input type="date" id="delivery" name="EST_DATE"
                <?php
                        if(isset($_SESSION["EST_DATE"]) && $_SESSION["EST_DATE"] !== '') {
                                echo 'value = "' . date("Y-m-d", strtotime($_SESSION["EST_DATE"])) . '"';
                        }
                ?>>
            </p>
    </div>
    <div class="create-form">
    <p>Payment Method</p>
    <p>
        <select name="MODE_OF_PAY" id="payment">
                <option value=""></option>
                <option value="cash" 
                        <?php 
                                if(isset($_SESSION['MODE_OF_PAY']) && $_SESSION['MODE_OF_PAY'] == "cash")
                                echo 'selected';
                        ?>
                >Cash</option>
                <option value="card"
                        <?php 
                                if(isset($_SESSION['MODE_OF_PAY']) && $_SESSION['MODE_OF_PAY'] == "card")
                                echo 'selected';
                        ?>
                >Card</option>
                <option value="check"
                        <?php 
                                if(isset($_SESSION['MODE_OF_PAY']) && $_SESSION['MODE_OF_PAY'] == "check")
                                echo 'selected';
                        ?>
                >Check</option>
        </select> 
    </p>  <br>
    </div>
    <div class="create-form">
            <p>Special Instructions</p>
            <input type="text" name="ADD_INFO" id="instruction" value="<?php if(isset($_SESSION['ADD_INFO'])){
                echo $_SESSION['ADD_INFO'];}
                else{echo "";} ?>"> </input>
    </div>
        <input type="hidden" name="newFurniture" value=0'>
    
    </div>

    <div class="create-bar">
        <!--<button type="submit" class="create-button"><p>Create</p></button> -->
        <!-- <a class="create-button" href="create_product.php">
                <p>Create</p>
            </a>-->
        <div class = "create-bar">
                <button type="button" class="create-button" onclick="displayConfirmation()"><p>Create</p></button>
        </div>
        <!--<div class="create-button"><p>Create</p></div>-->
    </div>

        <div id="confirmationModal" class="modal">
                <div class="modal-content">
                        <span class="close" id="close">&times;</span>
                        <div id="information">
                                <p>Finalization Screen</p>
                                <p>Customer: <span id="customerOutput"></span></p>
                                <p>Order Progress: <span id="progressOutput"></span></p>
                                <p>Est. Delivery: <span id="deliveryDateOutput"></span></p>
                                <p>Payment Method: <span id="paymentMethodOutput"></span></p>
                                <p>Special Instructions: <span id="specialInstructionsOutput"></span></p>
                                <button type="button" class="create-button" onclick="displayFurniture()"><p>Finalize</p></button>
                        </div>
                </div>
        </div>

        <div id="furnitureModal" class="modal">
                <div class="modal-content-redirect">
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
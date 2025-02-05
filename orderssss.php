<?php require 'connectDB.php';
$ordersTable = "SELECT * FROM orders";
$orders = $connection->query($ordersTable);

if (!$orders){
    die("Invalid query: " . $connection->error);
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="orders.css">
    <title>Orders | JD Records</title>
    
</head>
<body>

<nav class="site-nav grid">
            <a href="orders.php">Orders</a>
            <a href="index.php">Customers</a>
            <div class="search-bar">
                <div class="back-type">
                    <a href="login.php"><img src="assets/img/Back.png" alt=""></a>
                    <img src="assets/img/Search.png" alt="Search icon">
                <form>
                    <input type="text" id="search" placeholder="Search">
                </form>
                </div>
                
                <div class="filterbox">
                    <img src="assets/img/Filter.png" alt="">
                </div>
                
            </div>
    </nav>
    <?php
    while ($order = $orders->fetch_assoc()) {
        $cust_num = $order["CUST_NUM"];
        $customer = $connection->query("SELECT * FROM customers WHERE CUST_NUM = $cust_num")->fetch_assoc();
        
        echo '<a href="orderinfo.php?orn='?><?php echo urlencode($order["ORDER_NUM"]) ?>">
        <?php echo'<div class="row-container">
    <div class="furniture"><img src="assets/orders_img/'. $order["furnitureIMG"] . '" width="100px" height="100px"></div>  
    <br>
        <p class="date">'. $order["ORDER_DATE"] .'</p>
    <br>
        <p class="customername">' . $customer["LAST_NAME"] . ", " . $customer["FIRST_NAME"] .'</p>
    <br>
        <div class="ordernumber"><h2>Order no. ' . $order["ORDER_NUM"] . '</h2></div>
    <br>
        <div class="price"><p>₱'. $order["PRICE"] . '</p></div>
    <br>
        <div class="status"><p>'. $order["STATUS"] . '</p></div>
    <br>
        <div class="customer"><img src="assets/customer_img/' . $customer["IMG"] . '" width="50px" height="40px"></div>
    <br>
    </div>'?></a>
    <?php
    }
    ?>
    <div class="create-gen grid">
    <div class="create-record">
            <a class="create-button" href="create.php">
                <img src="assets/img/Create.png" alt="">
                <p>Create <br>Record</p>
            </a>
    </div>
    <div class="generate-chart">
        <div class="generate-button">
            <img src="assets/img/generate.png" alt="">
            <p>Generate <br>Chart</p>
        </div>
    </div>

</body>

</html>

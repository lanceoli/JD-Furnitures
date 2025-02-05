<!--NEEDS EDITING-->               
<?php require 'connectDB.php';
$order_num = $_GET['orno'];

$data = "SELECT *
        FROM orders o
        JOIN customer_orders co ON o.ORDER_NUM = co.ORDER_NUM
        JOIN furnitures f ON co.FURNITURE_ID = f.FURNITURE_ID
        WHERE o.ORDER_NUM = $order_num"; // = o.ORDER_NUM = $order_num
$result = $connection->query($data);

if (!$result){
    die("Invalid query: " . $connection->error);
}
$orderArray = array();
while($row = $result->fetch_assoc()) {
    $orderArray[] = $row;
}
$order = $orderArray[0];
$cust_num = $order["CUST_NUM"];
$customer = $connection->query("SELECT * FROM customers WHERE CUST_NUM = $cust_num")->fetch_assoc();
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="orderinfo.css">
    <title>Order Info</title>
    
</head>

<body>
    <nav class="site-nav grid"> 
    <a href="UT-adminorders.php"><img src="assets/img/Back.png"></a>
    <p>Order Info</p>
</nav>
    <?php
    $progress = $order["STATUS"];

    echo'
        <div>
        <div class="colored-box-1">
        <h2>ORDER PROGRESS</h2>
        
        <img id="myImage" src="assets/pending.png" style="width:100%">

        <p class="field"><b>Order ID:</b>&nbsp;'.$order["ORDER_NUM"].'</p>
        <p class="field"><b>Order Date:</b>&nbsp;'.$order["ORDER_DATE"].'</p>
        <p class="field"><b>Estimated Delivery Date:</b>&nbsp; '.$order["EST_DATE"].'</p>
        <p class="field"><b>Payment Method:</b>&nbsp; '.$customer["MODE_OF_PAY"].'</p>
        <p class="field"><b>Total Cost:</b>&nbsp; '.$order["TOTAL_COST"].'</p>
        <p class="field"><b>Special Instructions:</b>&nbsp;'.$order["ADD_INFO"].'</p>


        ';
        ?>

        <form id="formm" action="editorder.php?orno= <?php echo $order_num ?>" method="post" enctype="multipart/form-data">
            <input type="text" name="status" id="status" value='<?php echo $order["STATUS"] ?>' hidden> <!-- End of input -->

            <div class="rect-button field" onclick="updateOrderProgress()">
            <p class="field">UPDATE ORDER PROGRESS</p>
            </div>

        </form>
        </div>
      
    <script>

            if(document.getElementById("status").value == "Shipping"){
                document.getElementById('myImage').src='assets/ship.png'
            }

            if(document.getElementById("status").value == "Delivered"){
                document.getElementById('myImage').src='assets/delivered.png'
            }


        function updateOrderProgress() {

            let promptt = prompt("Enter Order Progress", '');
  
            document.getElementById("status").value = promptt;
              
            document.getElementById("formm").submit();
           
        }
    </script>
        
        <?php 

for($i = 0; $i < count($orderArray); $i++) {
    $furniture = $orderArray[$i];
    echo'

        <div class="colored-box">
        <div class="furniture"><img src="assets/furniture_img/'. $furniture["FURNITURE_IMG"] . '" width="96%" height="30%"></img></div>
        <br><br><br><br><br><br>
        <h2 style="margin-top:-140px;">DESIGN DETAILS</h2>
        <p style="margin-left:35px; margin-top:30px;"><b>Material:</b>&nbsp;' . $furniture["MATERIAL"] . '</p>
        <p style="margin-left:35px; margin-top:19px;"><b>Color:</b>&nbsp;' . $furniture["COLOR"] . '</p>
        <p style="margin-left:35px; margin-top:19px;"><b>Style:</b>&nbsp;' . $furniture["STYLE"] . '</p>
        <p style="margin-left:35px; margin-top:19px;"><b>Quantity:</b>&nbsp;' . $furniture["QUANTITY"] . '</p>
        <h2 style="margin-top:10px;">FEATURES</h2>
        <p style="margin-left:35px; margin-top:19px;">' . $furniture["FEATURES"] . '</p>

        </div>

    ';
}
?>
    
        
</body>
</html>
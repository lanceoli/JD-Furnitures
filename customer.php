<?php require 'connectDB.php';
$cust_num = $_GET['cust'];
session_start();
unset($_SESSION['last-name']);
unset($_SESSION['first-name']);
unset($_SESSION['middle-name']);
unset($_SESSION['birthday']);
unset($_SESSION['email']);
unset($_SESSION['phone']);
unset($_SESSION['company']);
unset($_SESSION['res-loc']);
unset($_SESSION['bus-loc']);
unset($_SESSION['mode-pay']);
unset($_SESSION['add-info']);
if($_SESSION["status"] != true)
{
    header("location:login.php");
}
$data = "SELECT * FROM orders o
        JOIN customer_orders co ON o.ORDER_NUM = co.ORDER_NUM
        JOIN furnitures f ON co.FURNITURE_ID = f.FURNITURE_ID
        JOIN customers c ON o.CUST_NUM = c.CUST_NUM
        WHERE c.CUST_NUM = $cust_num";
$result = $connection->query($data);
if($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $customer = $row;
    $result->data_seek(0);
}
else {
    $data = "SELECT * FROM customers WHERE CUST_NUM = '$cust_num'";
    $result = $connection->query($data);
    $row = $result->fetch_assoc();
    $customer = $row;
}
/*$custrow = "SELECT * FROM customers WHERE CUST_NUM = $cust_num";
$custdata = $connection->query($custrow);
$ordersdata= "SELECT * FROM orders WHERE CUST_NUM = $cust_num";
$orders = $connection->query($ordersdata);
if (!$custdata){
    die("Invalid query: " . $connection->error);
}
$customer = $custdata->fetch_assoc();*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="customer.css">
  
    <title>JDRM</title>
</head>
<body>
<nav class="site-nav grid"> 
    <a href="index.php"><img src="assets/img/Back.png" alt=""></a>
    <p>Customer Info</p>
</nav>
<section>
<?php
echo'<div class="primary">
    <img class="prof-img" src="assets/customer_img/' . $customer["IMG"] . '" alt="">
    <div class="name"><p>' . $customer["FIRST_NAME"]. " ". $customer["MIDDLE_NAME"][0] . ". ". $customer["LAST_NAME"] . '</p>
    <a href="customerEdit.php?cust='?><?php echo $cust_num ?>"><?php echo '
        <img class="icon" src="assets/img/edit.png" alt=""></a></div>
    <p>' . $customer["PHONE"] . '</p>
    <p>' . $customer["EMAIL"] . '</p>
</div>'
?>
</section>
<section class="addinfo">
    <div class="tabs-titles">
        <p id="detail" class="tab-title active-title">Details</p>
        <p id="order" class="tab-title">Orders</p>
    </div>
    <div class="contents-container">
    <div class="tab-contents  active-tab" id="details">
         <?php echo'
         <p class="subtitle">Birthday</p>
         <p class="info"> ' . date("F d, Y", strtotime($customer["BIRTHDAY"] )). '</p>
         <p class="subtitle">Residential Location</p>
         <p class="info">' . $customer["RESIDENT_LOCATION"] . '</p>
         <p class="subtitle">Company</p>
         <p class="info">' . $customer["COMPANY"] . '</p>
         <p class="subtitle">Company Location</p>
         <p class="info">' . $customer["COMPANY_LOCATION"] . '</p>
         <p class="subtitle">Mode of Payment</p>
         <p class="info">' . $customer["MODE_OF_PAY"] . '</p>
         <p class="subtitle">Additional Information</p>
         <p class="info">' . $customer["ADD_INFO"] . '</p>
         
         '?>
         <a href="deletecustomer.php?cust=<?php echo $cust_num ?>" onClick="javascript:return confirm('Are you sure to delete this?')">
         <div class="dlt-btn">
            <p class="dlt-text">Delete</p><img class="icon" src="assets/img/delete.png" alt="delete">
         </div></a>
        </div>
    <div class="tab-contents" id="orders">
    <?php
    $postedOrders = array();
    while ($order = $result->fetch_assoc()) {
        if(in_array($order, $postedOrders)) {
            continue;
        }
        $postedOrders[] = $order;
        echo '<a href="orderinfo.php?orno='?><?php echo urlencode($order["ORDER_NUM"]) ?>">
        <?php echo '<div class="card grid">
            <img src="assets/orders_img/' . $order["FURNITURE_IMG"] . '" alt="">
            <div class="details">
                <div class="orderdetails">
                    <p>' . $order["ORDER_DATE"] . '</p>
                    <p>' . $order["EST_DATE"] . '</p>
                    </div>
                <div class="ordernum">
                    <p>Order no. ' . $order["ORDER_NUM"]. '</p>
                </div>
                <div class="orderdetails">
                    <p>₱' . $order["PRICE"] . '</p>
                    <p>' . $order["STATUS"] . '</p>
                </div>
            </div>
        </div>'?>
    </a>
    <?php
    }
    ?>
    </div>
    </div>
    </div>
</section>
<script>
    var tabtitles=document.getElementsByClassName("tab-title");
    var tabcontents=document.getElementsByClassName("tab-contents");

    document.addEventListener("click", function(event){
        if(event.target.classList.contains('tab-title')){
            for(tabtitle of tabtitles){
                tabtitle.classList.remove("active-title");
            }
            for(tabcontent of tabcontents){
                tabcontent.classList.remove("active-tab");
            }
            event.target.classList.add("active-title");
            document.getElementById(event.target.id.concat("s")).classList.add("active-tab");
            
        }

    });
    </script>
</body>
</html>
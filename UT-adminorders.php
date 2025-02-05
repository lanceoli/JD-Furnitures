<?php
require 'connectDB.php';
session_start();
if ($_SESSION["status"] != true) {
    header("location:login.php");
}

$data = "SELECT * FROM orders";
$result = $connection->query($data);

if (!$result) {
    die("Invalid query: " . $connection->error);
}

$order_by = "";
if (isset($_GET['sort_option'])) {
    switch ($_GET['sort_option']) {
        case "order_date_asc":
            $order_by = "ORDER BY ORDER_DATE ASC";
            break;
        case "order_date_desc":
            $order_by = "ORDER BY ORDER_DATE DESC";
            break;
    }
}

if (!empty($order_by)) {
    $data .= " $order_by";
}

$result = $connection->query($data);

if (!$result) {
    die("Invalid query: " . $connection->error);
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="UT-adminorders.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Orders | JD Records</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>

    <nav class="site-nav grid">
            <a href="UT-admin.php">Customers</a>
            <a href="UT-adminorders.php">Orders</a>
            <div class="users-grid">
            <a href="UT-adminview.php" class="users"><img src="assets\img\wUsers.png"></a>
            </div>
            <div class="search-bar">
                <div class="back-type">
                    <a href="login.php"><img src="assets/img/Back.png" alt=""></a>
                    <button class="custom-button-search" type="submit"><img src="assets/img/Search.png" alt="Search icon"></button>
                <form action="" method="POST">
                <input type="text" name="id" id="search" placeholder="Search">
                </form>
                <div id="searchResults"></div>
                </div>
                
                <div class="filter-container">
            <img src="assets/img/filter.png" alt="Filter" class="filter-button" onclick="toggleSortOptions()">
            <div class="sort-options" id="sortOptions">
                <form method="get" action="">
                    <select name="sort_option">
                        <option value="">---Select Option---</option>
                        <option value="order_date_asc" <?php if (isset($_GET['sort_option']) && $_GET['sort_option'] == "order_date_asc"){ echo "selected";} ?>>Oldest</option>
                        <option value="order_date_desc" <?php if (isset($_GET['sort_option']) && $_GET['sort_option'] == "order_date_desc"){ echo "selected";} ?>>Newest</option>
                    </select>
                    <button type="submit">Filter</button>
                </form>
            </div>
        </div>
    </div>
    </nav>

    <div class="card-block">
    
    <?php
    
    while($order = $result->fetch_assoc()){
        echo '<a class="create-button" href="UT-orderinfo.php?orno='?><?php echo urlencode($order["ORDER_NUM"]) ?>">
    <?php 
    $data2 = 'SELECT * FROM customers WHERE CUST_NUM=' . $order["CUST_NUM"];
    $result2 = $connection->query($data2);
    $customer = $result2->fetch_assoc();
    
    $data3 = 'SELECT * FROM customer_orders WHERE ORDER_NUM=' . $order["ORDER_NUM"] . ' LIMIT 1';
    $result3 = $connection->query($data3);
    $customer_order = $result3->fetch_assoc();
    
    $data4 = 'SELECT * FROM furnitures WHERE FURNITURE_ID=' . $customer_order["FURNITURE_ID"] . ' ';
    $result4 = $connection->query($data4);
    $furnitures = $result4->fetch_assoc();

        echo '<div class="card grid">
            <img src="assets/furniture_img/' . $furnitures["FURNITURE_IMG"] . '" alt="">
            <div class="details">
                <div class="text-cust">
                    <div class="text">
                        <p>' . $order["ORDER_DATE"] . '</p><p>' . $customer["LAST_NAME"] . ', ' . $customer["FIRST_NAME"] . '</p>
                        <p>Order No.</p><p>' . $order["ORDER_NUM"] . '</p>
                        <p>₱' . $customer_order["TOTAL_COST"] . '</p><p>' . $order["STATUS"] . '</p>
                    </div>
                    <div class="cust">
                        <img src="assets/customer_img/' . $customer["IMG"] . '" alt="">
                    </div>
                </div>
                <div class="num-busloc">
                    <p></p>
                    <p></p>
                </div>
            </div>
        </div>';

        echo '</a>';
    }
    ?>
    
    </div>
    
    <div class="create-gen grid">
        <div class="create-record">
                <a class="create-button" href="UT-create_order.php">
                    <img src="assets/img/Create.png" alt="">
                    <p>Add <br>Order</p>
                </a>
        </div>
        <div class="generate-chart">
            <a class="generate-button" href="UT-adminGenChart.php?referrer=UT-adminorders.php">
                <img src="assets/img/generate.png" alt="">
                <p>Generate <br>Chart</p>
            </a>
        </div>
    </div>

    <script>
    $(document).ready(function(){
        $("#search").on("input", function(){
            var query = $(this).val().trim().toLowerCase();
            $(".card.grid").each(function() {
                var orderNum = $(this).find('.text-cust .text p:eq(2)').text().trim();
                var orderDate = $(this).find('.text-cust .text p:eq(0)').text().trim();
                var orderPrice = $(this).find('.text-cust .text p:eq(4)').text().trim();
                if(orderNum.includes(query) || orderDate.includes(query) || orderPrice.includes(query)) {
                    $(this).show(); 
                } else {
                    $(this).hide(); 
                }
            });
        });
    });

    function toggleSortOptions() {
        var sortOptions = document.getElementById("sortOptions");
        if (sortOptions.style.display === "block") {
            sortOptions.style.display = "none";
        } else {
            sortOptions.style.display = "block";
        }
    }

    document.querySelector("select[name='sort_option']").addEventListener("change", function() {
        var selectedOption = this.value;
        var currentURL = window.location.href;
        var queryString = window.location.search;

        var currentSortOrder = queryString.includes("order_date_desc") ? "order_date_desc" : "order_date_asc";

        if (selectedOption !== currentSortOrder) {
  
            var newSortOrder = selectedOption === "order_date_desc" ? "order_date_desc" : "order_date_asc";

            var newQueryString = queryString.replace(currentSortOrder, newSortOrder);

            window.location.href = currentURL.replace(queryString, newQueryString);
        }
    });
</script>

    </body>
    </html>
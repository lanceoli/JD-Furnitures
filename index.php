<?php require 'connectDB.php';
$data = "SELECT * FROM customers";
$result = $connection->query($data);
session_start();
if (!$result){
    die("Invalid query: " . $connection->error);
}

if($_SESSION["status"] != true)
{
    header("location:login.php");
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Customers | JD Records</title>
</head>
<body>

    <nav class="site-nav grid">
            <a href="index.php">Customers</a>
            <a href="orders.php" onclick="document.write('<?php $_SESSION['status'] = true; ?>');">Orders</a>
            <div class="search-bar">
                <div class="back-type">
                    <a href="login.php"><img src="assets/img/Back.png" alt=""></a>
                    <button class="custom-button-search" type="submit"><img src="assets/img/Search.png" alt="Search icon"></button>
                <form action="" method="POST">
                    <input type="text" name="id" id="search" placeholder="Search">
                </form>
                </div>
                
                <div class="filter-container">
                <img src="assets/img/filter.png" alt="Filter" class="filter-button" onclick="toggleSortOptions()">
                <div class="sort-options" id="sortOptions">
                    <form method="get" action="">
                        <select name="sort_option">
                            <option value="">---Select Option---</option>
                            <option value="a-z" <?php if (isset($_GET['sort_option']) && $_GET['sort_option'] == "a-z"){ echo "selected";} ?>>A-Z (Ascending Order)</option>
                            <option value="z-a" <?php if (isset($_GET['sort_option']) && $_GET['sort_option'] == "z-a"){ echo "selected";} ?>>Z-A (Descending Order)</option>
                            <option value="recent" <?php if (isset($_GET['sort_option']) && $_GET['sort_option'] == "recent"){ echo "selected";} ?>>Recently Added</option>
                            <option value="oldest" <?php if (isset($_GET['sort_option']) && $_GET['sort_option'] == "oldest"){ echo "selected";} ?>>Oldest</option>
                        </select>
                        <button type="submit">Filter</button>
                    </form>
                </div>
            </div>
            <script>
                function toggleSortOptions() {
                    var sortOptions = document.getElementById("sortOptions");
                    if (sortOptions.style.display === "block") {
                        sortOptions.style.display = "none";
                    } else {
                        sortOptions.style.display = "block";
                    }
                }
            </script>
            </div>
    </nav>

    <?php
        require 'connectDB.php';
        $conn = new mysqli($servername, $username, $password, $database);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
    
        $order_by = "";
    
        if (isset($_GET['sort_option']) && !empty($_GET['sort_option'])) {
            switch ($_GET['sort_option']) {
                case "a-z":
                    $order_by = "ORDER BY FIRST_NAME ASC"; 
                    break;
                case "z-a":
                    $order_by = "ORDER BY FIRST_NAME DESC";
                    break;
                case "recent":
                    $order_by = "ORDER BY LAST_NAME DESC"; 
                    break;
                case "oldest":
                    $order_by = "ORDER BY LAST_NAME ASC";
                    break;
            }
        }
    
        $sql = "SELECT * FROM customers";
    
        if (!empty($order_by)) {
            $sql .= " $order_by";
        }
    
        $result = $conn->query($sql);
    
        if ($result->num_rows > 0) {
            echo '<div class="card-block">';
            while ($row = $result->fetch_assoc()) {
                echo '<a class="create-button" href="customer.php?cust=' . urlencode($row["CUST_NUM"]) . '">
                    <div class="card grid">
                        <img src="assets/customer_img/' . $row["IMG"] . '" alt="">
                        <div class="details">
                            <div class="name">
                                <p>' . $row["FIRST_NAME"] . ' ' . substr($row["MIDDLE_NAME"], 0, 1) . '.' . ' ' . $row["LAST_NAME"] . '</p>
                            </div>
                            <div class="num-busloc">
                                <p>' . $row["PHONE"] . '</p>
                                <p>' . $row["COMPANY_LOCATION"] . '</p>
                            </div>
                        </div>
                    </div>
                </a>';
            }
            echo '</div>';
        } else {
            echo "No results found.";
        }
    
        $conn->close();
    ?>

<div class="card-block">
 <?php

while($customer = $result->fetch_assoc()){
    echo '<a class="create-button" href="customer.php?cust='?><?php echo urlencode($customer["CUST_NUM"]) ?>">
        <?php echo '<div class="card grid">
    <img src="assets/customer_img/' . $customer["IMG"] . '" alt="">
    <div class="details">
        <div class="name">
            <p>' . $customer["FIRST_NAME"] . " " . $customer["MIDDLE_NAME"][0] . "." . " " . $customer["LAST_NAME"] . '</p>
        </div>
        <div class="num-busloc">
            <p>' . $customer["PHONE"] . '</p>
            <p>' . $customer["COMPANY_LOCATION"] . '</p>
        </div>
    </div>
</div>'?></a>
<?php
}
     ?>
</div>

<div class="create-gen grid">
    <div class="create-record">
            <a class="create-button" href="create.php">
                <img src="assets/img/Create.png" alt="">
                <p>Create <br>Record</p>
            </a>
    </div>
    <div class="generate-chart">
        <a class ="generate-button "href="genChart.php?referrer=index.php">
            <img src="assets/img/generate.png" alt="">
            <p>Generate <br>Chart</p>
        </a>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        $("#search").on("input", function(){
            var query = $(this).val().trim().toLowerCase();
            $(".card.grid .details .name").each(function() {
                var customerName = $(this).text().toLowerCase();
                if(customerName.includes(query)) {
                    $(this).closest('.card.grid').show();
                } else {
                    $(this).closest('.card.grid').hide();
                }
            });
        });
    });
</script>

<script>
    function toggleSortOptions() {
        var sortOptions = document.getElementById("sortOptions");
        if (sortOptions.style.display === "block") {
            sortOptions.style.display = "none";
        } else {
            sortOptions.style.display = "block";
        }
    }
</script>
</body>
</html>
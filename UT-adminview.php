<?php require 'connectDB.php';
$data = "SELECT * FROM employees";
$result = $connection->query($data);
session_start();
unset($_SESSION['last-name']);
unset($_SESSION['first-name']);
unset($_SESSION['middle-name']);
unset($_SESSION['username']);
unset($_SESSION['password']);
if($_SESSION["status"] != true)
{
    header("location:login.php");
}
if (isset($_GET['sort_option'])) {

    $sort_option = $_GET['sort_option'];

    switch ($sort_option) {
        case "a-z":
            $sort_query = "ORDER BY FIRST_NAME ASC"; 
            break;
        case "z-a":
            $sort_query = "ORDER BY FIRST_NAME DESC";
            break;
        case "recent":
            $sort_query = "ORDER BY LAST_NAME DESC"; 
            break;
        case "oldest":
            $sort_query = "ORDER BY LAST_NAME ASC";
            break;
        default:
            $sort_query = "";
    }
} else {
    $sort_query = ""; 
}

$sql = "SELECT * FROM employees $sort_query";

$result = $connection->query($sql);

if (!$result) {
    die("Invalid query: " . $connection->error);
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="UT-adminview.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Admin View | JD Records</title>
</head>
<body>

    <nav class="site-nav grid">
            <a href="UT-admin.php">Customers</a>
            <a href="UT-adminorders.php">Orders</a>
            <div class="users-grid">
            <a href="UT-adminview.php" class="users"><img src="assets\img\bUsers.png"></a>
            </div>
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
    </nav>
    <div class="card-block">
 <?php

while($employee = $result->fetch_assoc()){
    echo '<a class="create-button" href="UT-userinfo.php?emp='?><?php echo urlencode($employee["id"]) ?>">
        <?php echo '<div class="card grid">
    <img src="assets/employee_img/' . $employee["IMG"] . '" alt="">
    <div class="details">
        <div class="name">
            <p>' . $employee["FIRST_NAME"] . " " . $employee["MIDDLE_NAME"][0] . "." . " " . $employee["LAST_NAME"] . '</p>
        </div>
        <div class="num-busloc">
            <p>' . $employee["USERNAME"] . '</p>
            <p>' . $employee["PASSWORD"] . '</p>
        </div>
    </div>
</div>'?></a>
<?php
}
     ?>
</div>
<div class="create-gen grid">
    <div class="create-record">
            <a class="create-button" href="UT-AVcreate.php">
                <img src="assets/img/Create.png" alt="">
                <p>Create User</p>
            </a>
    </div>
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
    
</body>
</html>
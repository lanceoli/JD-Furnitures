<?php
require 'connectDB.php';

$cust_num = $_GET['cust'];

$delete = "SET FOREIGN_KEY_CHECKS=0";
$sql = $connection->query($delete);

$delete = "DELETE FROM customers WHERE CUST_NUM=$cust_num";
$sql = $connection->query($delete);

$delete = "DELETE FROM orders WHERE CUST_NUM=$cust_num";
$sql = $connection->query($delete);

$delete = "SET FOREIGN_KEY_CHECKS=1";
$sql = $connection->query($delete);

header("Location: index.php");
?>
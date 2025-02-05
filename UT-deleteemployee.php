<?php
require 'connectDB.php';

$emp_num = $_GET['emp'];

$delete = "DELETE FROM employees WHERE id=$emp_num";
$sql = $connection->query($delete);

header("Location: UT-adminview.php");
?>
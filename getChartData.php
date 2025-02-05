<?php
require 'connectDB.php';

if(isset($_GET['chartType'])) {
    $chartType = $_GET['chartType'];
    $year = $_GET['year'];
    $monthType = $_GET['monthType'];
    
    $query = "SELECT * FROM orders ORDER BY ORDER_DATE ASC";

    $ordersdata = $connection->query($query);

    if (!$ordersdata) {
        die("Invalid query: " . $connection->error);
    }

    $data = array();
    switch($chartType) {
        case 'overall':
            while ($row = $ordersdata->fetch_assoc()) {
                $data[] = $row;
            }
            break;
        case 'monthly':
            while ($row = $ordersdata->fetch_assoc()) {
                if (date('F', strtotime($row['ORDER_DATE'])) == $monthType && date('Y', strtotime($row['ORDER_DATE'])) == $year) {
                    $data[] = $row;
                }
            }
            break;
        case 'yearly':
            while ($row = $ordersdata->fetch_assoc()) {
                if (date('Y', strtotime($row['ORDER_DATE'])) == $year ) {
                    $data[] = $row;
                }
            }
            break;
        case 'quarter':
            $quarterMonths = [];
            switch($monthType) {
                case '1st Quarter':
                    $quarterMonths = ["January", "February", "March"];
                    break;
                case '2nd Quarter':
                    $quarterMonths = ["April", "May", "June"];
                    break;
                case '3rd Quarter':
                    $quarterMonths = ["July", "August", "September"];
                    break;
                case '4th Quarter':
                    $quarterMonths = ["October", "November", "December"];
                    break;
            }
            while ($row = $ordersdata->fetch_assoc()) {
                $orderMonth = date('F', strtotime($row['ORDER_DATE']));
                if (in_array($orderMonth, $quarterMonths) && date('Y', strtotime($row['ORDER_DATE'])) == $year) {
                    $data[] = $row;
                }
            }
            break;
    }

    header('Content-Type: application/json');
    echo json_encode($data);
}
?>
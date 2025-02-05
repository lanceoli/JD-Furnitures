<?php
require 'connectDB.php';
session_start();
$ORDER_NUM = "";
$FURNITURE_NAME = "";
$PRICE = "";
$QUANTITY = "";
$TOTAL_COST = "";
$MATERIAL = "";
$COLOR = "";
$STYLE = "";
$FEATURES = "";
$newFurniture = "";

$errormessage = "";
$err_ln = "";

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $ORDER_NUM = $_POST["ORDER_NUM"];
    $FURNITURE_NAME = $_POST["FURNITURE_NAME"];
    $PRICE = floatval($_POST["PRICE"]);
    $QUANTITY = intval($_POST["QUANTITY"]);
    $TOTAL_COST = $PRICE * $QUANTITY;
    $MATERIAL = $_POST["MATERIAL"];
    $COLOR = $_POST["COLOR"];
    $STYLE = $_POST["STYLE"];
    /*$featureCounterInput = $_POST["featureCounterInput"];
    for ($i = 1; $i < $featureCounterInput; $i++) {
        $FEATURES .= $_POST["FEATURES$i"] . ";";
    }*/
    $FEATURES = $_POST["FEATURES"];
    $finalize = $_POST["finalize"];

    $_SESSION["FURNITURE_NAME"] = $_POST["FURNITURE_NAME"];
    $_SESSION["PRICE"] = $_POST["PRICE"];
    $_SESSION["QUANTITY"] = $_POST["QUANTITY"];
    $_SESSION["TOTAL_COST"] = $PRICE * $QUANTITY;
    $_SESSION["MATERIAL"] = $_POST["MATERIAL"];
    $_SESSION["COLOR"] = $_POST["COLOR"];
    $_SESSION["STYLE"] = $_POST["STYLE"];
    $_SESSION["FEATURES"] = $_POST["FEATURES"];
    /*$_SESSION["featureCounterInput"] = $_SESSION["featureCounterInput"];
    $featuresArray = explode(';', $FEATURES);
    for ($i = 1; $i < $featureCounterInput; $i++) {
        $currentFeature = $featuresArray[$i - 1];
        if(!empty($currentFeature)) {
            $_SESSION["FEATURES$i"] = $currentFeature;
        }
        else {
            $_SESSION["FEATURES$i"] = ";";
        }
    }*/
    

  
    if(empty(trim($FURNITURE_NAME)) || empty(trim($PRICE)) || 
    empty(trim($QUANTITY)) || empty(trim($MATERIAL)) || 
    empty(trim($COLOR)) || empty(trim($FEATURES)) ||
    empty(trim($STYLE))) {
        header('Location: UT-create_product.php?error=missing&ORDER_NUM=' . $ORDER_NUM);
        exit();
    }elseif($_FILES["create-img"]["error"] == UPLOAD_ERR_NO_FILE){
        header('Location: UT-create_product.php?error=noimg&ORDER_NUM=' . $ORDER_NUM);
        exit();
    }

   do{
        if (empty(trim($FURNITURE_NAME)) || empty(trim($PRICE)) || 
        empty(trim($QUANTITY)) || empty(trim($MATERIAL)) || 
        empty(trim($COLOR)) || empty(trim($FEATURES)) ||
        empty(trim($STYLE))){
            $errormessage = "You have missed a field";
            break;
        }
    


        $sql = "INSERT INTO furnitures (FURNITURE_NAME, PRICE, MATERIAL, COLOR, STYLE, FEATURES)
        VALUES ('$FURNITURE_NAME', '$PRICE', '$MATERIAL', '$COLOR', '$STYLES', '$FEATURES');";
        $result = $connection->query($sql);

        $sql = "SELECT MAX(FURNITURE_ID) AS maxFurnitureID FROM furnitures";
        $result = $connection->query($sql);
        $row = $result->fetch_assoc();
        $FURNITURE_ID = $row['maxFurnitureID'];
        
        $sql = "INSERT INTO customer_orders (ORDER_NUM, FURNITURE_ID, QUANTITY, TOTAL_COST)
        VALUES ('$ORDER_NUM', '$FURNITURE_ID', '$QUANTITY', '$TOTAL_COST')";
        $connection->query($sql);

        $sql = "SELECT * FROM orders WHERE ORDER_NUM = '$ORDER_NUM'";
        $result = $connection->query($sql);
        $row = $result->fetch_assoc();
        $orderCost = $row["ORDER_COST"];
        $orderCost = $orderCost + $TOTAL_COST;
        $sql = "UPDATE orders 
                SET ORDER_COST = '$orderCost'
                WHERE ORDER_NUM = '$ORDER_NUM'";
        $connection->query($sql);

        $FURNITURE_NAME = "";
        $PRICE = "";
        $QUANTITY = "";
        $TOTAL_COST = "";
        $MATERIAL = "";
        $COLOR = "";
        $STYLE = "";
        $FEATURES = "";

        $filename = $FURNITURE_ID;
        $ext = pathinfo($_FILES["create-img"]["name"],  PATHINFO_EXTENSION);
        $destination = __DIR__ . "/assets/furniture_img/" . $filename . "." . $ext;

        if(!move_uploaded_file($_FILES["create-img"]["tmp_name"], $destination)){
            exit("cant move file");
        }

        $sql = 'UPDATE furnitures SET FURNITURE_IMG = "' . $filename . '.' . $ext . '" WHERE  FURNITURE_ID = ' . $filename;
        $result = $connection->query($sql);

        $_SESSION["FURNITURE_NAME"] = null;
        $_SESSION["PRICE"] = null;
        $_SESSION["QUANTITY"] = null;
        $_SESSION["TOTAL_COST"] = null;
        $_SESSION["MATERIAL"] = null;
        $_SESSION["COLOR"] = null;
        $_SESSION["STYLE"] = null;
        $_SESSION['FEATURES'] = null;

        if($PRODUCT_NUM == 0) {
            $PRODUCT_NUM = 1;
        }
        else {
            $PRODUCT_NUM++;
        }
        
        header("Location: UT-create_product.php?ORDER_NUM=" . $ORDER_NUM);
    }while(false);
}




?>
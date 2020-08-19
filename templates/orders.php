<?php
	error_reporting(0);
	//GET USERNAME
    session_start();
    $username = $_SESSION["username"];
    //RETRIEVE DATA
    if($_SESSION["ORDERS"] != "TRUE"){
        $_SESSION["dbQuery"] = "2";
        header("Location: /db.php");
    }
    //RETREIEVE ORDERS
    $arraysOrders = $_SESSION["dataOrders"];
    $counter = 0;
    //COUNT ORDERS
    foreach($arraysOrders as $key => $value){
        $counter++;
    }
    //DISPLAY HEADER
    echo "<h2>Purchase Orders (" . $counter . ")</h2><hr>";
    //DISPLAY ORDERS
    for ($i=0; $i < $counter; $i++) {
        
        echo "Order Number: <b>" . $arraysOrders[$i][0] . "</b> (<i>Confirmation# <a href='". $arraysOrders[$i][3] ."' download>" . $arraysOrders[$i][2] . "</a></i>)" . "<br><br>";
    }
    //SEND NUMBER OF ORDERS
    $_SESSION["numberOrders"] =  $counter;
?>
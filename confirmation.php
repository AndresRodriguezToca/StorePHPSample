<?php
    error_reporting(0);
	//CHECK ACCESS TOKEN FROM LOGIN SESSION
	session_start();
    if($_SESSION["ACCESS"] != "TRUE"){
		header("Location: /login.php?ACCESS_DENIED_403");
    }
    //FILE VARIABLES
	$target_dir = "orders/";
	$image = $txt = "";
	$ok = 1;
    $containNumbers = true;
    $arraysListings = $_SESSION["dataListings"];
    $username = $_SESSION["username"];
    //RETRIVE QUANTITY
    $listing = array($_POST["A1333"], $_POST["A1443"], $_POST["A1444"],$_POST["A1445"], $_POST["A1446"], $_POST["A1448"], $_POST["A1449"], $_POST["A14410"],$_POST["A14412"], $_POST["A14416"],$_POST["A14418"], $_POST["A14420"], $_POST["A14424"], $_POST["A14428"], $_POST["A14430"], $_POST["A14432"], $_POST["A1553"], $_POST["A1554"], $_POST["A1555"], $_POST["A1558"], $_POST["A1668"]);

    //RETRIEVE ADDED
    $add1 = $_POST["0"];
    $add2 = $_POST["1"];
    $add3 = $_POST["2"];
    $add4 = $_POST["3"];
    $add5 = $_POST["4"];
    $add6 = $_POST["5"];
    $add7 = $_POST["6"];
    $add8 = $_POST["7"];
    $add9 = $_POST["8"];
    $add10 = $_POST["9"];
    $add11 = $_POST["10"];
    $add12 = $_POST["11"];
    $add13 = $_POST["12"];
    $add14 = $_POST["13"];
    $add15 = $_POST["14"];
    $add16 = $_POST["15"];
    $add17 = $_POST["16"];
    $add18 = $_POST["17"];
    $add19 = $_POST["18"];
    $add20 = $_POST["19"];
    $add21 = $_POST["20"];

    //GET A CONFIRMATION ORDER
    $confirmation = rand(1000, 90000);
    $fileName = $confirmation . ".txt";
    //SAVE ORDER IN A FILE
    $myfile = fopen("orders/". $fileName, "w");
    $txt = "CONFIRMATION NUMBER: " . $confirmation . "\n";
    fwrite($myfile, $txt);
    $txt = "ORDER CREATED BY " . $_SESSION["fname"] . " " . $_SESSION["lname"] . " from " . $_SESSION["company"] . "\n";
    fwrite($myfile, $txt);
    $o = 0;
    $total = 0;
    for ($i=0; $i < 21; $i++) {
        if($_POST[$i] != NULL){
            $txt = "\n" . "Item: " . $arraysListings[$i][1] . " ";
            fwrite($myfile, $txt);
            $txt = "Quantity: " . $listing[$i] . "\n";
            fwrite($myfile, $txt);
            $newprice = $arraysListings[$i][3] * $listing[$i];
            $txt = "Quantity Price: $" . $newprice;
            fwrite($myfile, $txt);
            $total = $total + $newprice;
        }
    }
    $txt = "\n" . "\n" . "Total Due: $" . $total . "\n";
    fwrite($myfile, $txt);
    fclose($myfile);

    //SAVE ORDER ON DATABASE
    //CREATE CONNECTION
    $db_connection = new PDO("mysql:host=localhost;dbname=store" ,"root" ,"1234");
    $db_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $idUser = $_SESSION["idUser"];
    $filePath = "orders/" . $confirmation . ".txt";
    $status = "PENDING";
    try {
        //INSERT
        $sqlQueryOrder = 'INSERT INTO orders (`idUser`, `confirmationNumber`, `fileOrderData`, `status`) VALUES ("' . $idUser . '", "' . $confirmation . '", "' . $filePath . '", "' . $status . '")';

        $db_connection->exec($sqlQueryOrder);
        header("Location: /index.php?newOrder=true");

    } catch (PDOException $e) {
        echo $e->getMessage();
    }

?>
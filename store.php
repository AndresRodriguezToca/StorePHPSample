<?php
	//CHECK ACCESS TOKEN FROM LOGIN SESSION
	session_start();
    if($_SESSION["ACCESS"] != "TRUE"){
		header("Location: /login.php?ACCESS_DENIED_403");
    }
    

?>
<!DOCTYPE html>
<html>
	<head>
		<!--TITLE-->
		<title>Portal Distributor</title>
		
		<!--META HTML-->
		<meta name="description" content="Just a brief summary about me...">

		<!--STYLES CSS-->
		<link rel="stylesheet" type="text/css" href="styles/style.css">
        <style>
      #boxes {
        content: "";
        display: table;
        clear: both;
      }
      .div-special {
        float: left;
        height: 610px;
        width: 33.3%;
        padding: 0 10px;
      }
      #column1 {
        background-color: white;
      }
      #column2 {
        background-color: white;
        width: 33.3%;
      }
      #column3 {
        background-color: white;
      }
      h2 {
        color: #000000;
        text-align: center;
      }
    </style>
	</head>
	<body>
		
		<!--INCLUDE HEADER-->
		<?php include 'templates/header.php';?>
        <?php include 'templates/listings.php';?>
    </body>
	<footer style="text-align:center;">
	
		<!--INCLUDE FOOTER-->
		<?php include 'templates/footer.php';?>

	</footer>
</html>
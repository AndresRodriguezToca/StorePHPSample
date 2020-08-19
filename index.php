<?php
	//CHECK ACCESS TOKEN FROM LOGIN SESSION
	session_start();
	$ordersNumber = $_SESSION["numberOrders"];
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

	</head>
	<body>
		
		<!--INCLUDE HEADER-->
		<?php include 'templates/header.php';?>

		<div class="container" style="text-align:left;">
			<?php include 'templates/orders.php';?>
		</div>

		<div class="container" style="text-align:left;">
			<h2>Latest Business News</h2>
			<h4>Small Business | Business Technology & Customer Support | Business Internet Advantages</h4>
			<img src="data\sale.jpg" width="400" height="300">
			<p>Offering discounts on purchases is a way to quickly draw people into your store. Anytime you tell a customer that he can save money, you’re likely to get his attention. Discounts don’t only help your shoppers; they also help your business. From increased sales to improved reputation, discounts may be that one ingredient that can bring business success</p>
			<p>Because people prefer buying things on sale, discounts serve as a ploy to attract more people to your store. If your discount is only good for a certain amount of days, mention that when you advertise the discounted items. People are more likely to rush in and look around if they know they only have a few days to do so. Your store will experience more traffic, so you may need to schedule more employees during the discount period so service is smooth.</p>
			<a href="https://smallbusiness.chron.com/advantages-offering-discounts-business-25765.html" target=”_blank”>READ MORE!</a><br>
			<i>By Chris Miksen Updated January 28, 2019 <i>
			<hr>
		</div>
	</body>
	<footer>
	
		<!--INCLUDE FOOTER-->
		<?php include 'templates/footer.php';?>

	</footer>
</html>
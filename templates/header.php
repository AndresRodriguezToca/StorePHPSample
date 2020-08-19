<?php
	error_reporting(0);
	//GET USERNAME
    session_start();
	$username = $_SESSION["username"];
	$fname = $_SESSION["fname"];
    $lname = $_SESSION["lname"];
?>
<!DOCTYPE html>
<html lang="en">
<style>
ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
  overflow: hidden;
  background-color: #333;
}

li {
  float: left;
}

li:last-child {
  border-right: none;
}

li a {
  display: block;
  color: white;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
}

li a:hover:not(.active) {
  background-color: #111;
}

.active {
  background-color: #4CAF50;
}
</style>
<body>
	<!--MENU ITEMS-->
	<ul>
		<li><a class="active" href="index.php">Dashboard</a></li>
		<li><a href="store.php">Enter an Order</a></li>
		<li><a href="myaccount.php">My Account</a></li>
		<li><a href="mailto: dashboard@support.com">Support</a></li>
		<li style="float:right;"><a href="logout.php" style="color:red;">Logout</a></li>
		<li style="float:right"><a href="#">Logged in as <?php echo ($fname . " " . $lname); ?></a></li>
	</ul>
</body>
</html>
<?php
	//CHECK ACCESS TOKEN FROM LOGIN SESSION
	session_start();
    if($_SESSION["ACCESS"] != "TRUE"){
		header("Location: /login.php?ACCESS_DENIED_403");
	}
	if($_SESSION["numberOrders"] == NULL){
		$_SESSION["numberOrders"] = 0;
		$noOrders = "There's no purchase order on our database.";
	}
	//PERSONAL INFO
	$fname = $lname = $username = $company = $password = $cpassword = "";
	$fnameerr = $lnameerr  = $companyeerr = $usernameerr = $passworderr = $cpassworderr = "";
	
	//OTHER VARIABLES
	$ok = 1;
	$containNumbers = true;
	
	//VALIDATE DATA
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		//FIRST NAME
		if (empty($_POST["fname"]) || $_POST["fname"] == " " || strlen($_POST["fname"]) < 2 || strlen($_POST["fname"]) > 50 || $containNumbers == preg_match('/[0-9]/',$_POST["fname"])) {
			$fnameerr = "Name is required or invalid!";
			$ok = 0;
		} else {
			$fname = checkInput($_POST["fname"]);
		}
		//LAST NAME
		if (empty($_POST["lname"]) || $_POST["lname"] == " " || strlen($_POST["lname"]) < 2 || $containNumbers == preg_match('/[0-9]/',$_POST["lname"])) {
			$lnameerr = "Last Name is required or invalid!";
			$ok = 0;
		} else {
			$lname = checkInput($_POST["lname"]);
		}
		//PASWWORD
		if (empty($_POST["password"]) || strlen($_POST["password"]) < 5) {
			$passworderr = "Password cannot be empty or not secure enough!";
			$ok = 0;
		} else {
			$password = checkInput($_POST["password"]);
		}
		//CONFIRM PASWWORD
		if (empty($_POST["cpassword"]) || strlen($_POST["cpassword"]) < 5) {
			$cpassworderr = "Password cannot be empty or less than 5 characters!";
			$ok = 0;
		} else {
			$cpassword = checkInput($_POST["cpassword"]);
		}
		//CHECK PASSWORD BEFORE SUBMIT TO FILE OR DB
		if($password != $cpassword){
			$passworderr = "Password do not match!";
			$cpassworderr = "Password do not match!";
			$ok = 0;
		}
		//HASH PASSWORD
		$password = password_hash($password, PASSWORD_DEFAULT);

		//SUBMIT INFO TO DB
		if($ok == 1){
			//PASS DATA TO DB PHP
			session_start();
			$_SESSION["fname"] = $fname;
			$_SESSION["lname"] = $lname;
			$_SESSION["password"] = $password;
			$_SESSION["dbQuery"] = "4";
			header("Location: /db.php");
		}
	}

	function checkInput($data) {
		  $data = trim($data);
		  $data = stripslashes($data);
		  $data = htmlspecialchars($data);
		  return $data;
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
        <form class="formstyle" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method ="POST" enctype="multipart/form-data" style="margin: 20vh 60vh 10vh 60vh">
			<h1>Update Personal Information</h1>
			<label for="fname">First name:</label>
			<input type="text" id="fname" name="fname" required>
			<span class="error"> <?php echo $fnameerr;?></span><br><br>
			<label for="lname">Last name:</label>
			<input type="text" id="lname" name="lname" required>
			<span class="error"> <?php echo $lnameerr;?></span><br><br>
			<hr>
			<br>
			<label for="password">New Password:</label>
			<input type="password" id="password" name="password" required>
			<span class="error"> <?php echo $passworderr;?></span><br><br>
			<label for="cpassword">Re-Enter Password:</label>
			<input type="password" id="cpassword" name="cpassword" required>
			<span class="error"> <?php echo $cpassworderr;?></span><br><br>
			<hr>
			<br>
			<button type="submit" class="registerbtn">Update Information</button>
		</form>
	</body>
	<footer>
	
		<!--INCLUDE FOOTER-->
		<?php include 'templates/footer.php';?>

	</footer>
</html>
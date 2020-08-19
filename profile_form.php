<?php 

	//PERSONAL INFO
	$fname = $lname = $username = $company = $password = $cpassword = "";
	$fnameerr = $lnameerr = $fileToUploaderr = $companyeerr = $usernameerr = $passworderr = $cpassworderr = "";
	
	//FILE VARIABLES
	$target_dir = "data/";
	$image = $txt = "";
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
		//USERNAME
		if (empty($_POST["username"]) || $_POST["username"] == " " || strlen($_POST["username"]) < 2) {
			$usernameerr = "User Name is required or invalid!";
			$ok = 0;
		} else {
			$username = $_POST["username"];
		}
		//Company
		if (empty($_POST["company"]) || $_POST["company"] == " " || strlen($_POST["company"]) < 2) {
			$companyeerr = "Company Name is required or invalid!";
			$ok = 0;
		} else {
			$company = $_POST["company"];
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
		// UPLOAD FILE EVENT
		$fileToUpload = false;
		if(isset($_POST['fileToUpload'])){
			$fileToUpload = $_POST["fileToUpload"];
		}
		if (empty($fileToUpload)) {
			try {
				$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
				$uploadOk = 1;
				$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

				// Check if file already exists
				if (file_exists($target_file)) {
					$fileToUploaderr = "File already exist or file cannot be empty!";
					$uploadOk = 0;
				}

				// Check if $uploadOk is set to 0 by an error
				if ($uploadOk == 1) {
					if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
						$image = $target_file; 
					} else {
						$fileToUploaderr = "Error uploading file. Try Again.";
					}
				}
			} catch (Exception $e) {
				$fileToUploaderr = "File unvalid!";
			}
		} else {
			$fileToUploaderr = "File cannot be empty!";
			$ok = 0;
		}
		//CHECK PASSWORD BEFORE SUBMIT TO FILE OR DB
		if($password != $cpassword){
			$passworderr = "Password do not match!";
			$cpassworderr = "Password do not match!";
			$ok = 0;
		}
		//HASH PASSWORD
		$password = password_hash($password, PASSWORD_DEFAULT);

		//SUBMIT INFO TO FILE
		if($ok == 1){
			//SAVE DATA IN A FILE
			$myfile = fopen("profile.txt", "w");
			$txt = "First Name: " . $fname . "\n";
			fwrite($myfile, $txt);
			$txt = "Last Name: " . $lname . "\n";
			fwrite($myfile, $txt);
			$txt = "Username: " . $username . "\n";
			fwrite($myfile, $txt);
			$txt = "Company: " . $company . "\n";
			fwrite($myfile, $txt);
			$txt = "Password: " . $password . "\n";
			fwrite($myfile, $txt);
			$txt = "Marketing File Path: " . $image . "\n";
			fwrite($myfile, $txt);
			fclose($myfile);
			//PASS DATA TO DB PHP
			session_start();
			$_SESSION["fname"] = $fname;
			$_SESSION["lname"] = $lname;
			$_SESSION["username"] = $username;
			$_SESSION["password"] = $password;
			$_SESSION["company"] = $company;
			$_SESSION["marketingfilepath"] = $image;
			$_SESSION["dbQuery"] = "1";
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
		<title>Assignment 3 - Profile Form</title>
		<link rel="stylesheet" type="text/css" href="styles\style.css">
	</head>
	<body>

		<!--START FORM-->
		<form class="formstyle" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method ="POST" enctype="multipart/form-data" style="margin: 20vh 60vh 10vh 60vh">
			<h1>Registration</h1>
			<label for="company">Company:</label>
			<input type="text" id="company" name="company" required>
			<span class="error"> <?php echo $companyeerr;?></span><br><br>
			<label for="username">Username:</label>
			<input type="text" id="username" name="username" required>
			<span class="error"> <?php echo $usernameerr;?></span><br><br>
			<hr>
			<br>
			<label for="fname">First name:</label>
			<input type="text" id="fname" name="fname" required>
			<span class="error"> <?php echo $fnameerr;?></span><br><br>
			<label for="lname">Last name:</label>
			<input type="text" id="lname" name="lname" required>
			<span class="error"> <?php echo $lnameerr;?></span><br><br>
			<hr>
			<br>
			<label for="password">Password:</label>
			<input type="password" id="password" name="password" required>
			<span class="error"> <?php echo $passworderr;?></span><br><br>
			<label for="cpassword">Re-Enter Password:</label>
			<input type="password" id="cpassword" name="cpassword" required>
			<span class="error"> <?php echo $cpassworderr;?></span><br><br>
			<hr>
			<br>
			<label for="marketing">Marketing Strategy:</label>
			<input type="file" name="fileToUpload" id="fileToUpload" required>
			<span class="error"> <?php echo $fileToUploaderr;?></span><br><br>
			<button type="submit" class="registerbtn">Register</button>
		</form>
	</body>

	<footer>
		
		<!--INCLUDE FOOTER-->
		<?php include 'templates/footer.php';?>

	</footer>
</html>
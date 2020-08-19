<?php
    //Declare variable
    $username = $password = $usernameerr = $passworderr = "";
    $ok = 1;

    //Validate Data
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //USERNAME
		if (empty($_POST["username"]) || $_POST["username"] == " " || strlen($_POST["username"]) < 2) {
			$usernameerr = "User Name is required or invalid!";
			$ok = 0;
		} else {
            $username = $_POST["username"];
		}
		//PASWWORD
		if (empty($_POST["password"]) || strlen($_POST["password"]) < 5) {
			$passworderr = "Password cannot be empty or not secure enough!";
			$ok = 0;
		} else {
			$password = checkInput($_POST["password"]);
        }
        
        //Send data to db...
        if($ok == 1){
            session_start();
            $_SESSION["username"] = $username;
            $_SESSION["password"] = $password;
            $_SESSION["dbQuery"] = "3";
            header("Location: /db.php");
        } else {
            session_start();
            $_SESSION["fail"] = "Credentials are incorrect. Try Again!";
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
		<title>Login Form</title>
		<link rel="stylesheet" type="text/css" href="styles/style.css">
	</head>
	<body>

		<!--START FORM-->
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method ="POST" enctype="multipart/form-data" style="margin: 20vh 60vh 10vh 60vh">
            <div class="container">
                <h1>DISTRIBUITOR PORTAL</h1>
                <hr>

                <label for="username"><b>Username</b></label>
                <input type="text" placeholder="Enter Username" name="username" id="username" required>
                <br>
                <label for="password"><b>Password</b></label>
                <input type="password" placeholder="Enter Password" name="password" id="password" required>

                <br>
                <button type="submit" class="registerbtn">Login</button>
                <?php
                    //GET ERROR CREDENTIALS FROM SESSION OR URL
                    $error = "";
                    try {
                        if(isset($_SESSION["fail"]) == false){
                            if(isset($_GET['login']) == true){
                                $error = $_GET['login'];
                                if($error == "exerror" || $error == "pwerror" || $error == "dberror"){
                                    $error = "Credentials are incorrect. Try Again!";
                                    echo "<p style= 'color: red;'>" . $error . "</p>";
                                }
                            }
                        } else {
                            $error = $_SESSION["fail"];
                            echo "<br> <p style= 'color: red;'>" . $error . "</p>";
                        }
                    } catch (\Throwable $th) {

                    }
                    
                ?>
                <div class="container signin">
                    <p>Not a dealer? Become one <a href="profile_form.php">here</a>.</p>
                    <p>Forgot password or username? Contact a representative immediately <a href="tel:+1234567890">(123)456-7890</a>.</p>
                </div>
            </div>
            
            
        </form>
	</body>
    <footer>
		
		<!--INCLUDE FOOTER-->
		<?php include 'templates/footer.php';?>

	</footer>
</html>
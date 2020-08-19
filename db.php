<?php 
    //DB INFO
    $servername = "localhost";
    $usernamedb = "root";
    $passworddb = "1234";
    $dbname = "store";

    //GET DATA FROM SESSION
    session_start();
    $dbQuery = $_SESSION["dbQuery"];
    $fname = $_SESSION["fname"];
    $lname = $_SESSION["lname"];
    $username = $_SESSION["username"];
    $idUser = $_SESSION["idUser"];
    $password = $_SESSION["password"];
    $company = $_SESSION["company"];
    $filepath = $_SESSION["marketingfilepath"];

    /*
    
    TYPE OF QUERY
    Fatal error: Uncaught Error: If Function name isn't a string
    
    1 => INSERT NEW DEALER
    2 => READ ORDERS DASHBOARD
    3 => CHECK LOGIN CREDENTIALS
    4 => Update Information
    5 => READ DATABASE LISTINGS
    */

    //CREATE CONNECTION
    $db_connection = new PDO("mysql:host=localhost;dbname=store" ,"root" ,"1234");
    $db_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //CHECK CONNECTION
    if(!$db_connection){
        die("Connection Failed!");
    } else{
        //EXECUTE TYPE OF QUERY
        switch ($dbQuery){
            case "1":
                try {
                    //INSERT
                    $sqlQueryUser = 'INSERT INTO users (`firstname`, `lastname`, `username`, `password`, `company`, `filepath`) VALUES ("' . $fname . '", "' . $lname . '", "' . $username . '", "' . $password . '", "' . $company . '", "' . $filepath . '")';

                    $db_connection->exec($sqlQueryUser);
                    session_unset();
                    header("Location: /login.php?register=true");

                } catch (PDOException $e) {
                    echo $e->getMessage();
                }
                
            break;
            case "2":
                //READ ORDERS
                //CONNECT DB
                try {
                    //CREATE QUERY
                    $sqlQueryUser = $db_connection->query('SELECT * FROM orders  WHERE `idUser` = "' . $idUser . '"');

                    //FETCH DATA
                    $dataUser = $sqlQueryUser->fetchAll();

                    //TRIGGER VALIDATION ON INFO PAGE
                    $_SESSION["ORDERS"] = "TRUE";
                    $_SESSION["dataOrders"] = $dataUser;
                    header("Location: /index.php");

                } catch (PDOException $e) {
                    //DATABSE ERROR
                    echo ($e);
                }
            break;
            case "3":
                //CONNECT DB
                try {
                    //CREATE QUERY
                    $sqlQueryUser = $db_connection->query('SELECT * FROM users  WHERE `username` = "' . $username . '"');

                    //FETCH DATA
                    $dataUser = $sqlQueryUser->fetchAll();

                    //CHECK PASSWORD FROM LOGINS
                    if(password_verify($password, $dataUser[0]['password'])){
                        session_start();
                        //GET USER DATA
                        $_SESSION["idUser"] = $dataUser[0]['idUser'];
                        $_SESSION["fname"] = $dataUser[0]['firstname'];
                        $_SESSION["lname"] = $dataUser[0]['lastname'];
                        $_SESSION["username"] = $dataUser[0]['username'];
                        $_SESSION["company"] = $dataUser[0]['company'];
                        $_SESSION["filepath"] =  $dataUser[0]['filepath'];

                        //TRIGGER VALIDATION ON INFO PAGE
                        $_SESSION["ACCESS"] = "TRUE";
                        header("Location: /index.php?accesstoken=" . $dataUser[0]['company']);

                    } else {
                        //PASSWORD DOESN'T MATCH
                        $_SESSION["fail"] = "Credentials are incorrect. Try Again!";
                        header("Location: /login.php?login=pwerror");
                    }

                } catch (PDOException $e) {
                    //DATABSE ERROR
                    $_SESSION["fail"] = "Credentials are incorrect. Try Again!";
                    header("Location: /login.php?login=dberror");
                }
            break;
            case "4":
                //CONNECT DB
                try {
                    //UPDATE QUERY
                    if($db_connection->query('UPDATE users SET `firstname` = "' . $fname . '",  `lastname` = "' . $lname . '", `password` = "' . $password . '" WHERE `username` = "' . $username . '"') === TRUE){
                        echo "RECORD UPDATED SUCCESSFULLY";
                    }else{
                        echo "ERROR UPDATING RECORD" . $db_connection->error;
                    }
                    $_SESSION["ACCESS"] = "TRUE";
                    header("Location: /myaccount.php?updated=true-" . $dataUser[0]['company']);
                } catch (PDOException $e) {
                    //DATABSE ERROR
                    $_SESSION["fail"] = "Credentials are incorrect. Try Again!";
                    header("Location: /myaccount.php?updated=false1");
                }
            break;
            case "5":
                //READ LISTINGS
                //CONNECT DB
                try {
                    //CREATE QUERY
                    $sqlQueryListings = $db_connection->query('SELECT * FROM items');

                    //FETCH DATA
                    $dataListings = $sqlQueryListings->fetchAll();

                    //TRIGGER VALIDATION ON INFO PAGE
                    $_SESSION["LISINGS"] = "TRUE";
                    $_SESSION["dataListings"] = $dataListings;
                    header("Location: /store.php");

                } catch (PDOException $e) {
                    //DATABSE ERROR
                    echo ($e);
                }
            break;
            default:
                //NO EXECUTION
                $_SESSION["statusQUERY"] = "SOMETHING WENT WRONG!";
                $_SESSION["fail"] = "Credentials are incorrect. Try Again!";
                header("Location: /myaccount.php?updated=false2");
        }
        $db_connection = null;
        
        

    }

?>
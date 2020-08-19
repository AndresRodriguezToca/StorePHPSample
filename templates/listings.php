<?php
    session_start();
    //RETRIEVE DATA
    if($_SESSION["LISINGS"] != "TRUE"){
        $_SESSION["dbQuery"] = "5";
        header("Location: /db.php");
    }
    //RETRIEVE LISTINS
    $arraysListings = $_SESSION["dataListings"];
    $counterListings = 0;
    //COUNT LISTINGS
    foreach($arraysListings as $key => $value){
        $counterListings++;
    }
    //DISPLAY HEADER
    echo "<br><h2 style='color:white'>Available Listings (" . $counterListings . ")</h2>";
    echo "<form action='confirmation.php' method ='POST' enctype='multipart/form-data' style='width: 100%;height: 100%;text-align:center;'>";
    //DISPLAY LISTINGS
    for ($i=0; $i < $counterListings; $i++) {
        echo"
            <div id='column1' class='div-special' style='text-align:center;'>
                <h2>". $arraysListings[$i][1] ."</h2> 
                <img src='" . $arraysListings[$i][4] ."' style='width: 80%%; height: 230px;'><br>
                <h4>SKU: ". $arraysListings[$i][5] ."</h4>
                <h4>List Price per Bundle: $". $arraysListings[$i][3] ."</h4>
                <hr>
                <h4>Quantity Available: ". $arraysListings[$i][2] ."</h4>
                <label for='". $arraysListings[$i][5] ."'>Quantity:</label>
                <select name='". $arraysListings[$i][5] ."' id='". $arraysListings[$i][5] ."'>
                    <option value='0'>0</option>
                    <option value='5'>5</option>
                    <option value='10'>10</option>
                </select>
                <input type='checkbox' id='".$i."' name='".$i."' value='YES'>
                <label for='".$i."'> Add to PO</label><br>
            </div>
            <div id='column2' class='div-special' style='text-align:center;'>
                <h2>". $arraysListings[$i+1][1] ."</h2> 
                <img src='" . $arraysListings[$i+1][4] ."' style='width: 80%%; height: 230px;'><br>
                <h4>SKU: ". $arraysListings[$i+1][5] ."</h4>
                <h4>List Price per Bundle: $". $arraysListings[$i+1][3] ."</h4>
                <hr>
                <h4>Quantity Available: ". $arraysListings[$i+1][2] ."</h4>
                <label for='". $arraysListings[$i+1][5] ."'>Quantity:</label>
                <select name='". $arraysListings[$i+1][5] ."' id='". $arraysListings[$i+1][5] ."'>
                    <option value='0'>0</option>
                    <option value='5'>5</option>
                    <option value='10'>10</option>
                </select>
                <input type='checkbox' id='".($i + 1)."' name='".($i + 1)."' value='YES'>
                <label for='".($i + 1)."'> Add to PO</label><br>
            </div>
            <div id='column3' class='div-special' style='text-align:center;'>
                <h2>". $arraysListings[$i+2][1] ."</h2> 
                <img src='" . $arraysListings[$i+2][4] ."' style='width: 80%%; height: 230px;'><br>
                <h4>SKU: ". $arraysListings[$i+2][5] ."</h4>
                <h4>List Price per Bundle: $". $arraysListings[$i+2][3] ."</h4>
                <hr>
                <h4>Quantity Available: ". $arraysListings[$i+2][2] ."</h4>
                <label for='". $arraysListings[$i+2][5] ."'>Quantity:</label>
                <select name='". $arraysListings[$i+2][5] ."' id='". $arraysListings[$i+2][5] ."'>
                    <option value='0'>0</option>
                    <option value='5'>5</option>
                    <option value='10'>10</option>
                </select>
                <input type='checkbox' id='".($i + 2)."' name='".($i + 2)."' value='YES'>
                <label for='".($i + 2)."'> Add to PO</label><br>
            </div>
        ";
        $i = $i+2;
    }
    echo "</main>";
    echo "<button type='submit' class='registerbtn'>Place Purchase Order</button>";
    echo "</form>";
    //SEND NUMBER OF LISTINGS
    $_SESSION["numberOrders"] =  $counterListings;
?>
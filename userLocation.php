<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="locations.css">
    <title>FlashTask | Change Location</title>
</head>

<?php
    session_start();
    if(!isset($_SESSION['email'])){
        header("LOCATION: ./chores-type.php");
    }
    if(isset($_SESSION['choreID'])){
        //sleep(5);
        header("LOCATION: ./chore-progress.php");
    }
?>

<body>

    <header>
        <img onClick="window.location.href='chores-type.php'" src="svgs/Back.svg" class="sidebar-button2" width="25px" height="25px">
        <a>My Locations</a>
    </header>

    <form method="post" action="server-scripts/change_loc.php">
        <div style="border-bottom: 2px solid gray; width:80%; margin: auto;">
            <?php

                require("server-scripts/connect_db.php");

                $query = "SELECT * FROM `location_user` WHERE `email`='". $_SESSION['email'] ."'";
                if($res = mysqli_query($conn, $query)){
                    while($locs = mysqli_fetch_array($res))
                    {
                        $fullLoc = $locs["country"] . ", " . $locs["county"] . ", " . $locs["city"] . ", " . $locs["street"] . ", " . $locs["postal_code"];
                        echo "            
                        <div class='location_row'>
                            <div class='location_data'>
                                <a>". $fullLoc ."</a>
                            </div>
        
                            <label>
                                <input type='radio' name='location' value='".$locs["id"]."'>
                                <span class='checkmark'></span>
                            </label>
                        </div>";
                    }
                }
            ?>
        </div>

        <div style="width:80%; margin: auto;" onclick="sendLocDisp()">
            <div class="location_row">
                <div class="location_add">
                    <a>Add Location</a>
                </div>

                <img src="svgs\Plus.svg" width="30px" height="30px"></img>
            </div>
        </div>

        <div style="position: fixed; width:100%; bottom: 20px; text-align:center;">
            <button type="submit">Change Location</button>
        </div>
    </form>

    <div id="addloc">
        <div id="cover-side"></div>
        <div id = "location">
            <form method="post" action="server-scripts/add_loc.php">
                <a>Add Location</a>
                <img id="closeAdd" src="svgs/closeLoc.svg" width="40px" height="40px" onclick="closeLocDisp()"></img>
                <input type="text" name="country" id="country" placeholder="Country" style="grid-area: a1" required> 
                <input type="text" name="county" id="county" placeholder="County/State" style="grid-area: a2" required> 
                <input type="text" name="city" id="city" placeholder="City" style="grid-area: a3"  required> 
                <input type="text" name="street" id="street" placeholder="Street Name" style="grid-area: a4" required> 
                <div id="pcode-target">
                    <input type="text" name="pcode" id="pcode" placeholder="Postal Code" style="grid-area: a5" required> 
                    <button type="button" onclick="insertLocation()">
                        <img src="svgs/target.svg" id="target-location">
                    </button>
                </div>
                <input id="submitus" type="submit" value="Submit"></input>
            </form>
        </div>
    </div>

    <script src="scripts\userLocation.js"></script>
</body>
</html>
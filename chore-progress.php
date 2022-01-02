<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles-cp.css">
    <link rel="stylesheet" href="header.css">
    <script src="jquery-3.6.0.min.js"></script>
    <script src="scripts/loadMap.js" ></script>
    <script src="scripts/getProgressData.js" defer></script>
    <script src="https://js.stripe.com/v3/"></script>
    <script src="scripts/chargeUser.js" defer></script>
    <title>FlashTask | Chore Progress</title>
</head>

<?php
        if(isset($_POST["cancelChore"]))
        {
            session_start();
            require_once("server-scripts/connect_db.php");
            $query = "DELETE FROM `chores` WHERE `chores`.`id` = ". $_SESSION['choreID'];
            $exec_query = mysqli_query($conn, $query);
    
            $query = "DELETE FROM `chores_open` WHERE `chores_open`.`chore_id` = " . $_SESSION['choreID'];
            $exec_query = mysqli_query($conn, $query);
    
            unset($_SESSION['choreID']);
    
            $query = "UPDATE `users` SET `ChoreID` = '0' WHERE `users`.`email` = '". $_SESSION['email']."'";
            $res_query= mysqli_query($conn, $query);
            
            header("location: chores-type.php");
        }
?>

<body>
    <?php
        session_start();
        if(!isset($_SESSION['username'])){
            header("LOCATION: ./index.php");
        }

        if(!isset($_SESSION['choreID'])){
            //sleep(5);
            header("LOCATION: ./chores-type.php");
        }

        if(isset($_POST['LogOut'])){
            if(isset($_COOKIE['loginCookie'])){
                //echo("gay");
                setcookie('loginCookie', null, 1); 
                unset($_COOKIE['loginCookie']); 
            }
            session_destroy();
            header("LOCATION: ./index.php");
        }

        require_once("server-scripts/connect_db.php");

        $query = "SELECT * FROM `chores` where id = '".$_SESSION['choreID']."'";
        if($res_query= mysqli_query($conn, $query))
        {
            $choreinfo = mysqli_fetch_assoc($res_query);
        }    

        if(isset($_POST['subFinish']) && $choreinfo['chorePaymentCash']==1){
            $query_update = "UPDATE `chores` SET `choreStatus` = '3' WHERE `chores`.`id` = ". $_SESSION['choreID'];
            $query_update_ok = mysqli_query($conn, $query_update);
            $query_update = "DELETE FROM `chores_open` WHERE `chores_open`.`chore_id` =". $_SESSION['choreID'];
            $query_update_ok = mysqli_query($conn, $query_update);
            $query = "UPDATE `users` SET `ChoreID` = '0' WHERE `users`.`email` = '". $_SESSION['email']."'";
            $res_query= mysqli_query($conn, $query);
            unset($_SESSION['choreID']);
            header("LOCATION: ./chores-type.php");
        }
    ?>
    <div class="cover-side">
    </div>
    <header id="headboy2">
            <a class="location">Chore in Progress</a>
            <form method="POST" style="display:contents">
                <button id="cancelBttn" name="cancelChore">Cancel</button>
            </form>
    </header>

    <div id="sidebar" class="sidebar">
        <div class="sidebar-head">
        
        <svg onclick="CloseSidebar()" id="closeSidebar" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 500">
	        <defs>
		        <style>
			        #cls-1{fill:#fff;}
		        </style>
	        </defs>
	        <title>closeSidebar</title>
	        <path id="cls-1" d="M473.2,473.2L473.2,473.2c-18,18-47.1,18-65.1,0L26.7,91.7c-18-18-18-47.1,0-65.1l0,0c18-18,47.1-18,65.1,0
	                            l381.5,381.5C491.2,426.1,491.2,455.3,473.2,473.2z"/>
            <path id="cls-1" d="M26.6,473.3L26.6,473.3c18,18,47.1,18,65.1,0L473.2,91.8c18-18,18-47.1,0-65.1l0,0c-18-18-47.1-18-65.1,0
	                            L26.6,408.2C8.6,426.2,8.6,455.3,26.6,473.3z"/>
        </svg>

            <?php
                echo("<a id='uname'>".$_SESSION['username']."</a>");
                echo("<a id='address'>".$_SESSION['short-address']."</a>");
            ?>
            <img src="svgs/wave index mobile.svg" id="wave"/> 
        </div>

        <ul>
            <li>
                <img src="svgs/chores_list.svg" width=40px height=40px/>
                <a>My Chores</a>
            </li>

            <li onClick="window.location.href='userLocation.php'">
                <img src="svgs/MyLocations.svg" width=40px height=40px/>
                <a>My Locations</a>
            </li>
        </ul>

        <div class="foot">
            <a>Settings</a>
            <a>Terms and Conditions</a>
            <form method="post">
                <button style="display:contents; text-align:left"><a class="log-out">Log Out</a></button>
                <input type="hidden" name="LogOut">
            </form>
        </div>
    </div>

    <div id="icons">
 
    </div>

    <div id="progress-bar">
        <div class="finished">
        </div>
        <div class="finished">
        </div>
        <div class="in-progress">
            <div class="percent"></div>
        </div>
    </div>

    <div id="status">
        <a>Status</a>
    </div>

    <div><div id="map"></div></div>

    
    <div id="worker_data" style='width:80%; text-align:center; margin:auto; margin-bottom:20px;'>
    </div>

    <script src="https://maps.googleapis.com/maps/api/js?key=ApiKey&callback=initMap"></script>
    <script src="scripts/sidebar.js"></script>

    <!--div id="pay">
        <form id="payment-form" method="post"> 
            <div id="card-element"></div> 
            <button id="submit"> 
                <div class="spinner hidden" id="spinner"></div>
                <span id="button-text">Pay now</span>
            </button>
            <p id="card-error"></p>
            <p class="result-message hidden">Payment Succeed</p>
        </form>
    </div-->
    <div id="fdiv">
        <form id="payment-form" method="post">
            <div id="card-element"></div> 
            <input id="submit" type="submit" value="Submit"></submit>
            <p id="card-error"></p>
            <p class="result-message hidden">Payment Succeed</p>
            <input name="subFinish" type="hidden"/>
        </form>
    </div>
    <div id="fdiv2">
        <form method="post">
            <input type="submit" value="Submit"></submit>
            <input name="subFinish" type="hidden"/>
        </form>
    </div>
</body>
</html>
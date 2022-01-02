<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles_ct.css">
    <title>FlashTask | Choose your chore</title>
</head>
<body>
    <?php
        session_start();
        if(!isset($_SESSION['username'])){
            header("LOCATION: ./index.php");
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

        if(isset($_SESSION['choreID'])){
            header("LOCATION: ./chore-progress.php");
        }
    ?>
    <header>
        <img onClick="OpenSidebar()" src="svgs/sidebar_button.svg" class="sidebar-button" width="25px" height="25px">
        <a class="location">Home</a>
        <img src="svgs/chores_list.svg" class="chores-list" width="40px" height="40px" onClick="window.location.href='chores_history.php'">
    </header>

    <div class="title-chores">
        <a>What is your chore?</a>
    </div>

    <div class="grid-list">
        <div class="linkbutton l1" onclick="window.location.href='chore-form.php?chore_type=lawn_trim'">
            <a>Trim the lawn</a>
            <img src="logoForChores/lawn_mower.svg" alt="lawn" width=150px height=150px class="normalsvg"/>
            <img src="logoForChores/lawn_mower_m.svg" alt="lawn" width=100px height=100px class="mobilesvg"/>
        </div>

        <div class="linkbutton l2" onclick="window.location.href='chore-form.php?chore_type=carry_stuff'">
            <a>Carry my stuff</a>
            <img src="logoForChores/carry_stuff.svg" alt="lawn" width=150px height=150px class="normalsvg"/>
            <img src="logoForChores/carry_stuff_m.svg" alt="lawn" width=100px height=100px class="mobilesvg"/>
        </div>

        <div class="linkbutton l3" onclick="window.location.href='chore-form.php?chore_type=wash_car'">
            <a>Wash my Car</a>
            <img src="logoForChores/car_wash.svg" alt="lawn" width=150px height=150px class="normalsvg"/>
            <img src="logoForChores/car_wash_m.svg" alt="lawn" width=100px height=100px class="mobilesvg"/>
        </div>

        <div class="linkbutton l4" onclick="window.location.href='chore-form.php?chore_type=fix_stuff'">
            <a>Walk my Dog</a>
            <img src="logoForChores/fix_my_stuff.svg" alt="lawn" width=150px height=150px class="normalsvg"/>
            <img src="logoForChores/fix_my_stuff_m.svg" alt="lawn" width=100px height=100px class="mobilesvg"/>
        </div>

        <div class="others" onclick="window.location.href='chore-form.php?chore_type=others'">
            <a>Others</a>
        </div>
    </div>

    <div class="cover-side">
    </div>

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
            <!--<a id="uname">Username/Login</a>-->
            <?php
                echo("<a id='uname'>".$_SESSION['username']."</a>");
                echo("<a id='address'>".$_SESSION['short-address']."</a>");
            ?>
            <!--<a id="address">Address / Location</a>-->
            <img src="svgs/wave index mobile.svg" id="wave"/> 
        </div>

        <ul>
            <li onClick="window.location.href='chores_history.php'">
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
    <script src="scripts/sidebar.js"></script>
</body>
</html>
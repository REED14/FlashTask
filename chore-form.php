<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FlashTask | Submit Your Chore</title>
    <link rel="stylesheet" href="styles_cf.css">
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
            //sleep(5);
            header("LOCATION: ./chore-progress.php");
        }
    ?>

    <div class="cover-side">
    </div>
    <header id="headboy">
        <img onClick="OpenSidebar()" src="svgs/sidebar_button_w.svg" class="sidebar-button" width="25px" height="25px">
        <img onClick="OpenSidebar()" src="svgs/sidebar_button.svg" class="sidebar-button scrl" width="25px" height="25px">
        <a class="location">My Chore</a>
        <img src="svgs/chores_list_w.svg" class="chores-list" width="40px" height="40px"  onClick="window.location.href='chores_history.php'">
        <img src="svgs/chores_list.svg" class="chores-list scrl" width="40px" height="40px"  onClick="window.location.href='chores_history.php'">
    </header>

    <form action="server-scripts/submit-form.php" method="POST">
        <div id="chore-head">
            <img src="svgs/wave index.svg" id="headwave" alt="headwave"/>
            <img src="svgs/wave index mobile.svg" id="hwmobile" alt="headwavem"/>
            <select id="chore-type" name="chore-type" onchange="changeForm()">
                <option value="lawn_trim">Trim my Lawn</option>
                <option value="carry_stuff">Carry my Stuff</option>
                <option value="wash_car">Wash my Car</option>
                <option value="fix_stuff">Walk my Dog</option>
                <option value="others">Others</option>
            </select>
        </div>

        <div class="data-c">
            
            <div id="chore_name_i">
                <label for="chore_name">What is the name of your chore?</label>
                <input type="text" name="chore_name" id="chore_name"></input>
                <br>
            </div>

            <label for="ch-description" style="margin-top: 20px">Chore Description</label>
            <br>
            <textarea rows="5" cols="30" name="ch-description" maxlength="500" placeholder="Describe your chore in 500 characters or less" required></textarea>
            <br>

            <label for="estimated-time">How long will it take to complete the chore?</label>
            <input type="number" name="estimated-time" id="estimated-time" placeholder="minutes" min="0" required/>
            <br>

            <label for="payment">How much will you pay?</label>
            <div id="pcontainer">
                <input type="number" id="payment" name="payment" min="0" required/>
                <label>$</label>
            </div>
            <br>

            <div class="pm-container">
                <label for="payment">Select payment method:</label>
                <select id="payment-method" name="payment-method" style="border: none" required>
                    <option value="cash">Cash</option>
                    <option value="credit-card">Credit-Card</option>
                </select>
            </div>
            <br>
            
            <div id="notifToken"></div>

            <input id="allMightySubmit" type="submit" value="Submit" name="submitChore"/>
        </div>
    </form>

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
            <li onClick="window.location.href='chores-type.php'">
                <img src="svgs/Home.svg" width=40px height=40px/>
                <a>Home</a>
            </li>

            <li  onClick="window.location.href='chores_history.php'">
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
    <script src="scripts/header.js"></script>
    <script src="scripts/submit-chore.js"></script>
</body>

</html>
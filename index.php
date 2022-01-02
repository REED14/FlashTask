<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>FlashTask | The app that solves your chores</title>

</head>

<?php
    $login_zone = 0;
    include("server-scripts/register.php");
    include("server-scripts/login.php");
?>

<body>

    <div class="page-head">

        <div class="inside-head">
            <div class="name_and_logo" id="trgt">
                <img src="svgs\onweb logo white.svg" alt="white_logo" width="150px" height="150px"></img>
                <h1>FlashTask</h1>
            </div>
        </div>

        <div class="app_description">
            <a>FlashTask is an app that solves your chores or your problems around the house. 
            We have workers that will come to your address to do your chore or help you with your chore.
            </a>
        </div>

        <div id="checkAnimation">
            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                    viewBox="0 0 500 500" style="enable-background:new 0 0 500 500;" xml:space="preserve">
                <style type="text/css">
                    .st0{fill:url(#SVGID_1_);}
                    .st1{fill:#FFFFFF;}
                    .st2{fill:#2EB34A;}
                    .st3{opacity:0.53;fill:#2EB34A;enable-background:new    ;}
                </style>
                <g id="Layer_3">
                    <linearGradient id="SVGID_1_" gradientUnits="userSpaceOnUse" x1="252.85" y1="482" x2="252.85" y2="19">
                        <stop  offset="0" style="stop-color:#69cc60"/>
                        <stop  offset="1" style="stop-color:#25b65a"/>
                    </linearGradient>
                    <rect x="100.1" y="19" class="st0" width="305.5" height="463"/>
                </g>
                <g id="Layer_1">
                    <g id="L1">
                        <path class="st1" d="M397.5,0H108.2C94.3,0,83.1,11.2,83.1,25.1v449.8c0,13.9,11.2,25.1,25.1,25.1h289.3
                            c13.9,0,25.1-11.2,25.1-25.1V25.1C422.6,11.2,411.3,0,397.5,0z M405.6,456.9c0,13.9-11.2,25.1-25.1,25.1H125.2
                            c-13.9,0-25.1-11.2-25.1-25.1V44.1c0-13.9,11.2-25.1,25.1-25.1h255.3c13.9,0,25.1,11.2,25.1,25.1V456.9z"/>
                        <path class="st1" d="M366.1,465.2H141.6c-13.7,0-24.7-11.1-24.7-24.7l-1-382.7c0-13.7,12.1-24.7,25.7-24.7h224.5
                            c13.7,0,24.7,11.1,24.7,24.7v382.7C390.8,454.1,379.7,465.2,366.1,465.2z"/>
                    </g>
                    <g id="Lines">
                        <rect id="l11" x="185.7" y="61.1" class="st2" width="138.4" height="5.3"/>
		                <rect id="l12" x="129.8" y="125.1" class="st3" width="149.2" height="5.3"/>
		                <rect id="l13" x="129.8" y="183.9" class="st3" width="149.2" height="5.3"/>
		                <rect id="l14" x="129.8" y="247.9" class="st3" width="149.2" height="5.3"/>
		                <rect id="l15" x="129.8" y="311.9" class="st3" width="149.2" height="5.3"/>
                    </g>
                    <g id="checks">
                        <path id="chk1" class="st2" d="M329.4,143.7c-3.4,3.4-16.6-9.1-29.1-37.1c0,0,23.6,21.5,27.8,18.6c25.2-17.3,43.2-41.8,43.5-41.9
                            C371.6,83.3,347.6,125.6,329.4,143.7z"/>
                        <path id="chk2" class="st2" d="M329.4,213.8c-3.4,3.4-16.6-9.1-29.1-37.1c0,0,23.6,21.5,27.8,18.6c25.2-17.3,43.2-41.8,43.5-41.9
                            C371.6,153.4,347.6,195.6,329.4,213.8z"/>
                        <path id="chk3" class="st2" d="M329.4,277.8c-3.4,3.4-16.6-9.1-29.1-37.1c0,0,23.6,21.5,27.8,18.6c25.2-17.3,43.2-41.8,43.5-41.9
                            C371.6,217.4,347.6,259.6,329.4,277.8z"/>
                        <path id="chk4" class="st2" d="M329.4,341.8c-3.4,3.4-16.6-9.1-29.1-37.1c0,0,23.6,21.5,27.8,18.6c25.2-17.3,43.2-41.8,43.5-41.9
                            C371.6,281.4,347.6,323.6,329.4,341.8z"/>
                    </g>
                </g>
            </svg>
        </div>

    </div>
    
    <!--Delimiter-->

    <img src="svgs/wave index.svg" class="wave"></img>
    <img src="svgs/wave index mobile.svg" class="wave mwave"></img>

    <div id="logsign">
        <button id="signup" onclick="showSignup()">Sign Up</button>
        <button id="login" onclick="showLogin()">Login</button>

        <?php
            $login_zone = 1;
            require("server-scripts/register.php");
            require("server-scripts/login.php");
        ?>
    </div> 

    <!--Forms-->
    <div id="register_form">
        <form method="post">
            <div id="names">
                <input type="text"name="FName" class="inside-names" placeholder="First Name" required>
                <input type="text" name="LName" class="inside-names" placeholder="Last Name" required>
            </div>
            <input type="email" name="email" id="email" placeholder="Email" required>
            <input type="text" name="pnum" id="pnum" placeholder="Phone Number" required>
            <div id="location">
                <input type="text" name="country" id="country" placeholder="Country" style="grid-area: a1" required> 
                <input type="text" name="county" id="county" placeholder="County/State" style="grid-area: a2" required> 
                <input type="text" name="city" id="city" placeholder="City" style="grid-area: a3"  required> 
                <input type="text" name="street" id="street" placeholder="Street Name" style="grid-area: a4" required> 
                <input type="text" name="pcode" id="pcode" placeholder="Postal Code" style="grid-area: a5" required> 
                <button type="button" onclick="insertLocation()">
                    <img src="svgs/target.svg" id="target-location">
                </button>
            </div>
            <div id="password">
                <input type="password" name="password" id="passreg" placeholder="Password" required>
                <input type="password" name="repeat_pass" id="passreg_repeat" placeholder="Repeat Password" required>
            </div>
            <div id="notenough">
                    <a>Password too short! You have less than 8 characters!</a>
            </div>
            <div id="notstrong">
                    <a>Password too weak! Your password should contain small letters, capital letters, numbers and special symbols: !, @, #, $, %, ^, &, *</a>
            </div>
            <div id="notthesame">
                    <a>Passwords are not the same!</a>
            </div>
            <input type="submit" value="Submit" id="submitReg">
            <input type="hidden" name="register">
        </form>
        <!--Information Disclaimer-->
        <div class="info_location">
            <a>Wee need your location to provide you our best services</a>
        </div>

        <button class="backbtn" onclick="showBtnsOnSignup()">Back</button>
    </div>

    <div id="login_form">
        <form method="post">
            <input type="email" name="email" id="email" placeholder="Email" required> 
            <div id="password">
                <input type="password" name="password" class="inside-password" placeholder="Password" required>
            </div>
            <div style="display: flex; justify-content:center; align-items:center;">
                <input type="checkbox" id="rememberme" name="rememberme" style="width: 25px; height: 25px; margin: 10px" value="okbro">
                <label for="rememberme"><a style="font-size: 20px;">Remember me</a></label><br>
            </div>
            <input type="submit" value="Submit">
            <input type="hidden" name="login">
        </form>
        <button class="backbtn" onclick="showBtnsOnLogin()">Back</button>
    </div>

    <div id="somewhere"><div>

    <script src="scripts/getLocation.js"></script>
    <script src="scripts/registerLogin.js"></script>

</html>
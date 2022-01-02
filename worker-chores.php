<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="styles-wchores.css">
    <title>FlashTask | Avalable Chores</title>

    <script src="jquery-3.6.0.min.js"></script>
    <script>

        $(document).ready(
            function(){
                var choreLoad = 20;
                
                setInterval(
                    function(){
                        fetch_chore();
                }, 2000);

                function fetch_chore(){
                    $.ajax({
                        type: "POST",
                        url: "server-scripts/load_wchores.php",
                        data: {chLoad: choreLoad},
                        success: function (data){
                            $('#chores_container').html(data);
                            console.log(data);
                        }
                    });
                }

                $(window).scroll(function() {
                    if($(window).scrollTop() + $(window).height() > $(document).height()-10) {
                        choreLoad += 1;
                    }
                });
            }
        );
    </script>
</head>

<?php
        session_start();
        if(!isset($_SESSION['wusername'])){
            header("LOCATION: ./worker.php");
        }

        if(isset($_POST['LogOut'])){
            if(isset($_COOKIE['loginCookieW'])){
                //echo("gay");
                setcookie('loginCookieW', null, 1); 
                unset($_COOKIE['loginCookieW']); 
            }
            session_destroy();
            header("LOCATION: ./worker.php");
        }

        if(isset($_SESSION['choreIDW']))
        {
            header("location: worker-chore-progress.php");
        }

        require_once("server-scripts/connect_db.php");

        $query = "SELECT * FROM `workers` where `email` = '".$_SESSION['wemail']."'";
        if($res_query= mysqli_query($conn, $query))
        {
            $wdata = mysqli_fetch_assoc($res_query);
            $accID = $wdata['stripe_id'];
            $accOB = $wdata['has_onboard'];
        }
    
        if(!$accOB){
            header("location: worker_plsonboard.php");
        }
?>

<body>

    <!-- sidebar and header -->
    <div class="cover-side">
    </div>

    <header>
        <img onClick="window.location.href='worker-chores-type.php'" src="svgs/Back.svg" class="sidebar-button2" width="25px" height="25px">
        <?php
            switch($_GET["chore_type"]){
                case "lawn_trim":
                    echo "<a class='location' style='text-align: center;'>Trim the Lawn</a>";
                    $_SESSION['choreType']=0;
                    break;
                case "carry_stuff":
                    echo "<a class='location' style='text-align: center;'>Carry my Stuff</a>";
                    $_SESSION['choreType']=1;
                    break;
                case "wash_car":
                    echo "<a class='location' style='text-align: center;'>Wash my Car</a>";
                    $_SESSION['choreType']=2;
                    break;
                case "fix_stuff":
                    echo "<a class='location' style='text-align: center;'>Walk my Dog</a>";
                    $_SESSION['choreType']=3;
                    break;
                default:
                    echo "<a class='location' style='text-align: center;'>Others</a>";
                    $_SESSION['choreType']=4;
                    break;
            }
        ?>
        <img src="svgs/withdrawal.svg" class="chores-list" width="40px" height="40px" onClick="window.location.href='worker_stripe.php'">
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
                echo("<a id='uname'>".$_SESSION['wusername']."</a>");
                echo("<a id='address'>".$_SESSION['wshort-address']."</a>");
            ?>
            <img src="svgs/wave index mobile.svg" id="wave"/> 
        </div>

        <ul>
            <li onClick="window.location.href='chores-type.php'">
                <img src="svgs/Home.svg" width=40px height=40px/>
                <a>Home</a>
            </li>

            <li>
                <img src="svgs/MyLocations.svg" width=40px height=40px/>
                <a>My Locations</a>
            </li>

            <li>
                <img src="svgs/Payments.svg" width=30px height=30px/>
                <a href="payment-and-commission.php" style="text-decoration:none">Payment and Commissions</a>
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

    <!-- getting data -->

    <form method="post" action="server-scripts/startchore.php">
            <!--
            <button type="submit" name="choreID" value="128"> <div class="chore"> <div class="chore_address"><a>Address</a></div> <div class="chore_time"><a>Time: 20m</a></div><div class="chore_payment"><a>20$</a></div> </button>
            </div>-->
        <div id="chores_container">
            <?php
                require_once("server-scripts/connect_db.php");

                $query = "SELECT * FROM `chores` WHERE `choreStatus` = 0 AND `choreLocationShort` LIKE '".$_SESSION['wshort-address']."' AND `choreType` = ".$_SESSION['choreType']."  ORDER BY `chores`.`chorePayment` DESC LIMIT 5";
                if($query_load=mysqli_query($conn, $query)){
                    while($row = mysqli_fetch_array($query_load))
                    {
                        echo '<button type="submit" name="choreID" value="'.$row["id"].'"> <div class="chore"> <div class="chore_address"><a>'.$row["choreLocation"].'</a></div> <div class="chore_time"><a>Time: '.$row["choreDuration"].' minutes</a></div><div class="chore_payment"><a>'.$row["chorePayment"].'$</a></div> </button>';
                        $_SESSION["chLoc"] = $row["choreLocation"];
                    }
                }
            ?>
        </div>
    </form>
    
    <script src="scripts/sidebar.js"></script>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="wstripe.css">
</head>
<body>
    <header>
        <img onClick="window.location.href='worker-chores-type.php'" src="svgs/Back.svg" class="sidebar-button2" width="25px" height="25px">
        <a>Withdrawal</a>
    </header>

    <?php
        session_start();
        require_once('server-scripts/stripe/init.php');
        require_once("server-scripts/connect_db.php");

        $query = "SELECT * FROM `workers` where `email` = '".$_SESSION['wemail']."'";
        if($res_query= mysqli_query($conn, $query))
        {
            $wdata = mysqli_fetch_assoc($res_query);
            $accID = $wdata['stripe_id'];
            $accOB = $wdata['has_onboard'];

            $wphone = $wdata['phone'];
        }
    
        echo "<div id='contentblock'>";
        echo "<div id='uname'><a style='color: #5BC236;'>".$_SESSION['wusername']."</a></div>
              <div id='sumcontent'>
                <div class='usrdata'><a>Email</a><a> ".$_SESSION['wemail']."</a></div>
                <div class='usrdata'><a>Phone</a><a> ".$wdata['phone']."</a></div>";
        if($accOB)
            echo "<div class='usrdata'><a>Status</a><div id='hasob'><a>Successful Onboard</a></div></div></div>";
        else
            echo "<div class='usrdata'><a>Status</a><div id='hasobno'><a>Account not Onboarded</a></div></div></div>";
        echo "</div>";

        if(!$accOB){
            Stripe\Stripe::setApiKey('sk_test_51JcEGHFMxtKFBF8Cfv2e0T0LpZcldleZP4WSea0ptTp0hcrk48QP2p7lD54TASMbxW2dLSjsNDid1FAvnnwrOfyB00fwjLKF4m');

            $acclink = stripe\AccountLink::create([
                'account' => $accID,
                'refresh_url' => 'https://d739-89-137-129-142.ngrok.io/domychores/worker-chores-type.php',
                'return_url' => 'https://d739-89-137-129-142.ngrok.io/domychores/finish_onboard.php',
                'type' => 'account_onboarding'
            ]);

            echo "<div class='btnzone'><button id='oba' onClick='document.location.href = \"".$acclink->url."\";'>Onboard <span style='font-weight: bold'>Stripe</span> Account</button></div>";
        }

        else 
        {
            $stripe = new \Stripe\StripeClient(
                'sk_test_51JcEGHFMxtKFBF8Cfv2e0T0LpZcldleZP4WSea0ptTp0hcrk48QP2p7lD54TASMbxW2dLSjsNDid1FAvnnwrOfyB00fwjLKF4m'
            );
            
            $connStripe = $stripe->accounts->createLoginLink(
                $accID,
                [
                    "redirect_url" => "https://d739-89-137-129-142.ngrok.io/domychores/worker-chores-type.php"
                ]
            );

            echo "<div class='btnzone'><button id='lsa' onClick='document.location.href = \"".$connStripe->url."\";'>Login <span style='font-weight: bold'>Stripe</span> Account</button></div>";
        }
    ?>
</body>
</html>
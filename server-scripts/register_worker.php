<?php

require_once('stripe/init.php');

if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST['workReg'])){
        require_once("connect_db.php");
            /*
        echo($_POST['LName']);
        echo($_POST['email']);
        echo($_POST['pnum']);
        echo($_POST['country']);
        echo($_POST['county']);
        echo($_POST['city']);
        echo($_POST['street']);
        echo($_POST['pcode'] . "<br><br>");*/

        $userdata = array("FName"=>"", "LName"=>"","email"=>"", "pnum"=>"", "country"=>"", "county"=>"", "city"=>"", "street"=>"", "pcode"=>"", "password"=>"");

        if($login_zone==0)
            $_POST['password'] = md5($_POST['password']);
        foreach($_POST as $key => $value){
            $userdata[$key]=$value;
            $userdata[$key]=str_replace('"', '\"', $userdata[$key]);
            $userdata[$key]=htmlspecialchars($userdata[$key], ENT_QUOTES, 'UTF-8', true);
            if($key=="password") break;
        }

        $language = "EN";
        
        if($userdata["country"]=="Romania"){
            $language="RO";
        }

        $hashval = $userdata['email'].$userdata['password'].strval(rand(0, 10000000));
        $hashval2 = md5($hashval);

        $iregdata = "INSERT INTO `workers` (`id`, `fname`, `lname`, `email`, `phone`, `country`, `county`, `city`, `street`, `postal_code`, `password`, `Language`, `DarkMode`, `totalSum`, `commission`, `Hash`) 
                    VALUES (NULL, '" . $userdata['FName'] . "', '" . $userdata['LName'] . "', '" . $userdata['email'] . "', '" . $userdata['pnum'] . "', '" . $userdata['country'] . "', '" 
                    . $userdata['county'] . "', '" . $userdata['city'] . "', '" . $userdata['street'] . "', '" . $userdata['pcode'] . "', '" . $userdata['password'] . "', '". $language ."', '0', '0', '0', '".$hashval2."')";
        
        $ireglocation = "INSERT INTO `location_user` (`id`, `country`, `county`, `city`, `street`, `postal_code`, `email`) VALUES (NULL, '" . $userdata['country'] . "', '". $userdata['county'] ."', '" . $userdata['city'] . "', '" . $userdata['street'] . "', '" . $userdata['pcode'] . "', '" . $userdata['email'] . "')";
        if($login_zone==1){
            if($userexist = mysqli_query($conn, "SELECT * FROM `workers` WHERE `email`='".$userdata["email"]."' or `phone`='".$userdata["pnum"]."'")->num_rows)
            {
                $error_construction = "
                <div style='    
                color: darkred;
                background: rgb(255, 179, 179);
                width: 60%;
                margin: auto;
                margin-top: 10px;
                margin-bottom: 10px;
                font-size: 18px;
                padding: 5px;
                border: 1px solid red;
                border-radius: 5px;'>
                    <a>User already exists!</a>
                </div>
                ";
                echo($error_construction);
            }
            else{
                $stripe = new Stripe\StripeClient('sk_test_put whatever you want here');

                $accresponse = $stripe->accounts->create([
                    'type' => 'express',
                    'email' => $_POST['email'],
                    'capabilities' => [
                      'card_payments' => [
                        'requested' => true,
                      ],
                      'transfers' => [
                        'requested' => true,
                      ],
                    ]
                ]);

                $accresponsej = strstr($accresponse, "{", 0);
                $accresponsejson = json_decode($accresponsej);

                $iregdata = "INSERT INTO `workers` (`id`, `fname`, `lname`, `email`, `phone`, `country`, `county`, `city`, `street`, `postal_code`, `password`, `Language`, `DarkMode`, `stripe_id`,`totalSum`, `commission`) 
                VALUES (NULL, '" . $userdata['FName'] . "', '" . $userdata['LName'] . "', '" . $userdata['email'] . "', '" . $userdata['pnum'] . "', '" . $userdata['country'] . "', '" 
                . $userdata['county'] . "', '" . $userdata['city'] . "', '" . $userdata['street'] . "', '" . $userdata['pcode'] . "', '" . $userdata['password'] . "', '". $language ."', '0', '".$accresponsejson->id."', '0', '0')";

                $insertuser = mysqli_query($conn, $iregdata);
                $insertuser = mysqli_query($conn, $ireglocation);

                //echo $userdata['password'] ."<br>".$plm."<br>";

                $login_construction = "
                <div style='    
                color: green;
                background: lightgreen;
                width: 60%;
                margin: auto;
                margin-top: 10px;
                margin-bottom: 10px;
                font-size: 18px;
                padding: 5px;
                border: 1px solid darkgreen;
                border-radius: 5px;'>
                    <a>Press Log In and enter your Email and Password!</a>
                </div>
                ";
                $mess = "
                <html>
                    <head>
                        <title>FlashTask</title>
                    </head>
                    <body>
                        <a style='display:block'>This is your email verification link:</a>
                        <a href="."'http://localhost/domychores/verifyworker.php?email=".$userdata['email']."&hash=".$hashval2."' style='display:block'>Click me to verify your email!</a>
                    </body>
                </html>";
                $headers = "MIME-Version: 1.0" . "\r\n"; 
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n"; 
                mail($userdata['email'], "FlashTask Email Verification", $mess, $headers);
                echo($login_construction);
            }
        }
    }
 ?>
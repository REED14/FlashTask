<?php
    if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST['register'])){
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

        //echo "<br>".$_POST['password']."<br>";
        if($login_zone==0)
            $_POST['password'] = md5($_POST['password']);
        //echo "<br>".$_POST['password']."<br>";
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

        $iregdata = "INSERT INTO `users` (`id`, `fname`, `lname`, `email`, `phone`, `country`, `county`, `city`, `street`, `postal_code`, `password`, `Language`, `DarkMode`, `Hash`) 
                    VALUES (NULL, '" . $userdata['FName'] . "', '" . $userdata['LName'] . "', '" . $userdata['email'] . "', '" . $userdata['pnum'] . "', '" . $userdata['country'] . "', '" 
                    . $userdata['county'] . "', '" . $userdata['city'] . "', '" . $userdata['street'] . "', '" . $userdata['pcode'] . "', '" . $userdata['password'] . "', '". $language ."', '0', '".$hashval2."')";
        
        if($userexist = mysqli_query($conn, "SELECT * FROM `users` WHERE `email`='".$userdata["email"]."' or `phone`='".$userdata["pnum"]."'")->num_rows)
        {
            if(isset($login_zone)){
                if($login_zone){
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
            }
        }
        else{
            if(isset($login_zone)){
                if($login_zone){
                    $insertuser = mysqli_query($conn, $iregdata);
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
                        <a>Check your email inbox and verify your account!</a>
                    </div>
                    ";
                    $mess = "
                    <html>
                        <head>
                            <title>FlashTask</title>
                        </head>
                        <body>
                            <a style='display:block'>This is your email verification link:</a>
                            <a href="."'http://localhost/domychores/verifyuser.php?email=".$userdata['email']."&hash=".$hashval2."' style='display:block'>Click me to verify your email!</a>
                        </body>
                    </html>";
                    $headers = "MIME-Version: 1.0" . "\r\n"; 
                    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n"; 
                    mail($userdata['email'], "FlashTask Email Verification", $mess, $headers);
                    echo($login_construction);
                }
            }
        }
    }
 ?>
<?php
if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST['wrkLogin'])){
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

        if($login_zone==0){
            $_POST['password'] = md5($_POST['password']);
        }
        //echo($_POST['password']);
        $userdata = array("email"=>"", "password"=>"");
        foreach($_POST as $key => $value){
            $userdata[$key]=$value;
            $userdata[$key]=str_replace('"', '\"', $userdata[$key]);
            $userdata[$key]=htmlspecialchars($userdata[$key], ENT_QUOTES, 'UTF-8', true);
            if($key=="password") break;
        }

        //echo($_POST['password']."<br><br>".$userdata['password']."<br><br>");

        if($userexist = mysqli_query($conn, "SELECT * FROM `workers` WHERE `email`='".$userdata["email"]."' and `password`='".$userdata["password"]."'")->num_rows)
        {
            
            //echo($_POST['password']);
            //echo($userexist);
            
            //echo("Esti un idiot pentru ca ai suferit dupa Raluca");
            $get_user_data = mysqli_query($conn, "SELECT * FROM `workers` WHERE `email`='".$userdata["email"]."'");
            $user_db_data = mysqli_fetch_assoc($get_user_data);
            //echo("<br>".$userexist);
            if($user_db_data["Verified"]==1){
                //echo("<br>".$userexist);
                session_start();
                $_SESSION['wusername'] = $user_db_data["fname"]. " " .$user_db_data["lname"];
                $_SESSION['wemail'] = $user_db_data['email'];
                $_SESSION['waddress'] = $user_db_data["country"]. ", " .$user_db_data["county"]. ", " .$user_db_data["city"]. ", " .$user_db_data["street"]. ", " .$user_db_data["postal_code"];
                $_SESSION['wshort-address'] = $user_db_data["country"]. ", " .$user_db_data["city"];
                //echo($_SESSION['wusername']."<br>");
                //echo($_SESSION['waddress']."<br>");
                if(!empty($_POST['rememberme']) && $login_zone==0)
                {
                    $cookieval = $_POST['password'] . $_POST['email'] . date("YmdHis");
                    $cookieval = md5($cookieval);
                    $work = mysqli_query($conn, "UPDATE `workers` SET `TokenCookieW` = '".$cookieval."' WHERE `workers`.`email` = '".$userdata["email"]."'");
                    setcookie("loginCookieW", $cookieval, time()+31556926);
                    echo($_COOKIE['loginCookieW']);
                }

                if($user_db_data['choreID']!=0)
                {
                    session_start();
                    $_SESSION["choreIDW"] = $user_db_data['choreID'];
                    require_once("server-scripts/loadchores_login.php");
                }
                header("LOCATION: ./worker-chores-type.php");
            }
            else {
                if(isset($login_zone)){
                    if($login_zone){
                        //echo("<br>".$userexist);
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
                            <a>Check your email inbox and Verify your Account!</a>
                        </div>
                        ";
                        //echo("plm");
                        echo($error_construction);
                    }
                    
                }
            }
        }
        else{
            if(isset($login_zone)){
                if($login_zone){
                    //echo($_POST['password']);
                    
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
                        <a>Invalid Email and Password</a>
                    </div>
                    ";
                    echo($error_construction);
                }
            }
        }
}

//echo($login_zone);
if(isset($_COOKIE['loginCookieW']))
{
        //echo($login_zone);
        require_once("connect_db.php");
        if($userexist = mysqli_query($conn, "SELECT * FROM `workers` WHERE `TokenCookieW`='".$_COOKIE['loginCookieW']."'")->num_rows)
        {
            //echo("hello")
            $get_user_data = mysqli_query($conn, "SELECT * FROM `workers` WHERE `TokenCookieW`='".$_COOKIE['loginCookieW']."'");
            $user_db_data = mysqli_fetch_assoc($get_user_data);
            if($user_db_data["Verified"]==1){
                session_start();
                $_SESSION['wusername'] = $user_db_data["fname"]. " " .$user_db_data["lname"];
                $_SESSION['wemail'] = $user_db_data['email'];
                $_SESSION['waddress'] = $user_db_data["country"]. ", " .$user_db_data["county"]. ", " .$user_db_data["city"]. ", " .$user_db_data["street"]. ", " .$user_db_data["postal_code"];
                $_SESSION['wshort-address'] = $user_db_data["country"]. ", " .$user_db_data["city"];
                echo($_SESSION['wusername']."<br>");
                echo($_SESSION['waddress']."<br>");
                if(!empty($_POST['rememberme']) && $login_zone==0)
                {
                    $cookieval = $_POST['password'] . $_POST['email'] . date("YmdHis");
                    $cookieval = md5($cookieval);
                    mysqli_query($conn, "UPDATE `workers` SET `TokenCookieW` = '".$cookieval."' WHERE `workers`.`email` = ".$userdata["email"]."'");
                    setcookie("loginCookieW", $cookieval, time()+31556926);
                }
                if($user_db_data['choreID']!=0)
                {
                    session_start();
                    $_SESSION["choreIDW"] = $user_db_data['choreID'];
                    require_once("server-scripts/loadchores_login.php");
                }
                header("LOCATION: ./worker-chores-type.php");
            }
        }
}
?>
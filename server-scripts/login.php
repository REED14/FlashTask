<?php
if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST['login'])){
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

        if($login_zone==0)
            $_POST['password'] = md5($_POST['password']);
        $userdata = array("email"=>"", "password"=>"");
        foreach($_POST as $key => $value){
            $userdata[$key]=$value;
            $userdata[$key]=str_replace('"', '\"', $userdata[$key]);
            $userdata[$key]=htmlspecialchars($userdata[$key], ENT_QUOTES, 'UTF-8', true);
            if($key=="password") break;
        }


        if($userexist = mysqli_query($conn, "SELECT * FROM `users` WHERE `email`='".$userdata["email"]."' and `password`='".$userdata["password"]."'")->num_rows)
        {
            //echo("Esti un idiot pentru ca ai suferit dupa Raluca");
            //mail("horimara@gmail.com","Success","Send mail from localhost using PHP");
            $get_user_data = mysqli_query($conn, "SELECT * FROM `users` WHERE `email`='".$userdata["email"]."'");
            $user_db_data = mysqli_fetch_assoc($get_user_data);
            if($user_db_data["Verified"]==1){
                session_start();
                $_SESSION['username'] = $user_db_data["fname"]. " " .$user_db_data["lname"];
                $_SESSION['email'] = $user_db_data['email'];
                $_SESSION['address'] = $user_db_data["country"]. ", " .$user_db_data["county"]. ", " .$user_db_data["city"]. ", " .$user_db_data["street"]. ", " .$user_db_data["postal_code"];
                $_SESSION['short-address'] = $user_db_data["country"]. ", " .$user_db_data["city"];
                echo($_SESSION['username']."<br>");
                echo($_SESSION['address']."<br>");
                if(!empty($_POST['rememberme']) && $login_zone==0)
                {
                    $cookieval = $_POST['password'] . $_POST['email'] . date("YmdHis");
                    $cookieval = md5($cookieval);
                    $work = mysqli_query($conn, "UPDATE `users` SET `TokenCookie` = '".$cookieval."' WHERE `users`.`email` = '".$userdata["email"]."'");
                    setcookie("loginCookie", $cookieval, time()+31556926);
                    echo($_COOKIE['loginCookie']);
                }
                
                if($user_db_data['ChoreID'] != 0)
                {
                    $_SESSION['choreID'] = $user_db_data['ChoreID'];
                    header("LOCATION: ./chore-progress.php");
                }
                else{
                    header("LOCATION: ./chores-type.php");
                }
            }
            else {
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
                            <a>Check your email inbox and Verify your Account!</a>
                        </div>
                        ";
                        echo($error_construction);
                    }
                    
                }
            }
        }

        else{
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
                        <a>Invalid Email and Password</a>
                    </div>
                    ";
                    echo($error_construction);
                }
            }
        }
    }

if(isset($_COOKIE['loginCookie']))
{
    require_once("connect_db.php");
    if($userexist = mysqli_query($conn, "SELECT * FROM `users` WHERE `TokenCookie`='".$_COOKIE['loginCookie']."'")->num_rows)
    {
        $get_user_data = mysqli_query($conn, "SELECT * FROM `users` WHERE `TokenCookie`='".$_COOKIE['loginCookie']."'");
        $user_db_data = mysqli_fetch_assoc($get_user_data);
        if($user_db_data["Verified"]==1){
            session_start();
            $_SESSION['username'] = $user_db_data["fname"]. " " .$user_db_data["lname"];
            $_SESSION['email'] = $user_db_data['email'];
            $_SESSION['address'] = $user_db_data["country"]. ", " .$user_db_data["county"]. ", " .$user_db_data["city"]. ", " .$user_db_data["street"]. ", " .$user_db_data["postal_code"];
            $_SESSION['short-address'] = $user_db_data["country"]. ", " .$user_db_data["city"];
            echo($_SESSION['username']."<br>");
            echo($_SESSION['address']."<br>");
            if(!empty($_POST['rememberme']) && $login_zone==0)
            {
                $cookieval = $_POST['password'] . $_POST['email'] . date("YmdHis");
                $cookieval = md5($cookieval);
                mysqli_query($conn, "UPDATE `users` SET `TokenCookie` = '".$cookieval."' WHERE `users`.`email` = ".$userdata["email"]."'");
                setcookie("loginCookie", $cookieval, time()+31556926);
            }
            if($user_db_data['ChoreID'] != 0)
            {
                $_SESSION['choreID'] = $user_db_data['ChoreID'];
                header("LOCATION: ./chore-progress.php");
            }
            else{
                header("LOCATION: ./chores-type.php");
            }
        }
    }
}
    
?>
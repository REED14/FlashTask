<?php
require_once("connect_db.php");
session_start();
if($_SERVER['REQUEST_METHOD']=="POST"){
    $_SESSION["choreIDW"] = $_POST["choreID"];
}
$query = "SELECT * FROM `chores` WHERE `id` = '".$_SESSION["choreIDW"]."'";

if($res = mysqli_query($conn, $query)){
    $x = mysqli_fetch_array($res);

    if($x['choreStatus']==0)
    {
        echo($_SESSION['chLoc']." ".$x['choreLocation']." ".$_SESSION["choreIDW"]);
        $_SESSION['chName'] = $x['choreName'];
        //$_SESSION['chPhone']
        $phquery = "SELECT * FROM `users` WHERE `email` = '".$x["choreRequester"]."'";
        if($phreq = mysqli_query($conn, $phquery))
        {
            $reqester = mysqli_fetch_array($phreq);
            $_SESSION['chPhone'] = $reqester['phone'];
            //echo $_SESSION['chPhone'];
        }
        $_SESSION['chPay'] = $x['chorePayment'];
        $_SESSION['chDesc'] = $x['choreDescription'];
        $_SESSION['choreStatus']=$x['choreStatus'];
        if($x['NotificationToken']!=NULL)
        {
            $_SESSION['userToken']=$x['NotificationToken'];
        }
        if($x['chorePaymentCash'])
            $_SESSION['chPmnt']="Cash";
        else
            $_SESSION['chPmnt']="Card";
        //echo 
        header("location: ../worker-chore-progress.php");
    }
    else{
        echo("stop playing with HTML!<br><br>");
    }
}
else echo("ok");

?>
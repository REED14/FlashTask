<?php
require_once("connect_db.php");
session_start();
$query = "SELECT * FROM `chores` WHERE `id` = '".$_SESSION["choreIDW"]."'";

if($res = mysqli_query($conn, $query)){
    $x = mysqli_fetch_array($res);

    $_SESSION['chLoc'] = $x['choreLocation'];
    $_SESSION['chName'] = $x['choreName'];

    $phquery = "SELECT * FROM `users` WHERE `email` = '".$x["choreRequester"]."'";
    if($phreq = mysqli_query($conn, $phquery))
    {
        $reqester = mysqli_fetch_array($phreq);
        $_SESSION['chPhone'] = $reqester['phone'];
        $_SESSION['choreType'] = $x['choreType'];
    }

    $_SESSION['chDur'] = $x['choreDuration'];
    $_SESSION['chPay'] = $x['chorePayment'];
    $_SESSION['chDesc'] = $x['choreDescription'];
    $_SESSION['choreStatus']=$x['choreStatus'];

    header("location: ../worker-chore-progress.php");
}
else echo("gayyy");

?>
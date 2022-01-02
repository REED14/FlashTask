<?php
    require_once("connect_db.php");
    session_start();

    $chLim = $_POST["chLoad"];

    $query = "SELECT * FROM `chores` WHERE `choreStatus` = '0' AND `choreLocationShort` LIKE '".$_SESSION['wshort-address']."' AND `choreType` = ".$_SESSION['choreType']."  ORDER BY `chores`.`chorePayment` DESC LIMIT " . $chLim;
    if($query_load=mysqli_query($conn, $query)){
        while($row = mysqli_fetch_array($query_load))
        {
            echo '<button type="submit" name="choreID" value="'.$row["id"].'"> <div class="chore"> <div class="chore_address"><a>'.$row["choreLocation"].'</a></div> <div class="chore_time"><a>Time: '.$row["choreDuration"].' minutes</a></div><div class="chore_payment"><a>'.$row["chorePayment"].'$</a></div> </button>';
        }
    }
    //echo $chLim;
?>
<?php
    session_start();
    require_once("server-scripts/connect_db.php");

    $query = "UPDATE `workers` SET `has_onboard` = '1' WHERE `workers`.`email` = '".$_SESSION['wemail']."';";
    if($x = mysqli_query($conn, $query))
    {
        echo $_SESSION['wemail'];
        header("LOCATION: worker-chores-type.php");
    }
?>
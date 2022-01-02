<?php
    session_start();
    require_once("connect_db.php");

    $query = "UPDATE `workers` SET `totalSum` = '0', `commission` = '0' WHERE `workers`.`email` = '".$_SESSION['wemail']."'";
    if($exec_query = mysqli_query($conn, $query))
    {
        echo "ok";
    }

    $query = "DELETE FROM `unpaid_chores` WHERE `unpaid_chores`.`workerid` = '".$_SESSION['wemail']."'";
    if($exec_query = mysqli_query($conn, $query))
    {
        echo "ok";
    }
?>
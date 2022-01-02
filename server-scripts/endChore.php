<?php
    session_start();
    require_once("connect_db.php");
            
    $query_update = "UPDATE `chores` SET `choreStatus` = '3' WHERE `chores`.`id` = ". $_SESSION['choreID'];
    $query_update_ok = mysqli_query($conn, $query_update);
    $query_update = "DELETE FROM `chores_open` WHERE `chores_open`.`chore_id` =". $_SESSION['choreID'];
    $query_update_ok = mysqli_query($conn, $query_update);

    $query_update = "SELECT * FROM `chores` WHERE `chores`.`id` = ". $_SESSION['choreID'];
    $query_update_ok = mysqli_query($conn, $query_update);
    $res = mysqli_fetch_array($query_update_ok);


    unset($_SESSION['choreID']);
    header("LOCATION: ./chores-type.php");
    echo($res);

    //nset($_SESSION['choreID']);
    //header("LOCATION: ./chores-type.php");

?>
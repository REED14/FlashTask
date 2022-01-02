<?php
    session_start();
    require_once("connect_db.php");

    $query = "SELECT * FROM `chores` where id = '".$_SESSION['choreIDW']."'";
    if($res_query= mysqli_query($conn, $query))
    {
        $choreinfo = mysqli_fetch_assoc($res_query);
    }

    $choreState = $choreinfo['choreStatus'];
    $_SESSION['choreStatus']=$choreinfo['choreStatus'];

    $userCoordX = 0;
    $userCoordY = 0;
    $workerCoordX = 0;
    $workerCoordY = 0;

    $query = "SELECT * FROM `chores_open` where `chore_id` = '".$_SESSION['choreIDW']."'";
    $query_data = mysqli_fetch_assoc(mysqli_query($conn, $query));
    if($query_data!=null){
        $userCoordX = $query_data["clientLng"];
        $userCoordY = $query_data["clientLat"];
        $workerCoordX = $query_data["workerLng"];
        $workerCoordY = $query_data["workerLat"];
    }

    if(isset($_POST['userPosX'])){
        $userCoordX = $_POST['userPosX'];
        $userCoordY = $_POST['userPosY'];
        $query = "UPDATE `chores_open` SET `clientLng` = '". $userCoordX ."', `clientLat` =  '". $userCoordY ."'WHERE `chores_open`.`chore_id` = ". $_SESSION['choreIDW'];
        $query_exec = mysqli_query($conn, $query);
    }
    else if(isset($_POST['workerPosX'])){
        $workerCoordX = $_POST['workerPosX'];
        $workerCoordY = $_POST['workerPosY'];
        $query = "UPDATE `chores_open` SET `workerLng` = '". $workerCoordX ."', `workerLat` =  '". $workerCoordY ."', `worker_email` = '".$_SESSION["wemail"]."' WHERE `chores_open`.`chore_id` = ". $_SESSION['choreIDW'];
        $query_exec = mysqli_query($conn, $query);
    }
    else{
        $query = "SELECT * FROM `chores_open` where `chore_id` = '".$_SESSION['choreIDW']."'";
        $query_data = mysqli_fetch_assoc(mysqli_query($conn, $query));
        $userCoordX = $query_data["clientLng"];
        $userCoordY = $query_data["clientLat"];
        $workerCoordX = $query_data["workerLng"];
        $workerCoordY = $query_data["workerLat"];
    }

    $chore_data = array(
        "choreStatus"=>$choreState,
        "wLng"=>$workerCoordX,
        "wLat"=>$workerCoordY,
        "uLng"=>$userCoordX,
        "uLat"=>$userCoordY,
    );

    echo json_encode($chore_data);
?>
<?php
    session_start();
    require_once("connect_db.php");

    $query = "SELECT * FROM `chores` where id = '".$_SESSION['choreID']."'";
    if($res_query= mysqli_query($conn, $query))
    {
        $choreinfo = mysqli_fetch_assoc($res_query);
    }

    $choreState = $choreinfo['choreStatus'];
    $choreCash = $choreinfo['chorePaymentCash'];

    $userCoordX = 0;
    $userCoordY = 0;
    $workerCoordX = 0;
    $workerCoordY = 0;


    $query = "SELECT * FROM `chores_open` where `chore_id` = '".$_SESSION['choreID']."'";
    $query_data = mysqli_fetch_assoc(mysqli_query($conn, $query));
    if($query_data!=null){
        $userCoordX = $query_data["clientLng"];
        $userCoordY = $query_data["clientLat"];
        $workerCoordX = $query_data["workerLng"];
        $workerCoordY = $query_data["workerLat"];
        $workerCoordY = $query_data["workerLat"];
        $wEmail = $query_data['worker_email'];

        $query = "SELECT * FROM `workers` where `email` = '".$wEmail."'";
        if($res_query= mysqli_query($conn, $query))
        {
            $wData = mysqli_fetch_assoc($res_query);
            if($wData != null)
                $wPhone = $wData['phone'];
        }
    }

    if(isset($_POST['userPosX'])){
        $userCoordX = $_POST['userPosX'];
        $userCoordY = $_POST['userPosY'];
        $query = "UPDATE `chores_open` SET `clientLng` = '". $userCoordX ."', `clientLat` =  '". $userCoordY ."'WHERE `chores_open`.`chore_id` = ". $_SESSION['choreID'];
        $query_exec = mysqli_query($conn, $query);
    }
    else if(isset($_POST['workerPosX'])){
        $workerCoordX = $_POST['workerPosX'];
        $workerCoordY = $_POST['workerPosY'];
        $query = "UPDATE `chores_open` SET `workerLng` = '". $workerCoordX ."', `workerLat` =  '". $workerCoordY ."'WHERE `chores_open`.`chore_id` = ". $_SESSION['choreID'];
        $query_exec = mysqli_query($conn, $query);
    }
    /*
    else{
        $query = "SELECT * FROM `chores_open` where `chore_id` = '".$_SESSION['choreID']."'";
        $query_data = mysqli_fetch_assoc(mysqli_query($conn, $query));
        $userCoordX = $query_data["clientLng"];
        $userCoordY = $query_data["clientLat"];
        $workerCoordX = $query_data["workerLng"];
        $workerCoordY = $query_data["workerLat"];
    }*/

    if($choreState==3){
        unset($_SESSION['choreID']);
        $query = "UPDATE `users` SET `choreID` = '0' WHERE `users`.`email` = '". $_SESSION['email']."'";
        $query_exec = mysqli_query($conn, $query);
    }

    if(isset($wPhone))
        $chore_data = array(
            "choreStatus"=>$choreState,
            "chorePayment"=>$choreCash,
            "wLng"=>$workerCoordX,
            "wLat"=>$workerCoordY,
            "uLng"=>$userCoordX,
            "uLat"=>$userCoordY,
            "phone"=>$wPhone,
            "email"=>$wEmail
        );
    
    else if(isset($workerCoordX))
    $chore_data = array(
        "choreStatus"=>$choreState,
        "chorePayment"=>$choreCash,
        "wLng"=>$workerCoordX,
        "wLat"=>$workerCoordY,
        "uLng"=>$userCoordX,
        "uLat"=>$userCoordY
    );

    echo json_encode($chore_data);
?>
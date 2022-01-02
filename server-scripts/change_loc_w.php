<?php
    if($_SERVER['REQUEST_METHOD']=="POST"){
        require("connect_db.php");
        session_start();

        $query = "SELECT * FROM `location_worker` WHERE `id`='". $_POST['location'] ."'";
        if($res = mysqli_query($conn, $query)){
            while($locs = mysqli_fetch_array($res))
            {
                $queryUpdate = "UPDATE `workers` SET `country` = '". $locs['country'] ."', `county` = '". $locs['county'] ."', `city` = '". $locs['city'] ."', 
                `street` = '". $locs['street'] ."', `postal_code` = '". $locs['postal_code'] ."' WHERE `workers`.`email` = '".$_SESSION['wemail']."'";

                $update = mysqli_query($conn, $queryUpdate);

                $get_user_data = mysqli_query($conn, "SELECT * FROM `workers` WHERE `email`='".$_SESSION["wemail"]."'");
                $user_db_data = mysqli_fetch_assoc($get_user_data);
                $_SESSION['waddress'] = $user_db_data["country"]. ", " .$user_db_data["county"]. ", " .$user_db_data["city"]. ", " .$user_db_data["street"]. ", " .$user_db_data["postal_code"];
                $_SESSION['wshort-address'] = $user_db_data["country"]. ", " .$user_db_data["city"];
                //echo $_SESSION['address'];
            }
        }
    }

    header("location: ../worker-chores-type.php");
?>
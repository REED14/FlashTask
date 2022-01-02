<?php
    if($_SERVER['REQUEST_METHOD']=="POST"){
        require("connect_db.php");
        session_start();

        $query = "SELECT * FROM `location_user` WHERE `id`='". $_POST['location'] ."'";
        if($res = mysqli_query($conn, $query)){
            while($locs = mysqli_fetch_array($res))
            {
                $queryUpdate = "UPDATE `users` SET `country` = '". $locs['country'] ."', `county` = '". $locs['county'] ."', `city` = '". $locs['city'] ."', 
                `street` = '". $locs['street'] ."', `postal_code` = '". $locs['postal_code'] ."' WHERE `users`.`email` = '".$_SESSION['email']."'";

                $update = mysqli_query($conn, $queryUpdate);

                $get_user_data = mysqli_query($conn, "SELECT * FROM `users` WHERE `email`='".$_SESSION["email"]."'");
                $user_db_data = mysqli_fetch_assoc($get_user_data);
                $_SESSION['address'] = $user_db_data["country"]. ", " .$user_db_data["county"]. ", " .$user_db_data["city"]. ", " .$user_db_data["street"]. ", " .$user_db_data["postal_code"];
                $_SESSION['short-address'] = $user_db_data["country"]. ", " .$user_db_data["city"];
                //echo $_SESSION['address'];
            }
        }
    }

    header("location: ../chores-type.php");
?>
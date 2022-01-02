<?php

    if($_SERVER['REQUEST_METHOD']=="POST")
    {
        session_start();
        require_once("connect_db.php");
            
        $query = "INSERT INTO `location_user` (`id`, `country`, `county`, `city`, `street`, `postal_code`, `email`) VALUES 
        (NULL, '".$_POST['country']."', '".$_POST['county']."', '".$_POST['city']."', '".$_POST['street']."', '".$_POST['pcode']."', '".$_SESSION['email']."')";

        $res = mysqli_query($conn, $query);

    }

    header("location: ../userLocation.php");
?>
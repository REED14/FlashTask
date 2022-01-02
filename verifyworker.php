<?php
require_once("server-scripts/connect_db.php");
if($userexist = mysqli_query($conn, "SELECT * FROM `workers` WHERE `email`='".$_GET["email"]."' and `Hash`='".$_GET["hash"]."'")->num_rows)
{
    echo("your account has been verified with success. You can now log in using your account!<a href='index.php'>Go to Home Page</a>");
    mysqli_query($conn,"UPDATE `workers` SET `Verified` = '1' WHERE `workers`.`email` = '".$_GET["email"]."'"); 
}
else{
    echo("wrong hash or invalid account");
}
?>
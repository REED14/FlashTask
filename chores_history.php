<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="chistory.css">
    <title>FlashTask | Payment and Commissions</title>
</head>

<?php
    session_start();
    if(!isset($_SESSION['email'])){
        header("LOCATION: ./chores-type.php");
    }
    if(isset($_SESSION['choreID'])){
        //sleep(5);
        header("LOCATION: ./chore-progress.php");
    }
?>

<body>

    <header>
        <img onClick="window.location.href='chores-type.php'" src="svgs/Back.svg" class="sidebar-button2" width="25px" height="25px">
        <a>Chores History</a>
    </header>

    <div id="payment-grid">
        <div id="payment-series">
            <?php
                require_once("server-scripts/connect_db.php");

                $query = "SELECT * FROM `chores` WHERE `choreRequester`='".$_SESSION['email']."' ORDER BY `choreDate` DESC";
                if($exec_query = mysqli_query($conn, $query)){
                    while($row = mysqli_fetch_assoc($exec_query)){
                        $namechore = "idk";
                        switch($row['choreType']){
                            case 0:
                                $namechore = "Trim my Lawn";
                                break;
                            
                            case 1:
                                $namechore = "Carry Stuff";
                                break;
                            
                            case 2:
                                $namechore = "Wash Car";
                                break;
                            
                            case 3:
                                $namechore = "Fix Stuff";
                                break;
                            
                            case 4:
                                $namechore = $row['choreName'];
                        }

                        echo "
                        <div class='payment-pair'>
                            <div class='unpaid-date'> 
                                <div class='unpaid-name'>
                                    <a>". 
                                        $namechore
                                    ."</a>
                                </div>
                                <a>". $row['choreDate'] ."</a>
                            </div>
                            <div class='unpaid-price'>
                                <a>". $row['chorePayment'] ."$</a>
                            </div>
                        </div>";
                    }
                }

            ?>
        </div>

    </div>
</body>
</html>
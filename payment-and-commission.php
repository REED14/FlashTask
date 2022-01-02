<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="payments.css">
    <script src="https://js.stripe.com/v3/"></script>
    <script src="jquery-3.6.0.min.js"></script>
    <script src="scripts/chargeWorker.js" defer></script>
    <title>FlashTask | Payment and Commissions</title>
</head>

<?php
    session_start();
    if(!isset($_SESSION['wemail'])){
        header("LOCATION: ./worker.php");
    }
    if(isset($_SESSION['choreIDW']))
    {
        header("location: worker-chore-progress.php");
    }
?>

<body>

    <header>
        <img onClick="window.location.href='worker-chores-type.php'" src="svgs/Back.svg" class="sidebar-button2" width="25px" height="25px">
        <a>Payments and Commissions</a>
        <?php
            require_once("server-scripts/connect_db.php");

            $query = "SELECT * FROM `workers` WHERE `email`='".$_SESSION['wemail']."'";
            if($exec_query = mysqli_query($conn, $query)){
                while($row = mysqli_fetch_assoc($exec_query)){
                    echo "<a>". $row['commission'] ."$</a>";
                }
            }
        ?>
    </header>

    <div id="payment-grid">
        <div id="payment-series">
            <div class='payment-pair'>
                <div class="unpaid-date">
                    <a>Date</a>
                </div>
                <div class="unpaid-price">
                    <a>Payment</a>
                </div>
            </div>
            <?php
            
                require_once("server-scripts/connect_db.php");

                $query = "SELECT * FROM `unpaid_chores` WHERE `workerid`='".$_SESSION['wemail']."'";
                if($exec_query = mysqli_query($conn, $query)){
                    while($row = mysqli_fetch_assoc($exec_query)){
                        echo "
                        <div class='payment-pair'>
                            <div class='unpaid-date'>
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
        <?php
            
            require_once("server-scripts/connect_db.php");

            $query = "SELECT * FROM `workers` WHERE `email`='".$_SESSION['wemail']."'";
            if($exec_query = mysqli_query($conn, $query)){
                while($row = mysqli_fetch_assoc($exec_query)){
                    echo "
                    <div class='payment-pair'>
                        <div class='unpaid-date'>
                            <a>Your Total: ". $row['totalSum'] ."$</a>
                        </div>
                        <div class='unpaid-price'>
                            <a>Commission: ". $row['commission'] ."$</a>
                        </div>
                    </div>";
                }
            }

        ?>
    </div>

    <div id="forbutton">
        <!--button>Pay Commission</button-->
        <form id="payment-form" method="post">
            <div id="card-element"></div> 
            <input id="submit" type="submit" value="Submit"></submit>
            <p id="card-error"></p>
            <p class="result-message hidden">Payment Succeed</p>
        </form>
    </div>
</body>
</html>
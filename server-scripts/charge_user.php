<?php
    session_start();
    require_once('stripe/init.php');

    require_once("connect_db.php");

    $query = "SELECT * FROM `chores` where id = '".$_SESSION['choreID']."'";
    if($res_query= mysqli_query($conn, $query))
    {
        $choreRow = mysqli_fetch_assoc($res_query);
        $chargeAmmount = $choreRow['chorePayment'] * 100;
    }

    $query = "SELECT * FROM `chores_open` where `chore_id` = '".$_SESSION['choreID']."'";
    $query_data = mysqli_fetch_assoc(mysqli_query($conn, $query));
    $workerEmail = $query_data['worker_email'];

    \Stripe\Stripe::setApiKey('sk_test_put whatever you want here');

    header('Content-Type: application/json');

    $query = "SELECT * FROM `workers` where `email` = '".$workerEmail."'";
    if($res_query= mysqli_query($conn, $query))
    {
        $wData = mysqli_fetch_assoc($res_query);
    }

    $wAcctStripe = $wData['stripe_id'];

    try{
        $json_str = file_get_contents('php://input');
        $json_obj = json_decode($json_str);

        $paymentIntent = \Stripe\PaymentIntent::create([
            'amount' => $chargeAmmount,
            'currency' => 'usd',
            'application_fee_amount' => 0,
            'transfer_data' => [
                'destination' => ''.$wAcctStripe.'',
            ]
        ]);

        $output = [
            'clientSecret' => $paymentIntent->client_secret,
        ];

        echo json_encode($output);
    }
    catch (Error $e){
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
?>
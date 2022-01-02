<?php
    session_start();
    require_once('stripe/init.php');

    require_once("connect_db.php");

    $query = "SELECT * FROM `workers` where `email` = '".$_SESSION['wemail']."'";
    if($res_query= mysqli_query($conn, $query))
    {
        $choreRow = mysqli_fetch_assoc($res_query);
        $chargeAmmount = $choreRow['commission'] * 100;
    }

    \Stripe\Stripe::setApiKey('sk_test_put whatever you want here');

    header('Content-Type: application/json');

    try{
        $json_str = file_get_contents('php://input');
        $json_obj = json_decode($json_str);

        $paymentIntent = \Stripe\PaymentIntent::create([
            'amount' => $chargeAmmount,
            'currency' => 'usd',
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
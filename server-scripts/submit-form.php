<?php
    if(isset($_POST["submitChore"])){
        session_start();
        $choredata = array("chore-type"=>"", "chore_name"=>"","ch-description"=>"", "estimated-time"=>"", "payment"=>"", "payment-method"=>"", "state"=>"", "locationShort"=>"", "location"=>"", "requester"=>"", "TokenNtf"=>"");
        require_once("connect_db.php");

        if(!isset($_POST['TokenNtf']))
        $_POST['TokenNtf'] = NULL;

        foreach($_POST as $key => $value){
            $choredata[$key]=$value;
            $choredata[$key]=str_replace('"', '\"', $choredata[$key]);
            $choredata[$key]=htmlspecialchars($choredata[$key], ENT_QUOTES, 'UTF-8', true);
            //echo($key. " " . $choredata[$key] . "<br>");
            if($key=="requester") break;
        }

        $choredata['state']=0;
        $choredata["locationShort"] = $_SESSION['short-address'];
        $choredata["location"] = $_SESSION['address'];

        $choreType = "";
        switch($choredata["chore-type"]){
            case("lawn_trim"):
                $choreType=0;
                break;
            case("carry_stuff"):
                $choreType=1;
                break;
            case("wash_car"):
                $choreType=2;
                break;
            case("fix_stuff"):
                $choreType=3;
                break;
            default:
                $choreType=4;
                break;
        }

        if($choredata["payment-method"]=="cash")
            $choredata["payment-method"]=1;
        else
            $choredata["payment-method"]=0;

        $vals_insert = "(NULL, " . $choreType . ", ";

        $choredata["requester"]=$_SESSION["email"];

        foreach($choredata as $dataname => $value)
        {
            echo($dataname. ": " . $choredata[$dataname] . "<br>");
            
            if($dataname != "submitChore"){
                if($dataname != "chore-type" && $dataname != "requester")
                {
                    $vals_insert = $vals_insert . "'" . $value . "', ";
                }
                else if($dataname == "requester"){
                    $vals_insert = $vals_insert . "'" . $value . "', ";
                }
            }
            //$vals_insert = $vals_insert . 
        }

        //echo($_POST['TokenNtf']);

        $vals_insert = $vals_insert . "'" . date("Y-m-d H:i:s") . "'";
        $vals_insert = $vals_insert . ")";
        /*
        echo("<br>");
        echo($vals_insert);
        echo("<br>");echo("<br>");
        echo("`id`, `choreType`, `choreName`, `choreDescription`, `choreDuration`, 
        `chorePayment`, `chorePaymentCash`, `choreStatus`,`choreLocationShort`, `choreLocation`");
        */
        
        $chore_insert = "INSERT INTO `chores` (`id`, `choreType`, `choreName`, `choreDescription`, `choreDuration`, `chorePayment`, `chorePaymentCash`, `choreStatus`,`choreLocationShort`, `choreLocation`, `choreRequester`, `NotificationToken`, `choreDate`) VALUES" . $vals_insert; 
        echo $chore_insert;
        if($chore_insert_query=mysqli_query($conn, $chore_insert))
        {
            $chore_id = mysqli_insert_id($conn);
            $_SESSION["choreID"]=$chore_id;
            $choreopen_insert = "INSERT INTO `chores_open` (`id`, `chore_id`, `clientLat`, `clientLng`, `workerLat`, `workerLng`) VALUES (NULL, '".$chore_id."', '0', '0', '0', '0')";
            $choreopen_insert_query = mysqli_query($conn, $choreopen_insert);
            echo("insert successfull ". $chore_id);

            $changeUsrChID = "UPDATE `users` SET `ChoreID` = '".$chore_id."' WHERE `users`.`email` = '".$_SESSION['email']."'";
            $changeUsrChID_q = mysqli_query($conn, $changeUsrChID);

            header("location: ../chore-progress.php");
        }
        else{
            echo("insert failed");
            //echo($_POST['TokenNtf']);
        }
    }
?>
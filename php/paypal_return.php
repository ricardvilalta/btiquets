<?php
    include_once 'common.php';
    include_once '../php/funcions.php';
    include_once '../php/btdv_funcions.php';
    
    global $mysqli;
    global $lang;       

    $order_id = $_POST['item_name'];
    $item_number = $_POST['item_number'];
    $payment_status = $_POST['payment_status'];
    $payment_amount = $_POST['mc_gross'];
    $payment_currency = $_POST['mc_currency'];
    $txn_id = $_POST['txn_id'];
    $txn_type = $_POST['txn_type'];
    $receiver_email = $_POST['receiver_email'];
    $payer_email = $_POST['payer_email'];

    $box = GetBox($mysqli,$item_number);            
    $accountdata = GetAccountInfo($mysqli,$box['propietari']);
    
    if($item_number && $txn_type)
    {
        if($txn_type=="web_accept")
        {             
            $info_reserva = GetReservation_by_ref($mysqli,$order_id);
            ConfirmReservation($mysqli,$order_id,1);                        

            SendConfirmation6($mysqli,$info_reserva);
            SendConfirmation7($mysqli,$info_reserva);

        }
        else
        {
            error_log("PAYPAL ITEM ERROR");
        }			
    }
    else
    {
        error_log("ERROR: ".$item_number."//".$txn_type);
	}    
?>
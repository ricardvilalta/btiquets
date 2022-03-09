<?php
    include_once 'common.php';
    include_once '../php/funcions.php';
    include_once '../php/btdv_funcions.php';
    include_once '../php/apiRedsys.php';
    
    global $mysqli;
    global $lang;   

    // Se crea Objeto
    $miObj = new RedsysAPI;
//    error_log("TEST 1");
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $version = $_POST["Ds_SignatureVersion"];
        $datos = $_POST["Ds_MerchantParameters"];
        $signatureRecibida = $_POST["Ds_Signature"];

        $box = GetBox($mysqli,$_GET['event']);            
        $accountdata = GetAccountInfo($mysqli,$box['propietari']);

        $key = $accountdata['key'];
        $firma = $miObj->createMerchantSignatureNotif($key,$datos);	
        $decodec = $miObj->decodeMerchantParameters($datos);
        if ($firma === $signatureRecibida)
        {
            //FIRMA OK. Hacer tareas del servidor
            $Ds_Response = $miObj->getParameter("Ds_Response");
            $order_id = $miObj->getParameter("Ds_MerchantData");

            if(intval($Ds_Response)>=0 && intval($Ds_Response)<100)
            { 
                $info_reserva = GetReservation_by_ref($mysqli,$order_id);
                
                // abans de confirmar la reserva, torno a comprovar que era una reserva amb un import >0,
                // per evitar que entrin situacions anòmales
                if(floatval($info_reserva['total'])>0)
                {
                    ConfirmReservation($mysqli,$order_id,1);
                    
                    // Casos particulars
                    if($box['id']==262) // Comerç SFB
                    {
                        SendConfirmation6_sp1($mysqli,$info_reserva,"",true);
                    }
                    else if($box['id']==348 || $box['id']==358 || $box['id']==359 || $box['id']==360 || $box['id']==361 || $box['id']==362 || $box['id']==363) // Transèquia
                    {                        
                        SendConfirmation6_sp2($mysqli,$info_reserva,"",true);
                    }
                    else
                    {
                        SendConfirmation6($mysqli,$info_reserva);                    
                    }
                    
                    SendConfirmation7($mysqli,$info_reserva);
                }
                else
                {
                    error_log("QUANTITY ERROR: " . $order_id);
                }
            }
            else
            {
                ConfirmReservation($mysqli,$order_id,-1);
                error_log("RESPONSE ERROR: " . $order_id);
            }
        }
        else
        {
            error_log("FIRMA ERROR");
        }
    }
    else
    {
        error_log("NO POST REQUEST_METHOD");
    }
?>
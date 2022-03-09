<?php

	header('Access-Control-Allow-Origin: *');
    include_once 'common.php';
    include_once '../php/funcions.php';
    include_once '../php/btdv_funcions.php';
    include_once '../php/apiRedsys.php';
    
    global $mysqli;
    global $lang;

    $pid = 0;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // Agafo les dades passades
        $id = intval($_POST["id"]);
        if(isset($_POST["pid"]))    $pid = intval($_POST["pid"]);
        if(isset($_POST["estab"]))  $estab = addslashes($_POST["estab"]);
        if(isset($_POST["quant"]))  $total = addslashes($_POST["quant"]);
        if(isset($_POST["nom"]))    $nom = addslashes($_POST["nom"]);
        if(isset($_POST["email"]))  $email = addslashes($_POST["email"]);
        if(isset($_POST["tel"]))    $tel = addslashes($_POST["tel"]);
           
        
        $addr_aux = "";
        $city = "";
        $com = "";
        $quant = 1;
        
        if($id==262) // Comerç SFB
        {
            $com = $pid . " - " . $estab;
        }

        // Recupero la informació del BOX i del COMPTE
        $box = GetBox($mysqli,$id);            
        $accountdata = GetAccountInfo($mysqli,$box['propietari']);

        // Aquest string és el preu amb dos decimals però sense coma ni punt
        $total_str = number_format($total,2,'','');
        
        // Data
        date_default_timezone_set($zone);
        $data = date('Y-m-d');
        
        $num_reserva = GenerateReservation();

        $ret = InsertReservation($mysqli,-1,$id,-1,$com,$quant,$num_reserva,$total,$data,null,1,0,"",null,-2,"","",$nom,$email,$tel);
        
        // Si ha anat bé, preparo el formulari de pagament
        if($ret>0)
        {
            $info_reserva = GetReservation($mysqli,$ret);            
            $userdata = GetUInfo($mysqli,$box['propietari']);
            $accountdata = GetAccountInfo($mysqli,$box['propietari']);
            $info_reserva['colmail']=$box['mail_aux'];            

            // Se crea Objeto
            $miObj = new RedsysAPI;

            // Valores de entrada
            $terminal 		="1";
            $amount 		= $total_str;
            $transactionType = "0";
            $merchantURL 	= $server.'tpv-notification/'.$info_reserva['box_id'];
            $urlOK 			= $server.'process-ok/'.$box['url'].'/'.$info_reserva['ref'];
            $urlKO 			= $server.'process-fail/'.$box['url'];
            $order 			= time();
            $merchantName   = $accountdata['nom'];            
            $merchantCode 	= $accountdata['merchantcode'];
            $terminal 		= $accountdata['terminal'];
            $currency 		= $accountdata['currency'];
            $key            = $accountdata['key'];
            $urlPago        = $accountdata['url'];

            //Datos de configuración
            $version="HMAC_SHA256_V1";
            
            //Casos particulars
            if($id==262) // Comerç SFB
            {
                $urlOK 			= "http://comercobert.santfruitos.cat/compraok.php?codi=" . $info_reserva['ref'];
                $urlKO 			= "http://comercobert.santfruitos.cat/comprako.php";
            }

            PrepararTPV($miObj,$amount,$order,$merchantCode,$currency,$transactionType,$terminal,$merchantURL,$urlOK,$urlKO,$info_reserva['ref'],$info_reserva['ref']." - ".box['name'],$merchantName);

            // Se generan los parámetros de la petición	
            $params = $miObj->createMerchantParameters();
            $signature = $miObj->createMerchantSignature($key);                        

            $pvp = "TOTAL = " . $total . "€";            
            
            $dades_personals = $nom . '<br>' . $email . '<br>' . $tel . '<br>' . $addr_aux . '<br>';

            $html = 
                '<div class="container">
                    <div class="content">
                        <header class="major">
                            <h2>' . translate("Pagament", $lang) . '</h2>
                        </header>
                        <h4>' . $pvp . '</h4>
                        <h4>' . $dades_personals . '</h4>
                        <a id="pagar" class="button special icon fa-credit-card">' . translate("Pagar", $lang) .'</a></li>
                        
                        <div style="font-size:.7em">
                            <div>' . translate("Pagament amb <b>targeta de crèdit</b> o mitjançant el sistema", $lang) . '</div>
                            <div style="">' . translate("Ubicació de l'establiment: Espanya", $lang) . '</div>
                        </div>
                    </div>
                </div>
                <form id="tpv" action="' . $urlPago . '" method="post">
                    <!-- hidden params -->
                    <input name="op" type="hidden" value="confirmation" />
                    <input name="op" type="hidden" value="-2" />
                    <input name="id" type="hidden" value="' . $info_reserva['ref'] . '" />
                    <input name="Ds_SignatureVersion" type="hidden" value="' . $version . '" />
                    <input name="Ds_MerchantParameters" type="hidden" value="' . $params . '" />
                    <input name="Ds_Signature" type="hidden" value="' . $signature . '" />
                </form>';
        
            $return = "registration-ok\\".$html;
        }
        else
        {
	        $return = "INSERT RESERVATION ERROR";
    	    error_log($return);
        }
    }
    else
    {
	    $return = "NO POST REQUEST_METHOD";
        error_log($return);
    }
    
    echo $return;
?>
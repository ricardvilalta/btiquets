<?php  

    include_once 'common.php';
    include_once '../php/funcions.php';
    include_once '../php/btdv_funcions.php'; 
    include_once '../php/apiRedsys.php';
    require("../php/postClass.php");

    global $mysqli;

    if(isset($_POST["box_id"]) && isset($_POST["nom"]) && isset($_POST["email"]) && isset($_POST["addr1"]) && isset($_POST["cp"]) && isset($_POST["tel"]) && isset($_POST["quant_str"]))
    {
        
        // Torno a calcular el valor del carret
        $box = GetBox($mysqli,intval($_POST["box_id"]));
        $producte_list = GetProductefromList($mysqli,$box["productes"]);
        $total = 0;
        $tiquets_reservats = "";
        foreach($producte_list as $producte)
        {
            foreach($producte['modalitat'] as $prod_item)
            {
                $carret = decode_carret($_POST["quant_str"],$producte['id'],$prod_item['id']);
                $quant = intval($carret[0]['quant']);
                $price = floatval(str_replace(',', '.',$prod_item['preu']));
                
                if($quant>0)
                {                    
                    $str = $quant . ' x ' . $producte['name'] . " - " . $prod_item['nom'] . '</br>';
                    $tiquets_reservats .= $str;
                    
                    $subtotal = $quant*$price;
                    $total += $subtotal;
                }
            }
        }
        
        // Aquest string és le preu amb dos decimals però sense coma ni punt
        $total_str = number_format($total,2,'','');
        
        // Data
        date_default_timezone_set($zone);
        $data = date('Y-m-d');
        
        $num_reserva = GenerateReservation();

        $ret = InsertReservation($mysqli,-1,intval($_POST["box_id"]),-1,addslashes($_POST["com"]),$_POST["quant_str"],$num_reserva,$total,$data,null,1,0,"",null,-2,"","",addslashes($_POST["nom"]),addslashes($_POST["email"]),addslashes($_POST["tel"]),addslashes($_POST["city"]),true,"",6,false,"",$_POST["newsletter"],1,addslashes($_POST["addr1"]),addslashes($_POST["addr2"]),addslashes($_POST["cp"]));
        
        // Si ha anat bé, s'ha d'entrar la reserva
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

            PrepararTPV($miObj,$amount,$order,$merchantCode,$currency,$transactionType,$terminal,$merchantURL,$urlOK,$urlKO,$info_reserva['ref'],$info_reserva['ref']." - ".box['name'],$merchantName);

            // Se generan los parámetros de la petición	
            $params = $miObj->createMerchantParameters();
            $signature = $miObj->createMerchantSignature($key);                        
            
            if($accountdata['bizum'])
            {
                    PrepararTPV($miObj,$amount,$order,$merchantCode,$currency,$transactionType,$terminal,$merchantURL,$urlOK,$urlKO,$info_reserva['ref'],$info_reserva['ref']." - ".box['name'],$merchantName,'z');

                // Se generan los parámetros de la petición	
                $params_bizum = $miObj->createMerchantParameters();
                $signature_bizum = $miObj->createMerchantSignature($key);
            }

            $pvp = "TOTAL = " . $total . "€";
            
            $addr_aux = addslashes($_POST["addr1"]);
            if($_POST["addr2"]!="") $addr_aux .= addslashes($_POST["addr2"]);
            
            $dades_personals = addslashes($_POST["nom"]) . '<br>' . addslashes($_POST["email"]) . '<br>' . addslashes($_POST["tel"]) . '<br>' . $addr_aux . '<br>' . addslashes($_POST["city"]) . '<br>' . addslashes($_POST["cp"]) . '<br>' . addslashes($_POST["com"]) . '<br>';

            $html = "";
            $html_aux = 
                '<div class="container">
                    <div class="content">
                        <header class="major">
                            <h2>' . translate("Pagament", $lang) . '</h2>
                        </header>
                        <h4>' . $tiquets_reservats . '</h4>
                        <h4>' . $pvp . '</h4>
                        <h4>' . $dades_personals . '</h4>
                        <ul style="margin-bottom:1em" class="actions">
                            <li><a id="pagar" class="button special icon fa-credit-card">' . translate("Pagar amb targeta", $lang) .'</a></li>
                        </ul>';
            $html .= $html_aux;
                            
            if($accountdata['bizum'])
            {            
                $html_aux =         
                    '<ul style="margin-bottom:1em" class="actions">
                        <li><a id="pagar_bizum" class="button special icon fa-mobile">' . translate("Pagar amb Bizum", $lang) .'</a></li>
                    </ul>';
                $html .= $html_aux;
            }

            if($accountdata['bizum'])
            {
                $html_aux = 
                        '<div style="font-size:.7em">
                            <div style="margin-bottom: 3em;">' . translate("Pagament amb <b>targeta de crèdit</b>, mitjançant el sistema", $lang) . '<img style="margin-left:.5em;display:inline;vertical-align: middle;" width="30em" src="' . $rootfolder . 'img/iupay.png" alt"iupay">' . translate("o a través del mòbil mitjançant", $lang) . '<img style="margin-left:.5em;display:inline;vertical-align: middle;" width="70em" src="' . $rootfolder . 'img/bizum.png" alt"bizum">' . '</div>';
            }
            else
            {
                $html_aux = 
                        '<div style="font-size:.7em">
                            <div>' . translate("Pagament amb <b>targeta de crèdit</b> o mitjançant el sistema", $lang) . '<img style="margin-left:.5em;display:inline;vertical-align: middle;" width="30em" src="' . $rootfolder . 'img/iupay.png" alt"iupay"></div>';
            }
            $html .= $html_aux;

            $html_aux = 
                            '<div style="margin-top: -1em;">' . translate("Ubicació de l'establiment: Espanya", $lang) . '</div>
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
            $html .= $html_aux;
                
            if($accountdata['bizum'])
            {
                $html_aux = '<form id="tpv_bizum" action="' . $urlPago . '" method="post">
                    <!-- hidden params -->
                    <input name="op" type="hidden" value="confirmation" />
                    <input name="val" type="hidden" value="-2" />
                    <input name="id" type="hidden" value="' . $info_reserva['ref'] . '" />
                    <input name="Ds_SignatureVersion" type="hidden" value="' . $version . '" />
                    <input name="Ds_MerchantParameters" type="hidden" value="' . $params_bizum . '" />
                    <input name="Ds_Signature" type="hidden" value="' . $signature_bizum . '" />
                </form>';
                $html .= $html_aux;
            }

            $return = $html;         
        }
        
        echo $return;
    }
    else
    {
        echo -1;
    }
?>
<?php  

    // ENTRAR RESERVA
    // TIPUS 0 I 1 - sessió única i sessions calendari

    include_once 'common.php';
    include_once '../php/funcions.php';
    include_once '../php/btdv_funcions.php'; 
    include_once '../php/apiRedsys.php';
    require("../php/postClass.php");
    $thisPost = new Post_Block;

    global $mysqli;
    $sense_places = false;
    $found = false;
    
    $lang = $_POST["lang"];

    if(isset($_POST["box_id"]) && isset($_POST["nom"]) && isset($_POST["email"]) && isset($_POST["city"]) && isset($_POST["tel"]) && isset($_POST["data_res"]) && isset($_POST["quant_str"]))
    {
        
        // Data
        date_default_timezone_set($zone);
        $data = date('Y-m-d');
        

        $num_reserva = GenerateReservation();
        
        // Càlcul del cost 
        $tiquets_reservats = "";
        $box_id = intval($_POST["box_id"]);
        $quant = $_POST["quant_str"];
        $no_solidari = false;
        $check_special = false;
        $codi_aplicat = null;
        if($box_id>0)
        {
            $descompte = null;
            $box = GetBox($mysqli,$box_id);
            if($box['codi_descompte']>0) {
                $descompte = CheckDescompte($box['codi_descompte'],$_POST["codi_descompte"]);
            }
            
            
            if($box['etype']==7)
            {
                $total = floatval($quant);
            }
            else
            {  
                if(isset($_POST["check_special"])) {
                    $no_solidari = $_POST["check_special"]==1?false:true;
                    $check_special = $_POST["check_special"];
                }

                // decodifico l'string de modalitats de preu
                $price_modalities = decode_price($box['price'],false);
                $quant_modalities = explode(';',$quant);
                $total = 0;
                $qtotal = 0;
                for($i=0;$i<count($price_modalities);$i++)
                {
                    $price = floatval($price_modalities[$i]['price']);
                    if($quant_modalities[$i]!='undefined' && $quant_modalities[$i]!=null)
                    {
                        $quant = intval($quant_modalities[$i]);

                        if($quant>0)
                        {
                            $str = $quant . ' x ' . $price_modalities[$i]['name'] . '</br>';
                            $tiquets_reservats .= $str;
                        }
                    }
                    else
                    {
                        $quant = 0;
                    }

                    $qtotal += $quant;
                    $subtotal = $quant*$price;
                    $total += $subtotal;
                }

                if($no_solidari){
                    $total=$total-$qtotal;
                    if($total<0)$total=0;
                }

                if($descompte!=null){
                    if($descompte['type']==0){
                        if($total-$descompte['descompte'] > 0) $total_aux=$total-$descompte['descompte'];
                        else $total_aux=0;
                    }
                    else if($descompte['type']==1){
                        $total_aux=number_format($total*(1-$descompte['descompte']/100),2,',','.');
                    }

                    $descompte_aplicat = $total - $total_aux;
                    $total = $total_aux;
                    $codi_aplicat = $_POST["codi_descompte"];
                }
            }
            
            // Comprovem si encara queden places
            if($box['etype']==0)
            {
                // Comprovar si queden places
                $ocupacio = GetReservationFromBox($mysqli,$box['id']);
                $session = GetSession($mysqli,$box["sessio_unica"]);
                if($qtotal > $session['places']-$ocupacio)
                {
                    $sense_places=true;
                }
            }
            else if($box['etype']==1)
            {
                $sessions = GetSessions($mysqli,$box['id']);
                foreach($sessions as $ses)
                {
                    if($ses['id']==$_POST["data_res"])
                    {
                        $session = $ses;
                        $found=true;
                        break;
                    }
                }
                if($found)
                {
                    $inscrits = GetReservationFromSession($mysqli,$session['id']);
                    if($session['reserva_unica']) {
                        if($inscrits>0) $sense_places=true;
                    }
                    else {
                        if($qtotal > $session['places']-$inscrits) $sense_places=true;
                    }
                }
                else
                {
                    error_log("CHECK OCUPACIO SESSIONS MULTIPLES NO TROBADA");
                }
            }
        }
        else
        {
        }
        
        if($sense_places)
        {
            error_log("SENSE PLACES");
            echo -2;
        }
        else
        {
            // Aquest string és le preu amb dos decimals però sense coma ni punt
            $total_str = number_format($total,2,'','');

            $ret = InsertReservation($mysqli,-1,intval($_POST["box_id"]),-1,addslashes($_POST["com"]),addslashes($_POST["quant_str"]),$num_reserva,$total,$data,null,0,0,null,null,$_POST["data_res"],"","",addslashes($_POST["nom"]),addslashes($_POST["email"]),addslashes($_POST["tel"]),addslashes($_POST["city"]),false,"",6,false,null,$_POST["newsletter"],1,"","","",$_POST["dades"],$_POST["genere"],$_POST["check_1"],$_POST["check_2"],$_POST["check_3"],$check_special,$codi_aplicat,$descompte_aplicat);

            // Si ha anat bé, preparo el formulari de pagament cap al TPV, o acabo el registre
            if($ret>0)
            {
                if($total==0)
                {
                    $info_reserva = GetReservation_by_ref($mysqli,$num_reserva);
                    ConfirmReservation($mysqli,$num_reserva,1);
                    if($box['id']==502 || $box['id']==510 || $box['id']==511) // Trnasèquia 2022
                    {
                        SendConfirmation6_sp2($mysqli,$info_reserva,"",true);
                    }
                    else {
                        if(!SendConfirmation6($mysqli,$info_reserva))
                        {
                            error_log("Client mail error");
                        }
                    }
                    if(!SendConfirmation7($mysqli,$info_reserva))
                    {
                        error_log("Col mail error");
                    }

                    $return = "registration-ok/".$num_reserva;
                }
                else
                {
                    $info_reserva = GetReservation($mysqli,$ret);
                    $box = GetBox($mysqli,$info_reserva['box_id']);            
                    $accountdata = GetAccountInfo($mysqli,$box['propietari']);
                    $userdata = GetUInfo($mysqli,$accountdata['propietari']);
                    $info_reserva['colmail']=$userdata['email'];

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

                    PrepararTPV($miObj,$amount,$order,$merchantCode,$currency,$transactionType,$terminal,$merchantURL,$urlOK,$urlKO,$info_reserva['ref'],$info_reserva['ref']." - ".$box['name'],$merchantName);

                    // Se generan los parámetros de la petición	
                    $params = $miObj->createMerchantParameters();
                    $signature = $miObj->createMerchantSignature($key);

                    if($accountdata['bizum'])
                    {
                            PrepararTPV($miObj,$amount,$order,$merchantCode,$currency,$transactionType,$terminal,$merchantURL,$urlOK,$urlKO,$info_reserva['ref'],$info_reserva['ref']." - ".$box['name'],$merchantName,'z');

                        // Se generan los parámetros de la petición	
                        $params_bizum = $miObj->createMerchantParameters();
                        $signature_bizum = $miObj->createMerchantSignature($key);
                    }

                    if($info_reserva["session_id"]!=-1)
                    {
                        $session = GetSession($mysqli,$info_reserva["session_id"]);
                        $hora = $session['session_name']=="" ? $session['hora'] : $session['session_name'];
                        $data_o = str_replace('-','/',$session['data']);
                        $data_reservada = $data_o . ' ' . $hora;
                    }
                    else
                    {
                    }

                    $pvp = "TOTAL = " . $total . "€";
                    $dades_personals = addslashes($_POST["nom"]) . '<br>' . addslashes($_POST["email"]) . '<br>' . addslashes($_POST["tel"]) . '<br>' . addslashes($_POST["city"]) . '<br>' . addslashes($_POST["com"]);

                    $html = "";
                    $html_aux = 
                        '<div class="container">
                            <div class="content">
                                <header class="major">
                                    <h2>' . translate("Pagament", $lang) . '</h2>
                                </header>
                                <h4>' . $data_reservada . '</h4>
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
            }
            else {
                echo -1;
            }


            echo $return;
        }
    }
    else
    {
        echo -1;
    }

    
?>
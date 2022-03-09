<?php  

    include_once 'common.php';
    include_once '../php/funcions.php';
    include_once '../php/btdv_funcions.php'; 
    include_once '../php/apiRedsys.php';
    require("../php/postClass.php");

    global $mysqli;

    if(isset($_POST["box_id"]) && isset($_POST["nom"]) && isset($_POST["email"]) && isset($_POST["tel"]) && isset($_POST["data_res"]) && isset($_POST["quant_str"]))
    {
        
        // Data
        date_default_timezone_set($zone);
        $data = date('Y-m-d');
        
        // Data res
        $data_res = $_POST["data_res"];
        if($data_res==-999)
        {
            // Sense data
            $date_res_0 = null;
            $date_res_1 = null;
        }
        else
        {
            // Data d'entrada i sortida
            $aux = explode(':',$data_res);   
            $edata_0 = date_create_from_format('d/m/Y',$aux[0]);
            $edata_1 = date_create_from_format('d/m/Y',$aux[1]);
            $date_res_0 = date_format($edata_0,'Y-m-d H:i:s');
            $date_res_1 = date_format($edata_1,'Y-m-d');
        }

        $num_reserva = GenerateReservation();
        
        // Decodifico string de l'allotjament i l'habitació
        $res_str = $_POST["quant_str"];
        $aux = explode('_',$res_str);
        $hid = $aux[0];
        $rid = $aux[1];

        $ret = InsertReservation($mysqli,-1,intval($_POST["box_id"]),-1,addslashes($_POST["com"]),$_POST["quant_str"],$num_reserva,0,$data,null,1,0,$date_res_0,null,-2,"","",addslashes($_POST["nom"]),addslashes($_POST["email"]),addslashes($_POST["tel"]),"",true,"",6,true,$date_res_1,$_POST["newsletter"]);
        
        // Si ha anat bé, he d'enviar els mails corresponents
        if($ret>0)
        {
            $info_reserva = GetReservation($mysqli,$ret);
            $box = GetBox($mysqli,$info_reserva['box_id']);
            $userdata = GetUInfo($mysqli,$box['propietari']);
            $info_reserva['colmail']=$box['mail_aux'];
            
            if($info_reserva['data_res']!="0000-00-00 00:00:00" && $info_reserva['data_res_out']!="0000-00-00")
            {
                // Reserva demorada (s'ha de validar per part de l'operador per enviar l'enllaç de pagament)
                ConfirmReservation($mysqli,$num_reserva,1);
                if(!SendConfirmation2($mysqli,$info_reserva))
                {
                    error_log("Client mail error");
                }
                if(!SendConfirmation3($mysqli,$info_reserva))
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
                $dades_personals = addslashes($_POST["nom"]) . '<br>' . addslashes($_POST["email"]) . '<br>' . addslashes($_POST["tel"]) . '<br>' . addslashes($_POST["city"]) . '<br>' . $_POST["com"];

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
        
        echo $return;
    }
    else
    {
        echo -1;
    }
?>
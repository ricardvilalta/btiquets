<?php  

    header('Access-Control-Allow-Origin: *');
    include_once 'common.php';
    include_once '../php/funcions.php';
    include_once '../php/btdv_funcions.php';  
    sec_session_start('btiquets_session_id');

    global $mysqli,$zone,$admin_mail;

    if(isset($_POST["op"]))
    {        
        $ret = 0;
        switch($_POST["op"])
        {
            case 'insert_box':  // btiquets opt
            
                $date_str = "";
                if($_POST["edate"]!="")
                {
                    $edata = date_create_from_format('d-m-Y',$_POST["edate"]);
                    $date_str = date_format($edata,'Y-m-d');
                }                
            
                if(!isset($_POST["details"]))  $_POST["details"]="";
                if(!isset($_POST["use"]))      $_POST["use"]="";
                if(!isset($_POST["type"]))     $_POST["type"]="";
                if(!isset($_POST["quotes"]))   $_POST["quotes"]="";
                if(!isset($_POST["img"]))      $_POST["img"]="";
                if(!isset($_POST["n_min"]))    $_POST["n_min"]="";
                if(!isset($_POST["n_max"]))    $_POST["n_max"]="";
                if(!isset($_POST["lat"]))      $_POST["lat"]="";
                if(!isset($_POST["lng"]))      $_POST["lng"]="";
                if(!isset($_POST["date_str"])) $_POST["date_str"]="";
                if(!isset($_POST["etotal"]))   $_POST["etotal"]="";
                if(!isset($_POST["cellers"]))  $_POST["cellers"]="";
                if(!isset($_POST["patrimoni"]))$_POST["patrimoni"]="";
                if(!isset($_POST["visites"]))  $_POST["visites"]="";
                if(!isset($_POST["rutes"]))    $_POST["rutes"]="";
                if(!isset($_POST["destacat"])) $_POST["destacat"]="";
                if(!isset($_POST["nou"]))      $_POST["nou"]="";
                if(!isset($_POST["ocult"]))    $_POST["ocult"]="";
                if(!isset($_POST["no_online"]))$_POST["no_online"]="";
                if(!isset($_POST["special_img"]))   $_POST["special_img"]="";
                if(!isset($_POST["qr_img"]))   $_POST["qr_img"]="";
                if(!isset($_POST["edit_esceller"])) $_POST["edit_esceller"]="";
                if(!isset($_POST["min_price"])) $_POST["min_price"]="";
                if(!isset($_POST["name_es"]))   $_POST["name_es"]="";
                if(!isset($_POST["description_es"]))$_POST["description_es"]="";
                if(!isset($_POST["details_es"]))$_POST["details_es"]="";
                if(!isset($_POST["use_es"]))    $_POST["use_es"]="";
                if(!isset($_POST["quotes_es"])) $_POST["quotes_es"]="";
                if(!isset($_POST["price_es"]))  $_POST["price_es"]="";
                if(!isset($_POST["name_en"]))   $_POST["name_en"]="";
                if(!isset($_POST["description_en"]))$_POST["description_en"]="";
                if(!isset($_POST["details_en"])) $_POST["details_en"]="";
                if(!isset($_POST["use_en"]))     $_POST["use_en"]="";
                if(!isset($_POST["quotes_en"]))  $_POST["quotes_en"]="";
                if(!isset($_POST["price_en"]))   $_POST["price_en"]="";
                if(!isset($_POST["ppt"]))        $_POST["ppt"]="";
                if(!isset($_POST["collaboradors"])) $_POST["collaboradors"]="";
                if(!isset($_POST["productes"])) $_POST["productes"]="";
                if(!isset($_POST["activities"])) $_POST["activities"]="";
                if(!isset($_POST["col_mail"]))   $_POST["col_mail"]="";
                if(!isset($_POST["com_obl"]))    $_POST["com_obl"]="";
                if(!isset($_POST["com_aux"]))    $_POST["com_aux"]="";
                if(!isset($_POST["recordatori"]))       $_POST["recordatori"]="";
                if(!isset($_POST["recordatori_es"]))    $_POST["recordatori_es"]="";
                if(!isset($_POST["recordatori_en"]))    $_POST["recordatori_en"]="";
                if(!isset($_POST["xaccept"]))       $_POST["xaccept"]="";
                if(!isset($_POST["xaccept_description"]))   $_POST["xaccept_description"]="";
                if(!isset($_POST["xaccept_description_es"]))$_POST["xaccept_description_es"]="";
                if(!isset($_POST["xaccept_description_en"]))$_POST["xaccept_description_en"]="";
                if(!isset($_POST["taquilla_tancada"]))$_POST["taquilla_tancada"]="";
                if(!isset($_POST["portada_btiquets"]))$_POST["portada_btiquets"]="";
                if(!isset($_POST["enviament_id"])) $_POST["enviament_id"]="";
                if(!isset($_POST["pagament"])) $_POST["pagament"]="";
                if(!isset($_POST["enviament_str"])) $_POST["enviament_str"]="";
                            
                $ret = InsertBox($mysqli,intval($_POST["id"]),addslashes($_POST["name"]),addslashes($_POST["description"]),addslashes($_POST["details"]),addslashes($_POST["use"]),addslashes($_POST["price"]),addslashes($_POST["type"]),addslashes($_POST["quotes"]),addslashes($_POST["img"]),intval($_POST["activities"]),intval($_POST["n_min"]),intval($_POST["n_max"]),floatval($_POST["lat"]),floatval($_POST["destacat"]),intval($_POST["etype"]),$date_str,intval($_POST["etotal"]),intval($_POST["cellers"]),intval($_POST["patrimoni"]),intval($_POST["visites"]),intval($_POST["rutes"]),intval($_POST["destacat"]),intval($_POST["nou"]),intval($_POST["ocult"]),intval($_POST["no_online"]),addslashes($_POST["special_img"]),addslashes($_POST["qr_img"]),intval($_POST["edit_esceller"]),floatval($_POST["min_price"]),addslashes($_POST["name_es"]),addslashes($_POST["description_es"]),addslashes($_POST["details_es"]),addslashes($_POST["use_es"]),addslashes($_POST["quotes_es"]),addslashes($_POST["price_es"]),addslashes($_POST["name_en"]),addslashes($_POST["description_en"]),addslashes($_POST["details_en"]),addslashes($_POST["use_en"]),addslashes($_POST["quotes_en"]),addslashes($_POST["price_en"]),addslashes($_POST["ppt"]),addslashes($_POST["collaboradors"]),addslashes($_POST["sessions"]),addslashes($_POST["res_days"]),intval($_POST["close_time"]),intval($_POST["propietari"]),addslashes($_POST["sessio_unica"]),false,addslashes($_POST["col_mail"]),intval($_POST["com_obl"]),addslashes($_POST["com_aux"]),-1,addslashes($_POST["recordatori"]),addslashes($_POST["recordatori_es"]),addslashes($_POST["recordatori_en"]),intval($_POST["xaccept"]),addslashes($_POST["xaccept_description"]),addslashes($_POST["xaccept_description_es"]),addslashes($_POST["xaccept_description_en"]),intval($_POST["taquilla_tancada"]),intval($_POST["portada_btiquets"]),addslashes($_POST["productes"]),intval($_POST["enviament_id"]),intval($_POST["pagament"]),addslashes($_POST["enviament_str"]));
                break;

            case 'delete_box':  // btiquets opt
                $ret = DeleteBox($mysqli,intval($_POST["id"]));
                break;
            
            case 'copy_box':    // btiquets opt
                $ret = CopyBox($mysqli,intval($_POST["id"]));
                break;
            
            case 'insert_reservation':
                
                if(!isset($_POST["edit_data_r"]))      $_POST["edit_data_r"]="";                
                if(!isset($_POST["edit_data_e "]))      $_POST["edit_data_e"]="";
                if(!isset($_POST["edit_type"]))        $_POST["edit_type"]="";
                if(!isset($_POST["date_r_str"]))       $_POST["date_r_str"]="";
                if(!isset($_POST["date_e_str"]))       $_POST["date_e_str"]="";
                if(!isset($_POST["edit_name"]))        $_POST["edit_name"]="";
                if(!isset($_POST["edit_short_text"]))  $_POST["edit_short_text"]="";
                if(!isset($_POST["edit_addr1"]))       $_POST["edit_addr1"]="";
                if(!isset($_POST["edit_cp"]))          $_POST["edit_cp"]="";
            
                if($_POST["edit_data"]!="")
                {
                    $edata = date_create_from_format('d-m-Y',$_POST["edit_data"]);
                    $date_str = date_format($edata,'Y-m-d');
                }
            
                if($_POST["edit_data_r"]!="")
                {
                    $edata = date_create_from_format('d-m-Y H:i',$_POST["edit_data_r"]);
                    $date_r_str = date_format($edata,'Y-m-d H:i:s');
                }

                if($_POST["edit_data_e"]!="")
                {
                    $edata = date_create_from_format('d-m-Y',$_POST["edit_data_e"]);
                    $date_e_str = date_format($edata,'Y-m-d');
                }
            
                if(intval($_POST["reservation_id"])==-1)
                {
                    for($i=0;$i<intval($_POST["edit_number"]);$i++)
                    {
                        $num_reserva = GenerateReservation();
                        $ret = InsertReservation($mysqli,intval($_POST["reservation_id"]),intval($_POST["box_id"]),-1,addslashes($_POST["edit_comentaris"]),addslashes($_POST["quant_str"]),$num_reserva,round(floatval($_POST["edit_total"]),2),$date_str,intval($_POST["edit_state"]),intval($_POST["edit_qtotal"]),intval($_POST["edit_type"]),$date_r_str,$date_e_str,intval($_POST["edit_session"]),addslashes($_POST["edit_name"]),addslashes($_POST["edit_short_text"]),addslashes($_POST["edit_nom"]),addslashes($_POST["edit_email"]),addslashes($_POST["edit_tel"]),addslashes($_POST["edit_mun"]),false,"",6,false,null,intval($_POST["edit_newsletter"]),1,addslashes($_POST["edit_addr1"]),"",addslashes($_POST["edit_cp"]),$_POST["dades"],$_POST["genere"],$_POST["check_1"],$_POST["check_2"],$_POST["check_3"],$_POST["check_special"]);
                    }
                }
                else
                {
                    $num_reserva = addslashes($_POST["num_reserva"]);
                    $ret = $num_reserva;
                    $ret = InsertReservation($mysqli,intval($_POST["reservation_id"]),intval($_POST["box_id"]),-1,addslashes($_POST["edit_comentaris"]),addslashes($_POST["quant_str"]),$num_reserva,round(floatval($_POST["edit_total"]),2),$date_str,intval($_POST["edit_state"]),intval($_POST["edit_qtotal"]),intval($_POST["edit_type"]),$date_r_str,$date_e_str,intval($_POST["edit_session"]),addslashes($_POST["edit_name"]),addslashes($_POST["edit_short_text"]),addslashes($_POST["edit_nom"]),addslashes($_POST["edit_email"]),addslashes($_POST["edit_tel"]),addslashes($_POST["edit_mun"]),false,"",6,false,null,intval($_POST["edit_newsletter"]),1,addslashes($_POST["edit_addr1"]),"",addslashes($_POST["edit_cp"]),$_POST["dades"],$_POST["genere"],$_POST["check_1"],$_POST["check_2"],$_POST["check_3"],$_POST["check_special"]);
                }                                        
                
                break;
            
            case 'insert_reservation_extern':
                
                if(!isset($_POST["edit_data_r"]))      $_POST["edit_data_r"]="";                
                if(!isset($_POST["edit_data_e "]))     $_POST["edit_data_e"]="";
                if(!isset($_POST["edit_type"]))        $_POST["edit_type"]="";
                if(!isset($_POST["date_r_str"]))       $_POST["date_r_str"]="";
                if(!isset($_POST["date_e_str"]))       $_POST["date_e_str"]="";
                if(!isset($_POST["edit_name"]))        $_POST["edit_name"]="";
                if(!isset($_POST["edit_short_text"]))  $_POST["edit_short_text"]="";
                                            
                $date_str = date('Y-m-d');                
            
                if($_POST["edit_data_r"]!="")
                {
                    $edata = date_create_from_format('d-m-Y H:i',$_POST["edit_data_r"]);
                    $date_r_str = date_format($edata,'Y-m-d H:i:s');
                }
            
                if($_POST["edit_data_e"]!="")
                {
                    $edata = date_create_from_format('d-m-Y',$_POST["edit_data_e"]);
                    $date_e_str = date_format($edata,'Y-m-d');
                }
            
                $num_reserva = GenerateReservation();
                $ret = InsertReservation($mysqli,-1,intval($_POST["box_id"]),-1,addslashes($_POST["edit_comentaris"]),addslashes($_POST["quant_str"]),$num_reserva,round(floatval($_POST["edit_total"]),2),$date_str,intval($_POST["edit_state"]),intval($_POST["edit_qtotal"]),intval($_POST["edit_type"]),$date_r_str,$date_e_str,intval($_POST["edit_session"]),addslashes($_POST["edit_name"]),addslashes($_POST["edit_short_text"]),addslashes($_POST["edit_nom"]),addslashes($_POST["edit_email"]),addslashes($_POST["edit_tel"]),addslashes($_POST["edit_mun"]));
            
                $ret = $num_reserva;
                
                break;
            
            case 'send_reservation':    // btiquets opt
                $ret = SendReservationbtiquets($mysqli,intval($_POST["id"]));
                break;

            case 'send_reservation_array':      // btiquets opt
                $reslist = explode(';',$_POST["id"]);
                $ret = array();
                for($i=0;$i<count($reslist);$i++)
                {
                    if(intval($reslist[$i])>0)
                    {
                        $ret = SendReservationbtiquets($mysqli,intval($reslist[$i]));
                    }
                }
                break;
            
            case 'send_reservation_admin':    // btiquets opt
                $ret = SendReservationbtiquets($mysqli,intval($_POST["id"]),$admin_mail);
                break;
            
            case 'send_notification':    // btiquets opt
                $ret = SendNotifcationbtiquets($mysqli,intval($_POST["id"]));
                break;
            
            case 'delete_reservation':    // btiquets opt
                $ret = DeleteReservation($mysqli,intval($_POST["id"]));
                break;
            
            case 'delete_reservation_array':      // btiquets opt
                $reslist = explode(';',$_POST["id"]);
                $ret = array();
                for($i=0;$i<count($reslist);$i++)
                {
                    if(intval($reslist[$i])>0)
                    {
                        $ret = DeleteReservation($mysqli,intval($reslist[$i]));
                    }
                }
                break;
            
            case 'finish_reservation':
                $ret = FinishReservation(intval($_POST["id"]));
                break;
            
            case 'fact_reservation':
                $ret = FactReservation(intval($_POST["id"]),intval($_POST["val"]));
                break;
            
            case 'insert_all':  // btiquets opt           
                            
                if(!isset($_POST["name"]))   $_POST["name"]="";
                if(!isset($_POST["description"]))$_POST["description"]="";                
                if(!isset($_POST["name_es"]))   $_POST["name_es"]="";
                if(!isset($_POST["description_es"]))$_POST["description_es"]="";
                if(!isset($_POST["name_en"]))   $_POST["name_en"]="";
                if(!isset($_POST["description_en"]))$_POST["description_en"]="";
                if(!isset($_POST["mod"]))   $_POST["col_mail"]="";
                if(!isset($_POST["mod_es"]))   $_POST["col_mail"]="";
                if(!isset($_POST["mod_en"]))   $_POST["col_mail"]="";
                if(!isset($_POST["col_mail"]))   $_POST["col_mail"]="";
                            
                $ret = InsertHouse($mysqli,intval($_POST["id"]),addslashes($_POST["name"]),addslashes($_POST["poblacio"]),addslashes($_POST["mail"]),addslashes($_POST["tel"]),addslashes($_POST["web"]),addslashes($_POST["description"]),addslashes($_POST["mod"]),intval($_POST["type"]),intval($_POST["ocult"]),addslashes($_POST["name_es"]),addslashes($_POST["description_es"]),addslashes($_POST["name_en"]),addslashes($_POST["description_en"]),addslashes($_POST["mod_es"]),addslashes($_POST["mod_en"]),intval($_POST["propietari"]),addslashes($_POST["col_mail"]));
                break; 
            
            case 'delete_hotel':  // btiquets opt
                $ret = DeleteHouse($mysqli,intval($_POST["id"]));
                break;
            
            case 'copy_hotel':    // btiquets opt
                $ret = CopyHouse($mysqli,intval($_POST["id"]));
                break;
            
            case 'insert_producte':  // btiquets opt           
                            
                if(!isset($_POST["name"]))   $_POST["name"]="";
                if(!isset($_POST["description"]))$_POST["description"]="";                
                if(!isset($_POST["name_es"]))   $_POST["name_es"]="";
                if(!isset($_POST["description_es"]))$_POST["description_es"]="";
                if(!isset($_POST["name_en"]))   $_POST["name_en"]="";
                if(!isset($_POST["description_en"]))$_POST["description_en"]="";
                if(!isset($_POST["mod"]))   $_POST["col_mail"]="";
                if(!isset($_POST["mod_es"]))   $_POST["col_mail"]="";
                if(!isset($_POST["mod_en"]))   $_POST["col_mail"]="";
                if(!isset($_POST["col_mail"]))   $_POST["col_mail"]="";
                            
                $ret = InsertProducte($mysqli,intval($_POST["id"]),addslashes($_POST["name"]),"","","","",addslashes($_POST["description"]),addslashes($_POST["mod"]),0,intval($_POST["ocult"]),addslashes($_POST["name_es"]),addslashes($_POST["description_es"]),addslashes($_POST["name_en"]),addslashes($_POST["description_en"]),addslashes($_POST["mod_es"]),addslashes($_POST["mod_en"]),intval($_POST["propietari"]),addslashes($_POST["col_mail"]));
                break;   
            
            case 'delete_producte':  // btiquets opt
                $ret = DeleteProducte($mysqli,intval($_POST["id"]));
                break;
            
            case 'copy_producte':    // btiquets opt
                $ret = CopyProducte($mysqli,intval($_POST["id"]));
                break;
            
            case 'insert_enviament':  // btiquets opt
                            
                if(!isset($_POST["name"]))          $_POST["name"]="";
                if(!isset($_POST["description"]))   $_POST["description"]="";
                if(!isset($_POST["type"]))          $_POST["type"]="";
                if(!isset($_POST["deststr"]))       $_POST["deststr"]="";

                $ret = InsertEnviament($mysqli,intval($_POST["id"]),addslashes($_POST["name"]),addslashes($_POST["description"]),intval($_POST["type"]),addslashes($_POST["deststr"]),intval($_POST["propietari"]));
                break;   
            
            case 'delete_enviament':  // btiquets opt
                $ret = DeleteEnviament($mysqli,intval($_POST["id"]));
                break;
            
            case 'copy_enviament':    // btiquets opt
                $ret = CopyEnviament($mysqli,intval($_POST["id"]));
                break;                        
            
            case 'get_type_list':
                $ret = GetTypeList(true);
                break;
            
            case 'get_promo_list':
                $ret = GetPromoList();
                break;
            
            case 'get_reservation_list':
                $ret = GetReservationList($mysqli);
                break;
            
            case 'get_box_list':
                $ret = GetBoxListAdmin($mysqli,-1);
                break;
            
            case 'get_box_prices':    // btiquets opt
                $ret = GetBoxPrices($mysqli,$_POST["id"]);
                break;
            
            case 'get_box':
                $ret = GetBox($mysqli,$_POST["id"]);
                break;
            
            case 'delete_image':
                $path = "../boxes/box_" . $_POST["id"] . "/" . $_POST["path"];
                $ret = DeleteImage($path);
                break;                        
            
            case 'delete_logo_image':
                $path = "../boxes/" . $_POST["path"];
                $ret = DeleteImage($path);
                break;
            
            case 'delete_image_celler':
                $path = "../cellers/celler_" . $_POST["id"] . "/" . $_POST["path"];
                $ret = DeleteImage($path);
                break;
            
            case 'delete_image_col':
                $path = "../cols/col_" . $_POST["id"] . "/" . $_POST["path"];
                $ret = DeleteImage($path);
                break;
            
            case 'delete_image_rest':
                $path = "../rest/restaurant_" . $_POST["id"] . "/" . $_POST["path"];
                $ret = DeleteImage($path);
                break;
            
            case 'delete_image_allotj':
                $path = "../allotj/allotjament_" . $_POST["id"] . "/" . $_POST["path"];
                $ret = DeleteImage($path);
                break;
            
            case 'delete_image_producte':
                $path = "../productes/p_" . $_POST["id"] . "/" . $_POST["path"];
                $ret = DeleteImage($path);
                break;
            
            case 'sort':                
                $ret = SortTable($_POST["id_str"],$_POST["table"]);
                break;
            
            case 'confirmation':                
                $ret = ConfirmReservation($mysqli,$_POST["id"],$_POST["val"]);
                break;
            
            case 'check_confirmation':                
                $ret = CheckConfirmReservation($_POST["id"]);
                break;
            
            case 'edit_user':                
                $ret = EditUser($mysqli,$zone,$_POST["id"],$_POST["name"],$_POST["surnames"],$_POST["email"],$_POST["city"],$_POST["countrycode"],$_POST["tel"],1);
                break;
            
            case 'confirm_user':                
                $ret = ConfirmUser($_POST["id"]);
                break;
            
            case 'delete_user':                
                $ret = DeleteUser($mysqli,$_POST["id"],true);
                break;
            
            case 'edit_compte':                
                $ret = EditCompte($mysqli,$_POST["id"],$_POST["name"],$_POST["user"],$_POST["merchantcode"],$_POST["terminal"],$_POST["currency"],$_POST["key"],$_POST["url"],$_POST["btype_0"],$_POST["btype_1"],$_POST["btype_2"],$_POST["btype_3"],$_POST["btype_4"],$_POST["btype_5"],$_POST["btype_6"],$_POST["btype_7"],$_POST["mail"],addslashes($_POST["lopd"]),intval($_POST["bizum"]),intval($_POST["versio"]));
                break;
            
            case 'delete_compte':                
                $ret = DeleteCompte($mysqli,$_POST["id"]);
                break;

            case 'edit_servei':                

                if(intval($_POST["client"])==-1) {
                    $mydata = array();   
                    $mydata['nom_entitat']=addslashes($_POST["nom_entitat"]);
                    $mydata['nom_contacte']=addslashes($_POST["nom_contacte"]);
                    $mydata['tel']=addslashes($_POST["tel"]);
                    $mydata['mail']=addslashes($_POST["mail"]);
                    $mydata['adr_1']=addslashes($_POST["adr_1"]);
                    $mydata['cp']=addslashes($_POST["cp"]);
                    $mydata['ciutat']=addslashes($_POST["ciutat"]);
                    $mydata['pais']=addslashes($_POST["pais"]);
                    $mydata['nif']=addslashes($_POST["nif"]);
                    $mydata['genere']=intval($_POST["genere"]);
                    $mydata['propietari']=intval($_POST["propietari"]);
                    $clientid = InsertDBData("clients",$mydata,$_POST["id"]);
                }
                else {
                    $clientid = intval($_POST["client"]);
                }

                $mydata = array();   
                $mydata['client']=$clientid;
                $mydata['estat']=intval($_POST["estat"]);
                $mydata['pagament']=intval($_POST["pagament"]);
                $mydata['administrador']=intval($_POST["admin"]);
                $mydata['notes']=addslashes($_POST["notes"]);
                $mydata['activitat']=intval($_POST["activitat"]);
                $mydata['espai_1']=intval($_POST["espai1"]);
                $mydata['espai_2']=intval($_POST["espai2"]);
                $mydata['espai_3']=intval($_POST["espai3"]);
                $mydata['espai_4']=intval($_POST["espai4"]);
                $mydata['guia_1']=intval($_POST["guia1"]);
                $mydata['guia_2']=intval($_POST["guia2"]);
                $mydata['guia_3']=intval($_POST["guia3"]);
                $mydata['guia_4']=intval($_POST["guia4"]);
                $mydata['base_total']=floatval($_POST["base_total"]);
                $mydata['iva_total']=floatval($_POST["iva_total"]);
                $mydata['import_pagat']=floatval($_POST["import_pagat"]);
                $mydata['tipus_pagament']=intval($_POST["tipus_pagament"]);
                $mydata['tipus_servei']=intval($_POST["tipus_servei"]);
                $mydata['notes_pagament']=addslashes($_POST["notes_pagament"]);
                $mydata['propietari']=intval($_POST["propietari"]);
                $ret = InsertDBData("serveis",$mydata,$_POST["id"]);

                break;

            case 'delete_servei':
                $ret = DelDBData("serveis",intval($_POST["id"]));
                break;
            
            case 'copy_servei':
                //$ret = CopyGuia($mysqli,intval($_POST["id"]));
                break;

            case 'edit_guia':    
                $mydata = array();            
                $mydata['name']=addslashes($_POST["nom"]);
                $mydata['cognoms']=addslashes($_POST["cognom"]);
                $mydata['type']=intval($_POST["type"]);
                $mydata['propietari']=intval($_POST["propietari"]);
                $ret = InsertDBData("guies",$mydata,$_POST["id"]);
                break;

            case 'delete_guia':
                $ret = DelDBData("guies",intval($_POST["id"]));
                break;
            
            case 'copy_guia':
                //$ret = CopyGuia($mysqli,intval($_POST["id"]));
                break;

            case 'edit_preu':    
                $mydata = array();            
                $mydata['nom']=addslashes($_POST["nom"]);
                $mydata['descripcio']=addslashes($_POST["descripcio"]);
                $mydata['base']=floatval($_POST["base"]);
                $mydata['iva']=intval($_POST["iva"]);
                $mydata['propietari']=intval($_POST["propietari"]);
                $ret = InsertDBData("preus",$mydata,$_POST["id"]);
                break;

            case 'delete_preu':
                $ret = DelDBData("preus",intval($_POST["id"]));
                break;
            
            case 'copy_preu':
                //$ret = CopyGuia($mysqli,intval($_POST["id"]));
                break;

            case 'edit_client':    
                $mydata = array();            
                $mydata['nom_entitat']=addslashes($_POST["nom_entitat"]);
                $mydata['nom_contacte']=addslashes($_POST["nom_contacte"]);
                $mydata['tel']=addslashes($_POST["tel"]);
                $mydata['mail']=addslashes($_POST["mail"]);
                $mydata['adr_1']=addslashes($_POST["adr_1"]);
                $mydata['cp']=addslashes($_POST["cp"]);
                $mydata['ciutat']=addslashes($_POST["ciutat"]);
                $mydata['pais']=addslashes($_POST["pais"]);
                $mydata['nif']=addslashes($_POST["nif"]);
                $mydata['genere']=intval($_POST["genere"]);
                $mydata['propietari']=intval($_POST["propietari"]);
                $ret = InsertDBData("clients",$mydata,$_POST["id"]);
                break;

            case 'delete_client':
                $ret = DelDBData("clients",intval($_POST["id"]));
                break;
            
            case 'copy_client':
                //$ret = CopyGuia($mysqli,intval($_POST["id"]));
                break;

            case 'edit_espai':
                $mydata = array();            
                $mydata['nom']=addslashes($_POST["nom"]);
                $mydata['descripcio']=addslashes($_POST["descripcio"]);
                $mydata['estat']=intval($_POST["estat"]);
                $mydata['propietari']=intval($_POST["propietari"]);
                $ret = InsertDBData("espais",$mydata,$_POST["id"]);
                break;

            case 'delete_espai':
                $ret = DelDBData("espais",intval($_POST["id"]));
                break;
            
            case 'copy_espai':
                //$ret = CopyGuia($mysqli,intval($_POST["id"]));
                break;

            case 'edit_activitat':
                $mydata = array();            
                $mydata['nom']=addslashes($_POST["nom"]);
                $mydata['descripcio']=addslashes($_POST["descripcio"]);
                $mydata['espai']=intval($_POST["espai"]);
                $mydata['preu']=intval($_POST["preu"]);
                $mydata['tipus']=intval($_POST["tipus"]);
                $mydata['propietari']=intval($_POST["propietari"]);
                $ret = InsertDBData("activitats",$mydata,$_POST["id"]);
                break;

            case 'delete_activitat':
                $ret = DelDBData("activitats",intval($_POST["id"]));
                break;
            
            case 'copy_activitat':
                //$ret = CopyGuia($mysqli,intval($_POST["id"]));
                break;

            case 'edit_administrador':
                $mydata = array();            
                $mydata['nom']=addslashes($_POST["nom"]);
                $mydata['propietari']=intval($_POST["propietari"]);
                $ret = InsertDBData("administradors",$mydata,$_POST["id"]);
                break;

            case 'delete_administrador':
                $ret = DelDBData("administradors",intval($_POST["id"]));
                break;
            
            case 'copy_administrador':
                //$ret = CopyGuia($mysqli,intval($_POST["id"]));
                break;
            
            case 'get_user_list':                
                $ret = GetUsersInfo($mysqli);
                break;
            
            case 'edit_col':                
                $ret = EditCol($_POST["id"],$_POST["name"],$_POST["userid"]);
                break;
            
            case 'delete_col':                
                $ret = DeleteCol($_POST["id"]);
                break;
            
            case 'get_col_list':                
                $ret = GetColsInfo();                
                break;
            
            case 'get_session_list':                
                $ret = GetSessions($mysqli,$_POST["id"],$_POST["old"]);
                break;
            
            case 'insert_col_comment':                
                $ret = InsertColComment($_POST["id"],$_POST["comment"]);
                break;
            
            case 'insert_comment':                
                $ret = InsertComment($_POST["id"],$_POST["comment"]);
                break;
            
            case 'get_celler_visits':                
                $data = GetBox($mysqli,$_POST["id"]);
                $ret = decode_price($data['price'],false);
                break;
            
            case 'get_rest_menus':
                $boxes = explode(';',$_POST["id"]);
                $ret = array();
                for($i=0;$i<count($boxes);$i++)
                {
                    if($boxes[$i]!="")
                    {
                        $data = GetBox($mysqli,$boxes[$i]);
                        $subdata = decode_price($data['price']);
                        $ret[] = array('name'=>$data['name'],'modes'=>$subdata);
                    }
                }
                break;
            
            case 'get_text': 
                $ret = GetTranslationText();                
                break;
            
            case 'mini_images': 
                $boxes = scandir("../boxes");
                foreach($boxes as $box)
                {
                    MiniImage($box);
                }
                $ret = 1;
                break;
            
            case 'account_session':
                
                $_SESSION['account_id'] = $_POST["value"];
                $ret = $_POST["value"];
                break;

            case 'validar_reserva': 
                $ret = ValidateReservation($mysqli,$_POST["id"],$_POST["val"],addslashes($_POST["com"]));
                break;
            
            default:
                break;
        }
        
        echo json_encode($ret);
    }
?>
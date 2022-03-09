<?php
    $id = intval($_GET['id']);
    global $mysqli;
    global $lang;
    global $zone;    

    if($id>0)
    {   
        $sql="SELECT name,description,price,event_type,res_days,close_time,sessio_unica,ocult,url,propietari,mail_aux,name_es,description_es,name_en,description_en,price_es,price_en,com_obl,com_aux,collaboradors,recordatori,recordatori_es,recordatori_en,xaccept,xaccept_description,xaccept_description_es,xaccept_description_en,taquilla_tancada,portada_btiquets,productes,enviament_id,pagament,enviament_str FROM box_data WHERE id='$id'";
        
        $res = $mysqli->query($sql);
        $row = $res->fetch_row();
        $name = stripslashes($row[0]);
        $description = stripslashes($row[1]);
        $price_str = stripslashes($row[2]);
        $event_type = intval($row[3]);
        $res_days_str = stripslashes($row[4]);
        $close_time = intval($row[5]);
        $sessio_unica_id = intval($row[6]);
        $img = "";
        $special_img  = "";
        $qr_img = "";
        $ocult = intval($row[7]);
        $url = stripslashes($row[8]);
        $propietari = intval($row[9]);
        $col_mail = stripslashes($row[10]);
        $name_es = stripslashes($row[11]);
        $description_es = stripslashes($row[12]);
        $name_en = stripslashes($row[13]);
        $description_en = stripslashes($row[14]);
        $price_es_str = stripslashes($row[15]);
        $price_en_str = stripslashes($row[16]);
        $com_obl = intval($row[17]);
        $com_aux = stripslashes($row[18]);
        $hotel_str = stripslashes($row[19]);
        $recordatori = htmlspecialchars(stripslashes($row[20]));
        $recordatori_es = htmlspecialchars(stripslashes($row[21]));
        $recordatori_en = htmlspecialchars(stripslashes($row[22]));
        $xaccept = intval($row[23]);
        $xaccept_description = stripslashes($row[24]);
        $xaccept_description_es = stripslashes($row[25]);
        $xaccept_description_en = stripslashes($row[26]);
        $taquilla_tancada = intval($row[27]);
        $portada_btiquets = intval($row[28]);
        $producte_str = stripslashes($row[29]);
        $enviament_id = intval($row[30]);
        $pagament = intval($row[31]);
        $enviament_str = stripslashes($row[32]);
        
        $price_str_original = $price_str;
        $price_es_str_original = $price_es_str;
        $price_en_str_original = $price_en_str;
        
        // decodifico l'string de modalitats de preu
        $price_modalities = decode_price($price_str,true);
        $price_es_modalities = decode_price($price_es_str,true);
        $price_en_modalities = decode_price($price_en_str,true);
        
        // decodifico l'string de modalitats de preu original
        $price_modalities_original = decode_price($price_str_original,true);
        $price_es_modalities_original = decode_price($price_es_str_original,true);
        $price_en_modalities_original = decode_price($price_en_str_original,true);
        
        // decodifico l'string de disponibilitat
        $res_days = decode_res_days($res_days_str);   
        
        // decodifico l'string de d'allotjaments
        $hotel_list = decode_hotel_str($hotel_str);   
        
        // decodifico l'string de productes
        $producte_list = decode_producte_str($producte_str);
        
        // decodifico l'string d'enviaments
        $enviament_list = decode_enviament_str($enviament_str);
        
        // tb he d'agafar totes les imatges de la carpeta /boxes/box_id
        $imglist = GetFolderImages("../../boxes/box_" . $id);
        
        // recullo totes les sessions d'aquesta experiència
        date_default_timezone_set($zone);
        $date = date('Y-m-d');
        $sql="SELECT id,data,places,estat,antelacio,session_name,tarifes FROM sessions WHERE box_id='$id' AND data > '$date' ORDER BY data DESC";
        $sessions = array();
        $res = $mysqli->query($sql);
        while($row = $res->fetch_row())
        {
            if($row[1]=="0000-00-00 00:00:00")
            {
                $date_session = date('d-m-Y H:i');
            }
            else
            {
                $sdata = date_create_from_format('Y-m-d H:i:s',$row[1]);
                $date_session = date_format($sdata,'d-m-Y H:i');
            }
            
            $inscrits = GetReservationFromSession($mysqli,$row[0]);
            
            $sessions[] = array('id'=>$row[0],'data'=>$date_session,'places'=>$row[2],'estat'=>intval($row[3]),'antelacio'=>intval($row[4]),'inscrits'=>$inscrits,'session_name'=>addslashes($row[5]),'tarifes'=>$row[6]);
        }
        
        if($sessio_unica_id!="")
        {
            // recullo la sessió única d'aquesta experiència
            $sql="SELECT id,data,places,estat,antelacio,session_name FROM sessions WHERE id='$sessio_unica_id'";            
            $res = $mysqli->query($sql);
            $row = $res->fetch_row();
            if($row[0]=="0000-00-00 00:00:00")
            {
                $date_session = date('d-m-Y H:i');
            }
            else
            {
                $sdata = date_create_from_format('Y-m-d H:i:s',$row[1]);
                $date_session = date_format($sdata,'d-m-Y H:i');
            }
            $sessio_unica = array('id'=>$row[0],'data'=>$date_session,'places'=>$row[2],'estat'=>intval($row[3]),'antelacio'=>intval($row[4]),'session_name'=>stripslashes($row[5]));
        }
        else
        {
            $sessio_unica = array('id'=>-1,'data'=>"",'places'=>0,'estat'=>-1,'antelacio'=>24,'session_name'=>"");  
        }        
    }
    else
    {
        $name = "";
        $description = "";        
        $event_type = 0;
        $imglist = null;
        $price_modalities = null;        
        $price_modalities_original = null;
        $res_days = null;
        $close_time = 12;
        $img = "";
        $special_img  = "";
        $qr_img  = "";
        $ocult = 0;
        $url = "";
        $propietari = -1;
        $col_mail = "";
        $name_es = "";
        $description_es = "";
        $name_en = "";
        $description_en = "";
        $price_es_modalities = null;        
        $price_es_modalities_original = null;
        $price_en_modalities = null;        
        $price_en_modalities_original = null;
        $com_obl = false;
        $com_aux = "";
        $recordatori = "";
        $recordatori_es = "";
        $recordatori_en = "";
        $xaccept = false;
        $xaccept_description = "";
        $xaccept_description_es = "";
        $xaccept_description_en = "";
        $taquilla_tancada = 0;
        $portada_btiquets = 1;
        $enviament_id = -1;
        $pagament = 1;
        $enviament_str = "";
        
        $sessio_unica = array('id'=>-1,'data'=>"",'places'=>20,'estat'=>-1,'antelacio'=>24,'session_name'=>"");
    }

    $tipus_tarifa = 0;
    if($price_modalities!=null)
    {
        $tipus_tarifa = $price_modalities[0]['type'];
    }

    $ocupacio = GetReservationFromBox($mysqli,$id);
    $venuts = GetReservationFromBox_modalities($mysqli,$id,count($price_modalities));

    if($_SESSION['user_id']==$SUPERUSER)
    {
        if($propietari!=-1)
        {
            $compte = GetAccountInfo($mysqli,$propietari);
        }
        else
        {
            $compte = GetAccountfromUserInfo($mysqli,$_SESSION['user_id']);
        }
    }
    else
    {
        $compte = GetAccountfromUserInfo($mysqli,$_SESSION['user_id']);
    }    
    $uactivities = GetActivitiesfromUser($mysqli,$compte['id']);
    $disp_0 = $compte['btype_0']-$uactivities['btype_0']>0 ? $compte['btype_0']-$uactivities['btype_0'] : 0;
    $disp_1 = $compte['btype_1']-$uactivities['btype_1']>0 ? $compte['btype_1']-$uactivities['btype_1'] : 0;
    $disp_2 = $compte['btype_2']-$uactivities['btype_2']>0 ? $compte['btype_2']-$uactivities['btype_2'] : 0;
    $disp_3 = $compte['btype_3']-$uactivities['btype_3']>0 ? $compte['btype_3']-$uactivities['btype_3'] : 0;
    $disp_4 = $compte['btype_4']-$uactivities['btype_4']>0 ? $compte['btype_4']-$uactivities['btype_4'] : 0;
    $disp_5 = $compte['btype_5']-$uactivities['btype_5']>0 ? $compte['btype_5']-$uactivities['btype_5'] : 0;
    $disp_6 = $compte['btype_6']-$uactivities['btype_6']>0 ? $compte['btype_6']-$uactivities['btype_6'] : 0;
    $disp_7 = $compte['btype_7']-$uactivities['btype_7']>0 ? $compte['btype_7']-$uactivities['btype_7'] : 0;

    $uallotjaments = GetAllotjamentsfromUser($mysqli,$compte['id']);
    $uproductes = GetProductesfromUser($mysqli,$compte['id']);
    $uenviaments = GetEnviamentsfromUser($mysqli,$compte['id']);
?>

<script type="text/javascript">
        
    $(document).ready(function()
    {
        $(function () {
            'use strict';
            // Change this to the location of your server-side upload handler:
            var url = '/plugins/fileuploadmaster/server/php/';
            $('#fileupload_0').fileupload({
                url: url,
                formData: {
                    path: '<?php echo $rootfolder . "boxes/box_" . $id . "/"; ?>',
                    name: 'box_image_0.jpg',
                },
                dataType: 'json',
                cache: false,
                disableImageResize: /Android(?!.*Chrome)|Opera/
                    .test(window.navigator && navigator.userAgent),                
                imageCrop: false,
                imageMaxWidth: 1500,
                done: function (e, data) {
                    var str="";
                    str += '<li class="img_frame">';
                    str += '<div class="img_options"><a class="del_image"><?php echo translate("Elimina", $lang); ?></a></div>';
                    str += '<img width="100px" src="';
                    str = str + '<?php echo $rootfolder; ?>' + 'boxes/box_';
                    str += '<?php echo $id; ?>';
                    str += '/';
                    str += data.result.files[0].name;
                    str += '?nocache='
                    str += Math.random();
                    str += '" path="box_image_0.jpg">';
                    str += '</li>';
                    
                    $('#image_0').html(str);
                    $('#progress').hide();
                    
                    ResetEvents();
                },
                start: function (e, data) {
                    $('#progress').show();
                    $('#progress .progress-bar').css(
                        'width',0
                    );
                },
                progressall: function (e, data) {
                    var progress = parseInt(data.loaded / data.total * 100, 10);
                    $('#progress .progress-bar').css(
                        'width',
                        progress + '%'
                    );
                }
            });
            $('#fileupload_1').fileupload({
                url: url,
                formData: {
                    path: '<?php echo $rootfolder . "boxes/box_" . $id . "/"; ?>',
                    name: 'box_image_1.jpg',
                },
                dataType: 'json',
                cache: false,
                disableImageResize: /Android(?!.*Chrome)|Opera/
                    .test(window.navigator && navigator.userAgent),                
                imageCrop: false,
                imageMaxWidth: 1500,
                done: function (e, data) {
                    var str="";
                    str += '<li class="img_frame">';
                    str += '<div class="img_options"><a class="del_image"><?php echo translate("Elimina", $lang); ?></a></div>';
                    str += '<img width="100px" src="';
                    str = str + '<?php echo $rootfolder; ?>' + 'boxes/box_';
                    str += '<?php echo $id; ?>';
                    str += '/';
                    str += data.result.files[0].name;
                    str += '?nocache='
                    str += Math.random();
                    str += '" path="box_image_1.jpg">';
                    str += '</li>';
                    
                    $('#image_1').html(str);
                    $('#progress').hide();
                    
                    ResetEvents();
                },
                start: function (e, data) {
                    $('#progress').show();
                    $('#progress .progress-bar').css(
                        'width',0
                    );
                },
                progressall: function (e, data) {
                    var progress = parseInt(data.loaded / data.total * 100, 10);
                    $('#progress .progress-bar').css(
                        'width',
                        progress + '%'
                    );
                }
            });
            $('#fileupload_2').fileupload({
                url: url,
                formData: {
                    path: '<?php echo $rootfolder . "boxes/box_" . $id . "/"; ?>',
                    name: 'box_image_2.jpg',
                },
                dataType: 'json',
                cache: false,
                disableImageResize: /Android(?!.*Chrome)|Opera/
                    .test(window.navigator && navigator.userAgent),                
                imageCrop: false,
                imageMaxWidth: 1500,
                done: function (e, data) {
                    var str="";
                    str += '<li class="img_frame">';
                    str += '<div class="img_options"><a class="del_image"><?php echo translate("Elimina", $lang); ?></a></div>';
                    str += '<img width="100px" src="';
                    str = str + '<?php echo $rootfolder; ?>' + 'boxes/box_';
                    str += '<?php echo $id; ?>';
                    str += '/';
                    str += data.result.files[0].name;
                    str += '?nocache='
                    str += Math.random();
                    str += '" path="box_image_2.jpg">';
                    str += '</li>';
                    
                    $('#image_2').html(str);
                    $('#progress').hide();
                    
                    ResetEvents();
                },
                start: function (e, data) {
                    $('#progress').show();
                    $('#progress .progress-bar').css(
                        'width',0
                    );
                },
                progressall: function (e, data) {
                    var progress = parseInt(data.loaded / data.total * 100, 10);
                    $('#progress .progress-bar').css(
                        'width',
                        progress + '%'
                    );
                }
            });
            $('#fileupload_3').fileupload({
                url: url,
                formData: {
                    path: '<?php echo $rootfolder . "boxes/box_" . $id . "/"; ?>',
                    name: 'box_image_3.jpg',
                },
                dataType: 'json',
                cache: false,
                disableImageResize: /Android(?!.*Chrome)|Opera/
                    .test(window.navigator && navigator.userAgent),                
                imageCrop: false,
                imageMaxWidth: 1500,
                done: function (e, data) {
                    var str="";
                    str += '<li class="img_frame">';
                    str += '<div class="img_options"><a class="del_image"><?php echo translate("Elimina", $lang); ?></a></div>';
                    str += '<img width="100px" src="';
                    str = str + '<?php echo $rootfolder; ?>' + 'boxes/box_';
                    str += '<?php echo $id; ?>';
                    str += '/';
                    str += data.result.files[0].name;
                    str += '?nocache='
                    str += Math.random();
                    str += '" path="box_image_3.jpg">';
                    str += '</li>';
                    
                    $('#image_3').html(str);
                    $('#progress').hide();
                    
                    ResetEvents();
                },
                start: function (e, data) {
                    $('#progress').show();
                    $('#progress .progress-bar').css(
                        'width',0
                    );
                },
                progressall: function (e, data) {
                    var progress = parseInt(data.loaded / data.total * 100, 10);
                    $('#progress .progress-bar').css(
                        'width',
                        progress + '%'
                    );
                }
            });
        });                      
                               
        initialize();
        
        $('#save').one('click',function(){
            validate_box();
        });
        
        $('#cancel').one('click',function(){
            window.location.href = '/admin/3';
        });
        
        $('#edit_etype').change(function(){
            switch(parseInt($(this).val()))
            {
                case 0: //data única
                    $("#event_type_0").show();
                    $("#event_type_1").hide();
                    $("#event_type_2").hide();
                    $("#event_type_3").hide();
                    $("#event_type_4").hide();
                    $("#payment_mod").show();
                    $('#stock_group').hide();
                    break;
                case 1: //sessions calendari
                    $("#event_type_0").hide();
                    $("#event_type_1").show();
                    $("#event_type_2").hide();
                    $("#event_type_3").hide();
                    $("#event_type_4").hide();
                    $("#payment_mod").show();
                    $('#stock_group').hide();
                    break;
                case 2: //restaurants
                    $("#event_type_0").hide();
                    $("#event_type_1").hide();
                    $("#event_type_2").show();
                    $("#event_type_3").hide();
                    $("#event_type_4").hide();
                    $("#payment_mod").hide();
                    $('#stock_group').hide();
                    break;
                case 3: //suite allotjaments
                    $("#event_type_0").hide();
                    $("#event_type_1").hide();
                    $("#event_type_2").hide();
                    $("#event_type_3").show();
                    $("#event_type_4").hide();
                    $("#payment_mod").hide();
                    $('#stock_group').hide();
                    break;
                case 4: //productes simples
                    $("#event_type_0").hide();
                    $("#event_type_1").hide();
                    $("#event_type_2").hide();
                    $("#event_type_3").hide();
                    $("#event_type_4").hide();
                    $("#payment_mod").show();
                    $('#stock_group').show();
                    break;
                case 5: //productes avançats
                    $("#event_type_0").hide();
                    $("#event_type_1").hide();
                    $("#event_type_2").hide();
                    $("#event_type_3").hide();
                    $("#event_type_4").show();
                    $("#payment_mod").hide();
                    $('#stock_group').hide();
                    break;
                case 6: //data oberta
                    $("#event_type_0").hide();
                    $("#event_type_1").hide();
                    $("#event_type_2").hide();
                    $("#event_type_3").hide();
                    $("#event_type_4").hide();
                    $("#payment_mod").show();
                    $('#stock_group').hide();
                    break;
                case 7: //aportació voluntària
                    $("#event_type_0").hide();
                    $("#event_type_1").hide();
                    $("#event_type_2").hide();
                    $("#event_type_3").hide();
                    $("#event_type_4").hide();
                    $("#payment_mod").hide();
                    $('#stock_group').hide();
                    break;
            }
        });
                                
        $('#new_mod').click(function(){
            var str = 
                '<div class="mod_block">' +
                    '<div class="form-group">' +
                        '<input class="form-control mod_nom" placeholder="Nom de la modalitat - català"><br>' +
                        '<input class="form-control mod_nom_es" placeholder="Nom de la modalitat - castellà"><br>' +
                        '<input class="form-control mod_nom_en" placeholder="Nom de la modalitat - anglès">' +
                    '</div>' +
                    '<div class="form-group input-group">' +
                        '<span class="input-group-addon"><i class="fa fa-eur"></i>' +
                        '</span>' +
                        '<input type="text" class="form-control mod_preu" placeholder="Preu de la modalitat">' +
                    '</div>' +
                    '<div class="form-group input-group">' +
                        '<div class="col-sm-4">' +
                            '<label>Max per compra (-1 sense límit)</label><input type="number" class="form-control mod_max" value="-1">' +
                        '</div>' +
                        '<div class="col-sm-4">' +
                            '<label>Stock inicial</label><input type="number" class="form-control mod_stock">' +
                        '</div>' +
                        '<div class="col-sm-4">' +
                            '<label>Venuts</label><input disabled class="form-control inscrits" value="0">' +
                        '</div>' +
                    '</div>' +
                    '<div class="form-group input-group">' +
                        '<button class="btn btn-danger btn-xs del_mod">Borrar modalitat</button>' +
                    '</div>' +
                '</div>';
                
            $('#payment_mod').append(str);
            modality_event();
        });
        
        function modality_event() {
            
            if($('#edit_etype').val()==4)
            {
                $('#stock_group').show();
            }
            else
            {
                $('#stock_group').hide();
            }
            
            $('.del_mod').off('click');
            $('.del_mod').on('click',function(){
                $(this).parent().parent().remove();
            });
        }
        
        $('#new_multisession').click(function(){
            // Fer les noves sessions
            var datastr = $('#data_type_multi').val();
            datastr = datastr.replace(/, /g,",");
            multi = datastr.split(',');
            var str = "";
            if(multi.length==0)
            {
                alert("<?php echo translate("Has d'entrar primer les dates al calendari, i una hora, places i antelació per a totes les sessions", $lang); ?>");
            }
            else
            {
                for(var i=0;i<multi.length;i++)
                {
                    str += 
                    '<div del="0" sid="-1" class="session_block">' +
                        '<div class="form-group input-group">' +
                        '<div class="col-sm-6">' +
                            '<label><?php echo translate("Data", $lang); ?></label><input class="form-control sess_data datetime_input" placeholder="<?php echo translate("Data", $lang); ?>" value="' + multi[i] + ' ' + $('#time_type_multi').val() + '">' +
                        '</div>' +
                        '<div class="col-sm-3">' +
                            '<label><?php echo translate("Places", $lang); ?></label><input type="number" class="form-control sess_places" placeholder="<?php echo translate("Places", $lang); ?>" value=' + $('#places_type_multi').val() + '>' +
                        '</div>' +
                        '<div class="col-sm-3">' +
                            '<label><?php echo translate("Antelació", $lang); ?></label><input type="number" class="form-control sess_antelacio" placeholder="<?php echo translate("Antelació", $lang); ?>" value=' + $('#antelacio_type_multi').val() + '>' +
                        '</div>' +                    
                        '</div>' +
                        '<div class="form-group">' +
                            '<label>Tarifes</label>' +
                            '<select class="form-control sess_tarifes" multiple>' +
                                '<option value="-1" selected>Totes</option>' +
                                "<?php
                                for($i=0;$i<count($price_modalities);$i++)
                                {
                                    $preu = $price_modalities[$i];
                                    echo "<option value=" . $i . ">" . $preu['name'] . ' (' . $preu['price'] . '€)' . "</option>";
                                }?>"
                            + '</select>' +
                        '</div>' +
                        '<div class="form-group">' +
                            '<label>Etiqueta de la sessió</label>' +
                            '<input class="form-control sess_name" value="' + $('#session_name_multi').val() + '">' +
                            '<p class="help-block">Descriptiu opcional de la sessió</p>' +
                        '</div>' +
                        '<div class="form-group input-group">' +
                            '<div class="col-sm-6">' +                       
                                '<label>Inscrits</label><input disabled class="form-control inscrits" class="form-control" value="0">' +
                            '</div>' +
                        '</div>' +                    
                    '</div>' +
                    '<div class="form-group input-group">' +
                        '<button class="btn btn-danger btn-xs del_session">Borrar sessió</button>' +
                    '</div>';                            
                }            
                $('#session_mod').append(str);
                session_event();

                // Borrar el multidatepicker
                //$('#data_type_multi').val("");
                $('.multidatetime_input').multiDatesPicker('resetDates', 'picked'); 
            }
        });
        
        $('#new_session').click(function(){
            var str = 
                '<div del="0" sid="-1" class="session_block">' +
                    '<div class="form-group input-group">' +
                    '<div class="col-sm-6">' +
                        '<label><?php echo translate("Data", $lang); ?></label><input class="form-control sess_data datetime_input" placeholder="<?php echo translate("Data", $lang); ?>">' +
                    '</div>' +
                    '<div class="col-sm-3">' +
                        '<label><?php echo translate("Places", $lang); ?></label><input type="number" class="form-control sess_places" value="20" placeholder="<?php echo translate("Places", $lang); ?>">' +
                    '</div>' +
                    '<div class="col-sm-3">' +
                        '<label><?php echo translate("Antelació", $lang); ?></label><input type="number" class="form-control sess_antelacio" value="24" placeholder="<?php echo translate("Antelació", $lang); ?>">' +
                    '</div>' +                    
                    '</div>' +
                    '<div class="form-group">' +
                        '<label>Tarifes</label>' +
                        '<select class="form-control sess_tarifes" multiple>' +
                            '<option value="-1" selected>Totes</option>' +
                            "<?php
                            for($i=0;$i<count($price_modalities);$i++)
                            {
                                $preu = $price_modalities[$i];
                                echo '<option value=' . $i . '>' . $preu['name'] . ' (' . $preu['price'] . '€)' . '</option>';
                            }?>"
                        + '</select>' +
                    '</div>' +
                     '<div class="form-group">' +
                        '<label>Etiqueta de la sessió</label>' +
                        '<input class="form-control sess_name">' +
                        '<p class="help-block">Descriptiu opcional de la sessió</p>' +
                    '</div>' +
                    '<div class="form-group input-group">' +
                        '<div class="col-sm-6">' +                       
                            '<label>Inscrits</label><input disabled class="form-control inscrits" class="form-control" value="0">' +
                        '</div>' +
                    '</div>' +                    
                '</div>' +
                '<div class="form-group input-group">' +
                    '<button class="btn btn-danger btn-xs del_session">Borrar sessió</button>' +
                '</div>';            
                
            $('#session_mod').append(str);
            session_event();
        });                                    

        function session_event() {
            $('.del_session').off('click');
            $('.del_session').on('click',function(){
                //$(this).parent().parent().remove();
                if($(this).parent().prev().find('.inscrits').val()>0)
                {
                    alert('<?php echo translate("No es pot eliminar una sessió amb reserves actives", $lang); ?>');
                }
                else
                {
                    $(this).parent().prev().attr("del","1");
                    $(this).parent().prev().find(':input').attr("disabled", true);
                    $(this).parent().attr("disabled", true);
                    $(this).parent().prev().css("opacity",".3");
                    $(this).parent().css("opacity",".3");
                }
            });
            
            $(function() {
                jQuery.datetimepicker.setLocale('ca');
                $( ".datetime_input" ).datetimepicker({                  
                    format:'d-m-Y H:i',
                    dayOfWeekStart:1
                });                
                $( ".datetime_input" ).removeClass("datetime_input");
            }); 
        }
        
        function ResetEvents()
        {                            
            $('.del_image').off('click');
            $('.del_image').on('click',function(){
                
                $.ajax({  
                    type: "POST",  
                    url: "/php/server_actions.php",  
                    data: {
                        op:"delete_image",
                        path:$(this).parent().next().attr('path'),
                        id:<?php echo $id; ?>
                    },
                });
                    
                $(this).parent().parent().remove();
            });
            
            $('.img_frame').hover(function(){
                $(this).find('.img_options').show();
                $(this).find('img').fadeTo(0,0.2);
                
                },function(){
                    $(this).find('.img_options').hide();
                    $(this).find('img').fadeTo(0,1);
            });
        } 
        
        function initialize()
        {
            <?php

            for($i=0;$i<4;$i++)
            {?>            
                var img = new Image();
                img.onload = function()
                {
                    var pos = this.src.lastIndexOf('/')+1;
                    var pos_f = this.src.lastIndexOf('?');
                    var len = pos_f-pos;
                    var imgname = this.src.substr(pos,len);
                    var str="";
                    str += '<li class="img_frame">';
                    str += '<div class="img_options">';
                    str += '</a><a class="del_image"><?php echo translate("Elimina", $lang); ?></a></div>';
                    str += '<img width="100px" src="';
                    str += this.src;
                    str += '" path="';
                    str += imgname;
                    str += '">';
                    str += '</li>';
                    
                    aux = '#image_' + '<?php echo $i; ?>';
                    $(aux).append(str);
                    ResetEvents();
                }
                img.src = '<?php echo $rootfolder . "boxes/box_" . $id . "/box_image_" . $i . ".jpg?nocache=" . rand(); ?>';
            <?php
            } 
            
            for($i=0;$i<count($price_modalities);$i++)
            {
                $preu = $price_modalities[$i];
                $preu_es = $price_es_modalities[$i];
                $preu_en = $price_en_modalities[$i];
                ?>
                var str = 
                '<div class="mod_block">' +
                    '<div class="form-group">' +
                        '<input class="form-control mod_nom" placeholder="Nom de la modalitat - català" value="' + "<?php echo $preu['name']; ?>" + '"><br>' +
                    '<input class="form-control mod_nom_es" placeholder="Nom de la modalitat - castellà" value="' + "<?php echo $preu_es['name']; ?>" + '"><br>' +
                    '<input class="form-control mod_nom_en" placeholder="Nom de la modalitat - anglès" value="' + "<?php echo $preu_en['name']; ?>" + '">' +
                    '</div>' +
                    '<div class="form-group input-group">' +
                        '<span class="input-group-addon"><i class="fa fa-eur"></i>' +
                        '</span>' +
                        '<input type="text" class="form-control mod_preu" placeholder="Preu de la modalitat" value="' + '<?php echo $preu['price']; ?>' + '">' +
                    '</div>' +
                    '<div class="form-group input-group">' +
                        '<div class="col-sm-4">' +
                            '<label>Max per compra (-1 sense límit)</label><input type="number" class="form-control mod_max" value="' + '<?php echo $preu['max']; ?>' + '">' +
                        '</div>' +
                        '<div class="col-sm-4">' +
                            '<label>Stock inicial</label><input type="number" class="form-control mod_stock" value="' + '<?php echo $preu['stock']; ?>' + '">' +
                        '</div>' +
                        '<div class="col-sm-4">' +
                            '<label>Venuts</label><input disabled class="form-control inscrits" value="' + '<?php echo $venuts[$i]; ?>' + '">' +
                        '</div>' +
                    '</div>' +
                    '<div class="form-group input-group">' +
                        '<button class="btn btn-danger btn-xs del_mod">Borrar modalitat</button>' +
                    '</div>' +
                '</div>';
            
                $('#payment_mod').append(str);
            <?php
            }?>
                            
            modality_event();
            
            <?php
            for($i=0;$i<count($sessions);$i++)
            {
                $sessio = $sessions[$i];
                if($sessio['tarifes']=="")  
                {
                    $sessio_tarifes= array("-1");
                }
                else
                {
                    $sessio_tarifes = explode(":", $sessio['tarifes']);
                    $sessio_tarifes = array_diff($sessio_tarifes, array(""));
                }
                ?>
                var str = 
                '<div del="0" sid="' + '<?php echo $sessio['id']; ?>' +'" class="session_block">' +
                    '<div class="form-group input-group">' +
                    '<div class="col-sm-6">' +
                        '<label>' + '<?php echo translate("Data", $lang); ?>' + '</label><input <?php if($sessio['inscrits']>0) echo 'disabled'; ?> class="form-control sess_data datetime_input" value="' + '<?php echo $sessio['data']; ?>' + '" placeholder="<?php echo translate("Data", $lang); ?>">' +
                    '</div>' +
                    '<div class="col-sm-3">' +
                        '<label>' + '<?php echo translate("Places", $lang); ?>' + '</label><input type="number" class="form-control sess_places" value="' + '<?php echo $sessio['places']; ?>' + '" placeholder="<?php echo translate("Places", $lang); ?>">' +
                    '</div>' +
                    '<div class="col-sm-3">' +
                        '<label>' + '<?php echo translate("Antelació", $lang); ?>' + '</label><input type="number" class="form-control sess_antelacio" value="' + '<?php echo $sessio['antelacio']; ?>' + '" placeholder="<?php echo translate("Antelació", $lang); ?>">' +
                    '</div>' +                    
                    '</div>' + 
                    '<div class="form-group">' +
                        '<label>Tarifes</label>' +
                        '<select class="form-control sess_tarifes" multiple>' +
                            '<option value="-1" <?php if(in_array('-1',$sessio_tarifes)) echo "selected"; ?>>Totes</option>' +
                            "<?php
                            for($j=0;$j<count($price_modalities);$j++)
                            {
                                $auxstr="";
                                $preu = $price_modalities[$j];
                                if(in_array($j,$sessio_tarifes)) $auxstr='selected';
                                echo '<option value=' . $j . ' '.$auxstr.'>' . $preu['name'] . ' (' . $preu['price'] . '€)' . '</option>';
                            }?>"
                        + '</select>' +
                    '</div>' +
                    '<div class="form-group">' +
                        '<label>Etiqueta de la sessió</label>' +
                        '<input class="form-control sess_name" value="' + '<?php echo $sessio["session_name"]; ?>' + '">' +
                        '<p class="help-block">Descriptiu opcional de la sessió</p>' +
                    '</div>' +
                    '<div class="form-group input-group">' +
                        '<div class="col-sm-6">' +                       
                            '<label>Inscrits</label><input disabled class="form-control inscrits" class="form-control" value="<?php echo $sessio['inscrits']; ?>">' +
                        '</div>' +
                    '</div>' +                    
                '</div>' +
                '<div class="form-group input-group">' +
                    '<button class="btn btn-danger btn-xs del_session">Borrar sessió</button>' +
                '</div>';            
            
                $('#session_mod').append(str);
                
            <?php
            }?>
                        
            session_event();
            
            $('.multidatetime_input').multiDatesPicker({
                dateFormat: "dd-mm-yy",
                minDate: 0,
                firstDay: 1,
                dayNamesMin: ["Dg", "Dl", "Dm", "Dx", "Dj", "Dv", "Ds" ],
                monthNamesShort: [ "Gen", "Feb", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Des" ],
                monthNames: [ "Gener", "Febrer", "Març", "Abril", "Maig", "Juny", "Juliol", "Agost", "Setembre", "Octubre", "Novembre", "Desembre" ],
            });  
            $.datepicker._selectDateOverload = $.datepicker._selectDate;
            $.datepicker._selectDate = function (id, dateStr) {
              var target = $(id);
              var inst = this._getInst(target[0]);
              inst.inline = true;
              $.datepicker._selectDateOverload(id, dateStr);
              inst.inline = false;
              if (target[0].multiDatesPicker != null) {
                target[0].multiDatesPicker.changed = false;
              } else {
                target.multiDatesPicker.changed = false;
              }
              this._updateDatepicker(inst);
            };
            
            jQuery('.time_input').datetimepicker({
                datepicker:false,
                format:'H:i'
            });
            
            switch(<?php echo $event_type; ?>)
            {                                    
                case 0: //data única
                    $("#event_type_0").show();
                    $("#event_type_1").hide();
                    $("#event_type_2").hide();
                    $("#event_type_3").hide();
                    $("#event_type_4").hide();
                    $("#payment_mod").show();
                    $('#stock_group').hide();
                    break;
                case 1: //sessions calendari
                    $("#event_type_0").hide();
                    $("#event_type_1").show();
                    $("#event_type_2").hide();
                    $("#event_type_3").hide();
                    $("#event_type_4").hide();
                    $("#payment_mod").show();
                    $('#stock_group').hide();
                    break;
                case 2: //restaurants
                    $("#event_type_0").hide();
                    $("#event_type_1").hide();
                    $("#event_type_2").show();
                    $("#event_type_3").hide();
                    $("#event_type_4").hide();
                    $("#payment_mod").hide();
                    $('#stock_group').hide();
                    break;
                case 3: //suite allotjaments
                    $("#event_type_0").hide();
                    $("#event_type_1").hide();
                    $("#event_type_2").hide();
                    $("#event_type_3").show();
                    $("#event_type_4").hide();
                    $("#payment_mod").hide();
                    $('#stock_group').hide();
                    break;
                case 4: //productes simples
                    $("#event_type_0").hide();
                    $("#event_type_1").hide();
                    $("#event_type_2").hide();
                    $("#event_type_3").hide();
                    $("#event_type_4").hide();
                    $("#payment_mod").show();
                    $('#stock_group').show();
                    break;   
                case 5: //productes avançats
                    $("#event_type_0").hide();
                    $("#event_type_1").hide();
                    $("#event_type_2").hide();
                    $("#event_type_3").hide();
                    $("#event_type_4").show();
                    $("#payment_mod").hide();
                    $('#stock_group').hide();
                    break;
                case 6: //data oberta
                    $("#event_type_0").hide();
                    $("#event_type_1").hide();
                    $("#event_type_2").hide();
                    $("#event_type_3").hide();
                    $("#event_type_4").hide();
                    $("#payment_mod").show();
                    $('#stock_group').hide();
                    break;
                case 7: //aportació voluntària
                    $("#event_type_0").hide();
                    $("#event_type_1").hide();
                    $("#event_type_2").hide();
                    $("#event_type_3").hide();
                    $("#event_type_4").hide();
                    $("#payment_mod").hide();
                    $('#stock_group').hide();
                    break;
            }
        }


        function validate_box()
        {            
            $('#edit_title').val()=="" ? $('#edit_title').parent().addClass('has-error') : $('#edit_title').parent().removeClass('has-error');
            
            if($('#edit_title').val()!="")
            {                
                var price_str = "";
                var price_es_str = "";
                var price_en_str = "";
                $('.mod_block').each(function(){
                    if($(this).find('.mod_nom').val()!="" && $(this).find('.mod_preu').val()!="")
                    {
                        price_str += $(this).find('.mod_nom').val();
                        price_str += ':';
                        price_str += $(this).find('.mod_preu').val();
                        price_str += ':-1:';
                        price_str += parseInt($(this).find('.mod_max').val());
                        price_str += '::';
                        price_str += parseInt($('#tipus_tarifa').val());
                        price_str += ':';
                        price_str += parseInt($(this).find('.mod_stock').val());
                        price_str += ';';
                        
                        price_es_str += $(this).find('.mod_nom_es').val();
                        price_es_str += ':';
                        price_es_str += $(this).find('.mod_preu').val();
                        price_es_str += ':-1:';
                        price_es_str += parseInt($(this).find('.mod_max').val());
                        price_es_str += '::';
                        price_es_str += parseInt($('#tipus_tarifa').val());
                        price_es_str += ':';
                        price_es_str += parseInt($(this).find('.mod_stock').val());
                        price_es_str += ';';
                        
                        price_en_str += $(this).find('.mod_nom_en').val();
                        price_en_str += ':';
                        price_en_str += $(this).find('.mod_preu').val();
                        price_en_str += ':-1:';
                        price_en_str += parseInt($(this).find('.mod_max').val());
                        price_en_str += '::';
                        price_en_str += parseInt($('#tipus_tarifa').val());
                        price_en_str += ':';
                        price_en_str += parseInt($(this).find('.mod_stock').val());
                        price_en_str += ';';
                    }
                });
                                
                var only_session_str = "";
                if($('#data_type_0').val()!="" && $('#places_type_0').val()!="")
                {                   
                    only_session_str += '0%';
                    only_session_str += $('#id_type_0').val();
                    only_session_str += '%';
                    only_session_str += $('#data_type_0').val();
                    only_session_str += '%';
                    only_session_str += $('#places_type_0').val();
                    only_session_str += '%1%';
                    only_session_str += $('#antelacio_type_0').val();
                    only_session_str += '%';
                    only_session_str += $('#name_type_0').val();
                    only_session_str += '%';
                }
                
                var session_str = "";
                $('.session_block').each(function(){
                    if($(this).find('.sess_data').val()!="")
                    {
                        var values = $(this).find('.sess_tarifes').val();
                        var tar_str = "-1:";
                        if(values!=null)
                        {
                            if(values.length>0)
                            {
                                tar_str = "";
                                for(i=0;i<values.length;i++){
                                    tar_str += values[i];
                                    tar_str += ":"
                                }
                            }
                        }
                        
                        session_str += $(this).attr("del");
                        session_str += '%';
                        session_str += $(this).attr("sid");
                        session_str += '%';
                        session_str += $(this).find('.sess_data').val();
                        session_str += '%';
                        session_str += $(this).find('.sess_places').val();
                        session_str += '%1%';
                        session_str += $(this).find('.sess_antelacio').val();
                        session_str += '%';
                        session_str += $(this).find('.sess_name').val();
                        session_str += '%';
                        session_str += tar_str;
                        session_str += ';';
                    }
                });
                
                var reservation_str = "";
                $('.reservation_block').each(function(){
                    reservation_str += $(this).find('.day_data').val();
                    reservation_str += '%';
                    reservation_str += $(this).find('.day_data').prop('checked')==true?1:0;
                    reservation_str += '%';
                    reservation_str += $(this).find('.tarifa_data').val();
                    reservation_str += '%';
                    reservation_str += $(this).find('.places_data').val();
                    reservation_str += ';';
                });
                
                var all_str = "";
                $('.hotel-group').each(function(){
                    if($(this).find('input').prop('checked')==true)
                    {
                        all_str += $(this).find('input').val();
                        all_str += ';';
                    }
                });
                
                var productes_str = "";
                $('.producte-group').each(function(){
                    if($(this).find('input').prop('checked')==true)
                    {
                        productes_str += $(this).find('input').val();
                        productes_str += ';';
                    }
                });
                
                var pagament_value = 0;
                pagament_value += ($('#pagament_1').prop('checked')?1:0);
                pagament_value += ($('#pagament_2').prop('checked')?2:0);
                
                var enviament_str = "";
                $('.enviament-subgroup').each(function(){
                    if($(this).find('input').prop('checked')==true)
                    {
                        if(enviament_str!="")
                        {
                            enviament_str += ';';
                        }
                        enviament_str += $(this).find('input').val();
                    }
                });
                
                <?php
                if($_SESSION['user_id']==$SUPERUSER)
                {?>
                    prop_id = $('#edit_compte').val();
                <?php
                }
                else 
                {?>
                    prop_id = <?php echo $compte["id"];?>
                <?php
                }?>
                
                
                $.ajax({  
                    type: "POST",  
                    url: "/php/server_actions.php",
                    data: {
                        op:"insert_box",
                        id:'<?php echo $id; ?>',
                        name:$('#edit_title').val(),                        
                        description:$('#edit_description').val(),
                        name_es:$('#edit_title_es').val(),                        
                        description_es:$('#edit_description_es').val(),
                        name_en:$('#edit_title_en').val(),                    
                        description_en:$('#edit_description_en').val(),
                        etype:$('#edit_etype').val(),
                        edate:"",
                        price:price_str,
                        price_es:price_es_str,
                        price_en:price_en_str,
                        sessio_unica:only_session_str,
                        sessions:session_str,
                        res_days:reservation_str,
                        close_time:$('#edit_close_time').val(),
                        propietari:prop_id,
                        details:"",
                        use:"",
                        ocult:$('#edit_actiu').prop('checked')?0:1,
                        col_mail:$('#edit_col_mail').val(),
                        com_obl:$('#com_obl').prop('checked')?1:0,
                        com_aux:$('#com_aux').val(),
                        collaboradors:all_str,
                        productes:productes_str,
                        enviament_id:$('input[name=env-group]:checked').val(),
                        enviament_str:enviament_str,
                        recordatori:$('#edit_recordatori').val(),
                        recordatori_es:$('#edit_recordatori_es').val(),
                        recordatori_en:$('#edit_recordatori_en').val(),
                        xaccept:$('#xaccept').prop('checked')?1:0,
                        xaccept_description:$('#edit_xaccept').val(),
                        xaccept_description_es:$('#edit_xaccept_es').val(),
                        xaccept_description_en:$('#edit_xaccept_en').val(),
                        taquilla_tancada:$('#edit_taquilla_tancada').prop('checked')?1:0,
                        portada_btiquets:$('#edit_portada_btiquets').prop('checked')?1:0,
                        pagament: pagament_value,
                    },
                }).success(function(ret)
                {
                    window.location.href = '/admin/3';
                });
            }
            else
            {   
                $('#save').one('click',function(){
                    validate_box();
                });
            }
        }
    });
</script>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Edita la taquilla</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="col-lg-9">
                    <?php
                    if($id==-1)
                    {
                        echo "<h4>" . "Nova taquilla" . "</h4>";
                    }
                    else
                    {
                        echo "<h4>" . $name . "</h4>";
                    }?>
                </div>
                
                <div style="text-align:right">
                    <button id="save" class="btn btn-success"><?php echo translate('Guardar', $lang); ?></button>
                    <button id="cancel" class="btn btn-warning"><?php echo translate('Cancel·lar', $lang); ?></button>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-6">
                        <div>
                            <div class="form-group">
                                <label>Actiu</label>
                                <input id="edit_actiu" type="checkbox" <?php if($ocult==0) echo 'checked'; ?>>
                            </div>
                            <div class="form-group">
                                <label>Taquilla tancada</label>
                                <input id="edit_taquilla_tancada" type="checkbox" <?php if($taquilla_tancada==1) echo 'checked'; ?>>
                            </div>
                            <div class="form-group">
                                <label>Portada BTiquets</label>
                                <input id="edit_portada_btiquets" type="checkbox" <?php if($portada_btiquets==1) echo 'checked'; ?>>
                            </div>
                            <?php
                            if($_SESSION['user_id']==$SUPERUSER)
                            {
                                $comptes = GetAccountsInfo($mysqli);
                            ?>
                            <div class="form-group">
                                <label>Compte</label>
                                <select id="edit_compte" class="form-control">
                                    <?php
                                    foreach($comptes as $compte)
                                    {?>
                                    <option value='<?php echo $compte["id"]; ?>' <?php if($propietari==$compte["id"]) echo 'selected="selected"'; ?>><?php echo $compte['nom']; ?></option>
                                    <?php 
                                    }?>
                                </select>
                            </div> 
                            <?php
                            }?>
                            <div class="form-group">
                                <label>Tipus de venda</label>
                                <select id="edit_etype" class="form-control">
                                    <?php 
                                    if($disp_0>0 || $event_type==0)
                                    {?>
                                    <option value="0" <?php if($event_type==0) echo 'selected="selected"'; ?>><?php echo translate("Sessió única", $lang); ?></option>
                                    <?php 
                                    }
                                    if($disp_1>0 || $event_type==1)
                                    {?>
                                    <option value="1" <?php if($event_type==1) echo 'selected="selected"'; ?>><?php echo translate("Sessions múltiples", $lang); ?></option>
                                    <?php 
                                    }
                                    if($disp_2>0 || $event_type==2)
                                    {?>
                                    <option value="2" <?php if($event_type==2) echo 'selected="selected"'; ?>><?php echo translate("Restaurant (sense pagament)", $lang); ?></option>
                                    <?php 
                                    }
                                    if($disp_3>0 || $event_type==3)
                                    {?>
                                    <option value="3" <?php if($event_type==3) echo 'selected="selected"'; ?>><?php echo translate("Suite allotjaments", $lang); ?></option>
                                    <?php 
                                    }
                                    if($disp_4>0 || $event_type==4)
                                    {?>
                                    <option value="4" <?php if($event_type==4) echo 'selected="selected"'; ?>><?php echo translate("Productes simples", $lang); ?></option>
                                    <?php 
                                    }
                                    if($disp_5>0 || $event_type==5)
                                    {?>
                                    <option value="5" <?php if($event_type==5) echo 'selected="selected"'; ?>><?php echo translate("Productes avançats", $lang); ?></option>
                                    <?php 
                                    }
                                    if($disp_6>0 || $event_type==6)
                                    {?>
                                    <option value="6" <?php if($event_type==6) echo 'selected="selected"'; ?>><?php echo translate("Data oberta", $lang); ?></option>
                                    <?php 
                                    }
                                    if($disp_7>0 || $event_type==7)
                                    {?>
                                    <option value="7" <?php if($event_type==7) echo 'selected="selected"'; ?>><?php echo translate("Aportació voluntària", $lang); ?></option>
                                    <?php 
                                    }?>
                                </select>
                            </div> 
                            <div class="form-group">
                                <label>Url de la taquilla</label>
                                <input readonly="readonly" class="form-control" value="<?php echo $server . 'event/' . $url; ?>"> 
                                <p class="help-block">català</p>
                                <input readonly="readonly" class="form-control" value="<?php echo $server . 'event/es/' . $url; ?>"> 
                                <p class="help-block">castellano</p>
                                <input readonly="readonly" class="form-control" value="<?php echo $server . 'event/en/' . $url; ?>"> 
                                <p class="help-block">english</p>
                            </div>
                            <div class="form-group">
                                <label>Nom de la taquilla</label>
                                <input id="edit_title" class="form-control" value="<?php echo $name; ?>">
                                <p class="help-block">català</p>
                                <input id="edit_title_es" class="form-control" value="<?php echo $name_es; ?>">
                                <p class="help-block">castellano</p>
                                <input id="edit_title_en" class="form-control" value="<?php echo $name_en; ?>">
                                <p class="help-block">english</p>
                            </div>
                            <div class="form-group">
                                <label>Descripció de la taquilla</label>
                                <textarea id="edit_description" class="form-control" rows="3"><?php echo $description; ?></textarea>
                                <p class="help-block">català</p>
                                <textarea id="edit_description_es" class="form-control" rows="3"><?php echo $description_es; ?></textarea>
                                <p class="help-block">castellano</p>
                                <textarea id="edit_description_en" class="form-control" rows="3"><?php echo $description_en; ?></textarea>
                                <p class="help-block">english</p>
                            </div>
                            <div class="form-group">
                                <label>Instruccions post-reserva (punt de trobada, etc)</label>
                                <input id="edit_recordatori" class="form-control" value="<?php echo $recordatori; ?>">
                                <p class="help-block">català</p>
                                <input id="edit_recordatori_es" class="form-control" value="<?php echo $recordatori_es; ?>">
                                <p class="help-block">castellano</p>
                                <input id="edit_recordatori_en" class="form-control" value="<?php echo $recordatori_en; ?>">
                                <p class="help-block">english</p>
                            </div>
                            <div class="form-group">
                                <label>Camp comentaris obligatori</label>
                                <input id="com_obl" type="checkbox" <?php if($com_obl==1) echo 'checked'; ?>>
                                <input id="com_aux" class="form-control" value="<?php echo $com_aux; ?>">
                                <p class="help-block">Canviar nom del camp comentaris</p>   
                            </div>
                            <div class="form-group">
                                <label>Camp Accepto addicional obligatori</label>
                                <input id="xaccept" type="checkbox" <?php if($xaccept==1) echo 'checked'; ?>>
                                <p class="help-block">No es podrà finalitzar la compra sense aquesta l'acceptació</p>
                                <textarea id="edit_xaccept" class="form-control" rows="3"><?php echo $xaccept_description; ?></textarea>
                                <p class="help-block">català</p>
                                <textarea id="edit_xaccept_es" class="form-control" rows="3"><?php echo $xaccept_description_es; ?></textarea>
                                <p class="help-block">castellano</p>
                                <textarea id="edit_xaccept_en" class="form-control" rows="3"><?php echo $xaccept_description_en; ?></textarea>
                                <p class="help-block">english</p>
                            </div>
                        </div>
                        <div class="form-group" style="display: flex;">    
                            <div class="col-lg-5">
                                <label><?php echo translate("Imatge principal", $lang); ?></label>
                                <!-- The fileinput-button span is used to style the file input field as button -->
                                <div>
                                    <span class="btn btn-success fileinput-button">
                                        <i class="glyphicon glyphicon-plus"></i>
                                        <span><?php echo translate('Selecciona', $lang); ?></span>
                                        <!-- The file input field used as target for the file upload widget -->
                                        <input id="fileupload_0" type="file" name="files">
                                    </span>
                                </div>
                            </div>
                            <div id="image_0" class="image_frame_list"></div>
                        </div>                        
                        <div class="form-group" style="display: flex;">
                            <div class="col-lg-5">
                                <label><?php echo translate("Imatge secundària 1", $lang); ?></label>
                                <div>
                                    <!-- The fileinput-button span is used to style the file input field as button -->
                                    <span class="btn btn-success fileinput-button">
                                        <i class="glyphicon glyphicon-plus"></i>
                                        <span><?php echo translate('Selecciona', $lang); ?></span>
                                        <!-- The file input field used as target for the file upload widget -->
                                        <input id="fileupload_1" type="file" name="files">
                                    </span>
                                </div>
                            </div>
                            <div id="image_1" class="image_frame_list"></div>
                        </div>
                        <div class="form-group" style="display: flex;">
                            <div class="col-lg-5">
                                <label><?php echo translate("Imatge secundària 2", $lang); ?></label>
                                <div>
                                    <!-- The fileinput-button span is used to style the file input field as button -->
                                    <span class="btn btn-success fileinput-button">
                                        <i class="glyphicon glyphicon-plus"></i>
                                        <span><?php echo translate('Selecciona', $lang); ?></span>
                                        <!-- The file input field used as target for the file upload widget -->
                                        <input id="fileupload_2" type="file" name="files">
                                    </span>
                                </div>
                            </div>
                            <div id="image_2" class="image_frame_list"></div>
                        </div>
                        <div class="form-group" style="display: flex;">
                            <div class="col-lg-5">
                                <label><?php echo translate("Imatge secundària 3", $lang); ?></label>
                                <div>
                                    <!-- The fileinput-button span is used to style the file input field as button -->
                                    <span class="btn btn-success fileinput-button">
                                        <i class="glyphicon glyphicon-plus"></i>
                                        <span><?php echo translate('Selecciona', $lang); ?></span>
                                        <!-- The file input field used as target for the file upload widget -->
                                        <input id="fileupload_3" type="file" name="files">
                                    </span>
                                </div>
                            </div>
                            <div id="image_3" class="image_frame_list"></div>
                        </div>
<!--
                        <ul id="image_list" class="image_frame_list">                
                        </ul>
-->                        
                    </div>                    
                    <!-- /.col-lg-6 (nested) -->
                    <div class="col-lg-6">                        
                        <div id="payment_mod">
                            <h2>Modalitats de preus</h2>
                            <div class="form-group">
                                <select id="tipus_tarifa" class="form-control">
                                    <option value="0" <?php if($tipus_tarifa==0) echo 'selected="selected"'; ?>><?php echo translate("Tarifes complementàries (es poden seleccionar de tots els tipus)", $lang); ?></option>
                                    <option value="1" <?php if($tipus_tarifa==1) echo 'selected="selected"'; ?>><?php echo translate("Tarifes excloents (només se'n podrà adquirir d'un tipus)", $lang); ?></option>
                                </select>
                            </div>
                            <div class="form-group">
                                <button id="new_mod" class="btn btn-primary">Afegir modalitat</button>
                            </div>
                        </div>
                        <div id="event_type_0">
                            <h2>Sessió</h2>
                            <input id="id_type_0" type="hidden" value="<?php echo $sessio_unica['id']; ?>">
                            <div class="form-group input-group">
                                <div class="col-sm-6">
                                    <label>Data</label><input id="data_type_0" class="form-control datetime_input" value="<?php echo $sessio_unica['data']; ?>" placeholder="<?php echo translate("Data", $lang); ?>">                                    
                                </div>
                                <div class="col-sm-3">
                                    <label><?php echo translate("Places", $lang); ?></label>
                                    <input type="number" id="places_type_0" class="form-control" value="<?php echo $sessio_unica['places']; ?>" placeholder="<?php echo translate("Places", $lang); ?>">
                                </div>
                                <div class="col-sm-3">
                                    <label><?php echo translate("Antelació", $lang); ?></label>
                                    <input type="number" id="antelacio_type_0" class="form-control" value="<?php echo $sessio_unica['antelacio']; ?>" placeholder="<?php echo translate("Antelació", $lang); ?>">
                                </div>                                
                            </div>
                            <div class="form-group">
                                <label>Etiqueta de la sessió</label>
                                <input class="form-control" id="name_type_0" value="<?php echo $sessio_unica['session_name']; ?>">
                                <p class="help-block">Descriptiu opcional de la sessió</p>
                            </div>
                            <div class="form-group input-group">
                                <div class="col-sm-6">                                    
                                    <label>Inscrits</label><input disabled class="form-control inscrits" value="<?php echo $ocupacio; ?>">
                                </div>
                            </div>
                        </div>
                        <div id="event_type_1">
                            <h2>Sessions</h2>
                            
                            <div class="form-group input-group">
                                <div class="col-sm-3">
                                    <label>Dates</label><input id="data_type_multi" class="form-control multidatetime_input" placeholder="<?php echo translate("Dates", $lang); ?>">
                                </div>                                
                                <div class="col-sm-3">
                                    <label>Hora</label><input id="time_type_multi" class="form-control time_input" placeholder="<?php echo translate("Hora", $lang); ?>">
                                </div>
                                <div class="col-sm-3">
                                    <label><?php echo translate("Places", $lang); ?></label>
                                    <input type="number" id="places_type_multi" class="form-control" placeholder="<?php echo translate("Places", $lang); ?>">
                                </div>
                                <div class="col-sm-3">
                                    <label><?php echo translate("Antelació", $lang); ?></label>
                                    <input type="number" id="antelacio_type_multi" class="form-control" placeholder="<?php echo translate("Antelació", $lang); ?>">
                                </div>                                
                            </div>
                            <div class="form-group">
                                <label>Etiqueta de la sessió</label>
                                <input id="session_name_multi" class="form-control">
                                <p class="help-block">Descriptiu opcional de la sessió (substitueix l'hora de la sessió)</p>
                            </div>
                            <div class="form-group">
                                <button id="new_multisession" class="btn btn-primary">Afegir múltiples sessions</button>
                            </div>
                            
                            <div id="session_mod">                                                            
                            <div class="form-group">
                                <button id="new_session" class="btn btn-primary">Afegir sessió</button>
                            </div>
                            </div>
                        </div>
                        <div id="event_type_2">
                            <h2>Disponibilitat i places</h2>
                            <div class="form-group">
                                <div style="vertical-align:middle" class="reservation_block col-lg-12">
                                    <div class="checkbox col-lg-5">
                                        <label>
                                            <input class="day_data" type="checkbox" value="1" <?php if($res_days[1]['act']==1) echo 'checked'; ?>><?php echo translate("Dilluns migdia", $lang); ?>
                                        </label>
                                    </div>
                                    <div class="col-lg-4">
                                        <select class="tarifa_data form-control">
                                            <option value="0" <?php if($res_days[1]['tarifa']==0) echo 'selected="selected"'; ?>><?php echo translate("Tarifa A", $lang); ?></option>
                                            <option value="1" <?php if($res_days[1]['tarifa']==1) echo 'selected="selected"'; ?>><?php echo translate("Tarifa B", $lang); ?></option>
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <input type="number" class="form-control places_data" value="<?php echo $res_days[1]['places']; ?>">
                                    </div>
                                </div>
                                <div style="vertical-align:middle" class="reservation_block col-lg-12">
                                    <div class="checkbox col-lg-5">
                                        <label>
                                            <input class="day_data" type="checkbox" value="11" <?php if($res_days[11]['act']==1) echo 'checked'; ?>><?php echo translate("Dilluns nit", $lang); ?>
                                        </label>
                                    </div>
                                    <div class="col-lg-4">
                                        <select class="tarifa_data form-control">
                                            <option value="0" <?php if($res_days[11]['tarifa']==0) echo 'selected="selected"'; ?>><?php echo translate("Tarifa A", $lang); ?></option>
                                            <option value="1" <?php if($res_days[11]['tarifa']==1) echo 'selected="selected"'; ?>><?php echo translate("Tarifa B", $lang); ?></option>
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <input type="number" class="form-control places_data" value="<?php echo $res_days[11]['places']; ?>">
                                    </div>
                                </div>
                                <div style="vertical-align:middle" class="reservation_block col-lg-12">
                                    <div class="checkbox col-lg-5">
                                        <label>
                                            <input class="day_data" type="checkbox" value="2" <?php if($res_days[2]['act']==1) echo 'checked'; ?>><?php echo translate("Dimarts migdia", $lang); ?>
                                        </label>
                                    </div>
                                    <div class="col-lg-4">
                                        <select class="tarifa_data form-control">
                                            <option value="0" <?php if($res_days[2]['tarifa']==0) echo 'selected="selected"'; ?>><?php echo translate("Tarifa A", $lang); ?></option>
                                            <option value="1" <?php if($res_days[2]['tarifa']==1) echo 'selected="selected"'; ?>><?php echo translate("Tarifa B", $lang); ?></option>
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <input type="number" class="form-control places_data" value="<?php echo $res_days[2]['places']; ?>">
                                    </div>
                                </div>
                                <div style="vertical-align:middle" class="reservation_block col-lg-12">
                                    <div class="checkbox col-lg-5">
                                        <label>
                                            <input class="day_data" type="checkbox" value="12" <?php if($res_days[12]['act']==1) echo 'checked'; ?>><?php echo translate("Dimarts nit", $lang); ?>
                                        </label>
                                    </div>
                                    <div class="col-lg-4">
                                        <select class="tarifa_data form-control">
                                            <option value="0" <?php if($res_days[12]['tarifa']==0) echo 'selected="selected"'; ?>><?php echo translate("Tarifa A", $lang); ?></option>
                                            <option value="1" <?php if($res_days[12]['tarifa']==1) echo 'selected="selected"'; ?>><?php echo translate("Tarifa B", $lang); ?></option>
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <input type="number" class="form-control places_data" value="<?php echo $res_days[12]['places']; ?>">
                                    </div>
                                </div>
                                <div style="vertical-align:middle" class="reservation_block col-lg-12">
                                    <div class="checkbox col-lg-5">
                                        <label>
                                            <input class="day_data" type="checkbox" value="3" <?php if($res_days[3]['act']==1) echo 'checked'; ?>><?php echo translate("Dimecres migdia", $lang); ?>
                                        </label>
                                    </div>
                                    <div class="col-lg-4">
                                        <select class="tarifa_data form-control">
                                            <option value="0" <?php if($res_days[3]['tarifa']==0) echo 'selected="selected"'; ?>><?php echo translate("Tarifa A", $lang); ?></option>
                                            <option value="1" <?php if($res_days[3]['tarifa']==1) echo 'selected="selected"'; ?>><?php echo translate("Tarifa B", $lang); ?></option>
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <input type="number" class="form-control places_data" value="<?php echo $res_days[3]['places']; ?>">
                                    </div>
                                </div>
                                <div style="vertical-align:middle" class="reservation_block col-lg-12">
                                    <div class="checkbox col-lg-5">
                                        <label>
                                            <input class="day_data" type="checkbox" value="13" <?php if($res_days[13]['act']==1) echo 'checked'; ?>><?php echo translate("Dimecres nit", $lang); ?>
                                        </label>
                                    </div>
                                    <div class="col-lg-4">
                                        <select class="tarifa_data form-control">
                                            <option value="0" <?php if($res_days[13]['tarifa']==0) echo 'selected="selected"'; ?>><?php echo translate("Tarifa A", $lang); ?></option>
                                            <option value="1" <?php if($res_days[13]['tarifa']==1) echo 'selected="selected"'; ?>><?php echo translate("Tarifa B", $lang); ?></option>
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <input type="number" class="form-control places_data" value="<?php echo $res_days[13]['places']; ?>">
                                    </div>
                                </div>
                                <div style="vertical-align:middle" class="reservation_block col-lg-12">
                                    <div class="checkbox col-lg-5">
                                        <label>
                                            <input class="day_data" type="checkbox" value="4" <?php if($res_days[4]['act']==1) echo 'checked'; ?>><?php echo translate("Dijous migdia", $lang); ?>
                                        </label>
                                    </div>
                                    <div class="col-lg-4">
                                        <select class="tarifa_data form-control">
                                            <option value="0" <?php if($res_days[4]['tarifa']==0) echo 'selected="selected"'; ?>><?php echo translate("Tarifa A", $lang); ?></option>
                                            <option value="1" <?php if($res_days[4]['tarifa']==1) echo 'selected="selected"'; ?>><?php echo translate("Tarifa B", $lang); ?></option>
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <input type="number" class="form-control places_data" value="<?php echo $res_days[4]['places']; ?>">
                                    </div>
                                </div>
                                <div style="vertical-align:middle" class="reservation_block col-lg-12">
                                    <div class="checkbox col-lg-5">
                                        <label>
                                            <input class="day_data" type="checkbox" value="14" <?php if($res_days[14]['act']==1) echo 'checked'; ?>><?php echo translate("Dijous nit", $lang); ?>
                                        </label>
                                    </div>
                                    <div class="col-lg-4">
                                        <select class="tarifa_data form-control">
                                            <option value="0" <?php if($res_days[14]['tarifa']==0) echo 'selected="selected"'; ?>><?php echo translate("Tarifa A", $lang); ?></option>
                                            <option value="1" <?php if($res_days[14]['tarifa']==1) echo 'selected="selected"'; ?>><?php echo translate("Tarifa B", $lang); ?></option>
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <input type="number" class="form-control places_data" value="<?php echo $res_days[14]['places']; ?>">
                                    </div>
                                </div>
                                <div style="vertical-align:middle" class="reservation_block col-lg-12">
                                    <div class="checkbox col-lg-5">
                                        <label>
                                            <input class="day_data" type="checkbox" value="5" <?php if($res_days[5]['act']==1) echo 'checked'; ?>><?php echo translate("Divendres migdia", $lang); ?>
                                        </label>
                                    </div>
                                    <div class="col-lg-4">
                                        <select class="tarifa_data form-control">
                                            <option value="0" <?php if($res_days[5]['tarifa']==0) echo 'selected="selected"'; ?>><?php echo translate("Tarifa A", $lang); ?></option>
                                            <option value="1" <?php if($res_days[5]['tarifa']==1) echo 'selected="selected"'; ?>><?php echo translate("Tarifa B", $lang); ?></option>
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <input type="number" class="form-control places_data" value="<?php echo $res_days[5]['places']; ?>">
                                    </div>
                                </div>
                                <div style="vertical-align:middle" class="reservation_block col-lg-12">
                                    <div class="checkbox col-lg-5">
                                        <label>
                                            <input class="day_data" type="checkbox" value="15" <?php if($res_days[15]['act']==1) echo 'checked'; ?>><?php echo translate("Divendres nit", $lang); ?>
                                        </label>
                                    </div>
                                    <div class="col-lg-4">
                                        <select class="tarifa_data form-control">
                                            <option value="0" <?php if($res_days[15]['tarifa']==0) echo 'selected="selected"'; ?>><?php echo translate("Tarifa A", $lang); ?></option>
                                            <option value="1" <?php if($res_days[15]['tarifa']==1) echo 'selected="selected"'; ?>><?php echo translate("Tarifa B", $lang); ?></option>
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <input type="number" class="form-control places_data" value="<?php echo $res_days[15]['places']; ?>">
                                    </div>
                                </div>
                                <div style="vertical-align:middle" class="reservation_block col-lg-12">
                                    <div class="checkbox col-lg-5">
                                        <label>
                                            <input class="day_data" type="checkbox" value="6" <?php if($res_days[6]['act']==1) echo 'checked'; ?>><?php echo translate("Dissabte migdia", $lang); ?>
                                        </label>
                                    </div>
                                    <div class="col-lg-4">
                                        <select class="tarifa_data form-control">
                                            <option value="0" <?php if($res_days[6]['tarifa']==0) echo 'selected="selected"'; ?>><?php echo translate("Tarifa A", $lang); ?></option>
                                            <option value="1" <?php if($res_days[6]['tarifa']==1) echo 'selected="selected"'; ?>><?php echo translate("Tarifa B", $lang); ?></option>
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <input type="number" class="form-control places_data" value="<?php echo $res_days[6]['places']; ?>">
                                    </div>
                                </div>
                                <div style="vertical-align:middle" class="reservation_block col-lg-12">
                                    <div class="checkbox col-lg-5">
                                        <label>
                                            <input class="day_data" type="checkbox" value="16" <?php if($res_days[16]['act']==1) echo 'checked'; ?>><?php echo translate("Dissabte nit", $lang); ?>
                                        </label>
                                    </div>
                                    <div class="col-lg-4">
                                        <select class="tarifa_data form-control">
                                            <option value="0" <?php if($res_days[16]['tarifa']==0) echo 'selected="selected"'; ?>><?php echo translate("Tarifa A", $lang); ?></option>
                                            <option value="1" <?php if($res_days[16]['tarifa']==1) echo 'selected="selected"'; ?>><?php echo translate("Tarifa B", $lang); ?></option>
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <input type="number" class="form-control places_data" value="<?php echo $res_days[16]['places']; ?>">
                                    </div>
                                </div>
                                <div style="vertical-align:middle" class="reservation_block col-lg-12">
                                    <div class="checkbox col-lg-5">
                                        <label>
                                            <input class="day_data" type="checkbox" value="7" <?php if($res_days[7]['act']==1) echo 'checked'; ?>><?php echo translate("Diumenge migdia", $lang); ?>
                                        </label>
                                    </div>
                                    <div class="col-lg-4">
                                        <select class="tarifa_data form-control">
                                            <option value="0" <?php if($res_days[7]['tarifa']==0) echo 'selected="selected"'; ?>><?php echo translate("Tarifa A", $lang); ?></option>
                                            <option value="1" <?php if($res_days[7]['tarifa']==1) echo 'selected="selected"'; ?>><?php echo translate("Tarifa B", $lang); ?></option>
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <input type="number" class="form-control places_data" value="<?php echo $res_days[7]['places']; ?>">
                                    </div>
                                </div>
                                <div style="vertical-align:middle" class="reservation_block col-lg-12">
                                    <div class="checkbox col-lg-5">
                                        <label>
                                            <input class="day_data" type="checkbox" value="17" <?php if($res_days[17]['act']==1) echo 'checked'; ?>><?php echo translate("Diumenge nit", $lang); ?>
                                        </label>
                                    </div>
                                    <div class="col-lg-4">
                                        <select class="tarifa_data form-control">
                                            <option value="0" <?php if($res_days[17]['tarifa']==0) echo 'selected="selected"'; ?>><?php echo translate("Tarifa A", $lang); ?></option>
                                            <option value="1" <?php if($res_days[17]['tarifa']==1) echo 'selected="selected"'; ?>><?php echo translate("Tarifa B", $lang); ?></option>
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <input type="number" class="form-control places_data" value="<?php echo $res_days[17]['places']; ?>">
                                    </div>
                                </div>
                                
                                <div class="form-group col-lg-6">
                                    <label>Tancament</label>
                                    <input type="number" id="edit_close_time" class="form-control" value="<?php echo $close_time; ?>">
                                    <p class="help-block">Nombre d'hores prèvies al servei (migdia: 14h / nit: 21h)</p>
                                </div>
                                
                                <div class="form-group col-lg-12">
                                    <label>Mail notificacions</label>
                                    <input type="text" id="edit_col_mail" class="form-control" value="<?php echo $col_mail; ?>">
                                    <p class="help-block">Mail per atendre les sol·licituds de reserva</p>
                                </div>
                                
                            </div>
                        </div>
                        <div id="event_type_3">
                            <h2>Allotjaments</h2>
                            <div class="form-group input-group col-lg-12">
                                <div class="col-lg-12">
                                    <?php
                                    foreach($uallotjaments as $aitem)
                                    {?>
                                        <div class="hotel-group checkbox">
                                            <label>
                                                <input type="checkbox" value="<?php echo $aitem['id']; ?>" <?php if($hotel_list[$aitem['id']]['active']==true) echo "checked"; ?>><?php echo $aitem['name']; ?>
                                            </label>
                                        </div>
                                    <?php 
                                    }
                                    ?>
                                </div>                           
                            </div>
                        </div>
                        <div id="event_type_4">
                            <h2>Productes</h2>
                            <div class="form-group input-group col-lg-12">
                                <div class="col-lg-12">
                                    <?php
                                    foreach($uproductes as $aitem)
                                    {?>
                                        <div class="producte-group checkbox">
                                            <label>
                                                <input type="checkbox" value="<?php echo $aitem['id']; ?>" <?php if($producte_list[$aitem['id']]['active']==true) echo "checked"; ?>><?php echo $aitem['name']; ?>
                                            </label>
                                        </div>
                                    <?php 
                                    }
                                    ?>
                                </div>                           
                            </div>
                            <h2>Enviament</h2>
                            <div class="form-group input-group col-lg-12">
                                <div class="col-lg-12">                                    
                                    <div class="enviament-group checkbox">
                                        <label>
                                            <input type="radio" style="width: 23px;margin-left: -22px;" name="env-group" value="0" <?php if($enviament_id==0) echo "checked"; ?>>Sense enviament
                                        </label>
                                    </div>
                                    <div class="enviament-group checkbox">
                                        <label>
                                            <input type="radio" style="width: 23px;margin-left: -22px;" name="env-group" value="-1" <?php if($enviament_id==-1) echo "checked"; ?>>Enviament gratuït
                                        </label>
                                    </div>
                                    <div class="enviament-group checkbox">
                                        <label>
                                            <input type="radio" style="width: 23px;margin-left: -22px;" name="env-group" value="-2" <?php if($enviament_id==-2) echo "checked"; ?>>Opcions d'enviament
                                        </label>
                                    </div>
                                    <?php
                                    foreach($uenviaments as $enviament)
                                    {?>
                                        <div class="enviament-group enviament-subgroup checkbox">
                                            <label>
                                                <input type="checkbox" style="width: 23px;margin-left: -22px;" id="<?php echo 'env_'.$enviament['id']; ?>" value="<?php echo $enviament['id']; ?>" <?php if($enviament_list[$enviament['id']]['active']==true) echo "checked"; ?>><?php echo $enviament['name']; ?>
                                            </label>
                                        </div>
                                    <?php 
                                    }
                                    ?>
                                </div>
                            </div>
                            <h2>Pagament</h2>
                            <div class="form-group input-group col-lg-12">
                                <div class="col-lg-12">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" id="pagament_1" value="1" <?php if(($pagament & 1)==1) echo "checked"; ?>>TPV Virtual
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox"id="pagament_2"  value="2" <?php if(($pagament & 2)==2) echo "checked"; ?>>Transferència
                                        </label>
                                    </div>
                                </div>                           
                            </div>
                        </div>
                    </div>
                    <!-- /.col-lg-6 (nested) -->
                </div>
                <!-- /.row (nested) -->
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
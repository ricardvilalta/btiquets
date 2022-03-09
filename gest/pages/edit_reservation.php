<?php  
    $id = intval($_GET['id']);
    global $mysqli;
    global $lang;
    global $zone;
    $date_execution = null;
    $date_session = $time_session = "";

    if($id>0)
    {
        $sql="SELECT ref,user_id,comentaris,quantitat,total,box_id,data,confirmat,col_comentaris,quant_total,tipus,data_executada,session_id,nom,descripcio,data_reserva,regal,res_nom,res_mail,res_tel,res_mun,newsletter,pagament,res_adr_1,res_adr_2,res_cp,dades,genere,check_1,check_2,check_3,check_special,validat FROM reserva WHERE id='$id'";
        $res = $mysqli->query($sql);
        $row = $res->fetch_row();
        $ref = $row[0];
        $user_id = $row[1];        
        $comentaris = $row[2];
        $quantitat = $row[3];
        $total = floatval($row[4]);
        $box_id = $row[5];
        $date_str = $row[6];
        $estat = intval($row[7]);
        $col_comentaris = $row[8];
        $q_total = intval($row[9]);
        $tipus = intval($row[10]);
        $date_e_str = $row[11];
        $date_r_str = $row[15];
        $session_id = $row[12];
        $bnom = $row[13];
        $bdesc = $row[14];
        $regal = intval($row[16]);
        $rnom = $row[17];
        $rmail = $row[18];
        $rtel = $row[19];
        $rmun = $row[20];
        $newsletter = intval($row[21]);
        $pagament = $row[22];
        $res_adr_1 = $row[23];
        $res_adr_2 = $row[24];
        $res_cp = $row[25];
        $nom = "";
        $email = "";
        $tel = "";
        $dades = $row[26];
        $genere = intval($row[27]);
        $check_1 = intval($row[28]);
        $check_2 = intval($row[29]);
        $check_3 = intval($row[30]);
        $check_special = intval($row[31]);
        $dades_info = null;

        if($dades!="")
        {
            $dades_info = decode_dades($dades);
        }

        $sql="SELECT username,email,tel FROM members WHERE id='$user_id'";
        $res = $mysqli->query($sql);
        $row = $res->fetch_row();
        if($row!=null)
        {
            $nom = $row[0];
            $email = $row[1];
            $tel = $row[2];
        }
        
        if($date_str=="0000-00-00")
        {
            $date_reservation = date('d-m-Y');
        }
        else
        {
            $rdata = date_create_from_format('Y-m-d',$date_str);
            $date_reservation = date_format($rdata,'d-m-Y');
        }
        
        if($date_r_str=="0000-00-00 00:00:00")
        {
        }
        else
        {
            $rdata = date_create_from_format('Y-m-d H:i:s',$date_r_str);            
            $date_session = date_format($rdata,'d-m-Y');
            $time_session = date_format($rdata,'H:i');            
        }
        
        if($date_e_str=="0000-00-00")
        {
            //$date_execution = date('d-m-Y');
        }
        else
        {
            $rdata = date_create_from_format('Y-m-d',$date_e_str);
            $date_execution = date_format($rdata,'d-m-Y');
        }
        
        $quant_modalities = explode(';',$quantitat);
        
        // recullo totes les sessions d'aquesta experiència
        $sql="SELECT id,data,places,estat,session_name FROM sessions WHERE box_id='$box_id' ORDER BY data";
        $sessions = array();
        $res = $mysqli->query($sql);
        while($row = $res->fetch_row())
        {
            if($row[0]=="0000-00-00 00:00:00")
            {
                $date_session_aux = date('d-m-Y H:i');
            }
            else
            {
                $sdata = date_create_from_format('Y-m-d H:i:s',$row[1]);
                $date_session_aux = date_format($sdata,'d-m-Y H:i');
            }
            $sessions[] = array('id'=>$row[0],'data'=>$date_session_aux,'places'=>$row[2],'estat'=>intval($row[3]),'session_name'=>htmlspecialchars(stripslashes($row[4])));
        }
    }
    else
    {   
        $ref = "";
        $nom = "";        
        $email = "";
        $tel = "";
        $comentaris = "";
        $quantitat = 0;
        $total = 0;
        $box_id = -1;
        $estat = 0;
        $col_comentaris = "";
        $q_total = 0;
        $tipus = 0;
        $session_id = -1;
        $bnom = "";
        $bdesc = "";
        $regal = 0;
        $rnom = "";
        $rmail = "";
        $rtel = "";
        $rmun = "";
        $newsletter = 0;
        $pagament = 1;
        $res_adr_1 = "";
        $res_adr_2 = "";
        $res_cp = "";
        $dades = "";
        $genere = 0;
        $check_1 = 0;
        $check_2 = 0;
        $check_3 = 0;
        $check_special = 0;
        
        // Data
        date_default_timezone_set($zone);
        $date_reservation = date('d-m-Y');        
    }

    $users = GetUsersInfo($mysqli);
    $compte = GetAccountfromUserInfo($mysqli,$_SESSION['user_id']);
    if($_SESSION['user_id']==$SUPERUSER)
    {
        $activitats = GetBoxListAdmin($mysqli,-1,-1);
    }
    else
    {
        $activitats = GetBoxListAdmin($mysqli,-1,$compte['id']);
    }

    if($box_id!=-1)
    {
        for($i=0; $i<count($activitats); $i++)
        {
            $activitat = $activitats[$i];
            if($activitat['id']==$box_id)
            {
                $activitat_seleccionada = $activitat;
                break;
            }
        }
        
        // decodifico l'string de modalitats de preu
        $box = GetBox($mysqli,$box_id);
        $etype = $box['etype'];
        $aux1 = explode(';',$box['price']);
        $price_modalities = array();
        for($i=0;$i<count($aux1);$i++)
        {
            if($aux1[$i]!="")
            {
                $aux2 = explode(':',$aux1[$i]);
                if(count($aux2)>=2)
                {
                    $price_modalities[] = $aux2;
                }
            }
        }
        
        // comprovo si és un esdeveniment programat, un restaurant o una sessió
        if($session_id==-1)
        {            
            //$date_execution = $activitat['edate'];
        }
        else if($session_id==-2)
        {
            $res_days = decode_res_days($box['res_days']);
        }
        else
        {
        }
    }
    else
    {
        $etype = -1;
    }
?>

<script type="text/javascript">
    
    var res_day=[];
    $('.pop_up_content').ready(function(){
        setPopUpSize('.mod_main_edit');
        UpdateView(<?php echo $etype; ?>);
        
        $(function() {
            $( "#edit_data" ).datepicker({ dateFormat: 'dd-mm-yy'});
        }); 
        
        $(function() {
            $( "#edit_data_r1" ).datetimepicker({format:'d-m-Y H:i'});
        }); 
        
        $(function() {
            $( "#edit_data_r2" ).datepicker({ dateFormat: 'dd-mm-yy'});
        });                 
    
        $('#box_id').change(function(){
            $('#quant_input').empty();
            $.ajax({  
                type: "POST",  
                url: "<?php echo $rootfolder; ?>" + "php/server_actions.php",  
                data: {
                    op:"get_box_prices",
                    id:$(this).val()
                },
                dataType: 'json'
            }).done(function(ret)
            {
                var str = "";
                var auxstr;
                for(var i=0;i<ret.length;i++)
                {
                    str += "<div class='quant_list form-group'>";
                    auxstr = "<label>" + ret[i].nom + " (" + ret[i].preu + "€)</label>";
                    str += auxstr;
                    str += "<input class='form-control' type='number' value='0' min='0'/>";
                    str += "</div>";
                }
                
                $('#quant_input').html(str);
            });
            
            $('#edit_session').empty();
            $.ajax({  
                type: "POST",  
                url: "<?php echo $rootfolder; ?>" + "php/server_actions.php",  
                data: {
                    op:"get_session_list",
                    id:$(this).val(),
                    old:false
                },
                dataType: 'json'
            }).done(function(ret)
            {
                var str = "";
                var auxstr;
                //str = "<option value='-1' 'selected'; >" + "<?php echo translate('Reserva manual', $lang); ?>" + "</option>";
                for(var i=0;i<ret.length;i++)
                {
                    str = str + "<option value='" + ret[i].id + "'>" + ret[i].data + " " + ret[i].hora + "</option>";
                }
                
                $('#edit_session').html(str);
            });
                        
            $.ajax({  
                type: "POST",  
                url: "<?php echo $rootfolder; ?>" + "php/server_actions.php",  
                data: {
                    op:"get_box",
                    id:$(this).val()
                },
                dataType: 'json'
            }).done(function(ret)
            {
                UpdateView(ret.etype);
                
                if(ret.etype==0)        // sessió única
                {
                    $('#edit_session').prepend("<option value='-1'; >" + "<?php echo translate('Reserva manual', $lang); ?>" + "</option>");
                    $('#edit_session').val(ret.sessio_unica);
                    // Ara he d'amagar les altres sessions
                    
                    $("#etype_1").hide();
                    $("#etype_2").hide();
                }
                else if(ret.etype==1)   // sessions
                {
                    $('#edit_session').prepend("<option value='-1' 'selected'; >" + "<?php echo translate('Reserva manual', $lang); ?>" + "</option>");
                    $('#edit_session').val("-1");                    
                }
                else if(ret.etype==4)   // productes simples
                {
                    $('#edit_session').empty();
                    $('#edit_session').prepend("<option value='-1'; >" + "<?php echo translate('Productes', $lang); ?>" + "</option>");
                    $("#etype_1").hide();
                    $("#etype_2").hide();
                    $("#edit_data_r1").val()="";
                }
                else if(ret.etype==5)   // productes avançats
                {
                    $('#edit_session').empty();
                    $('#edit_session').prepend("<option value='-1'; >" + "<?php echo translate('Productes', $lang); ?>" + "</option>");
                    $("#etype_1").hide();
                    $("#etype_2").hide();
                    $("#edit_data_r1").val()="";                    
                }
                else if(ret.etype==7)   // aportació voluntària
                {
                    $('#edit_session').empty();
                    $('#edit_session').prepend("<option value='-1'; >" + "<?php echo translate('Productes', $lang); ?>" + "</option>");
                    $("#etype_1").hide();
                    $("#etype_2").hide();
                    $("#edit_data_r1").val()="";
                }
//                else if(ret.etype==2)   // restaurant
//                {
//                    $('#edit_session').prepend("<option value='-2' 'selected'; >" + "<?php echo translate('Restaurant', $lang); ?>" + "</option>");
//                    $('#edit_session').val("-2");
//                      
//                    if(ret.res_days!=null)
//                    {
//                        res_day = decode_res_days(ret.res_days);
//                        alert(ret.res_days);
//                        alert(res_day);
//                        //Calendar();
//                    }
//                }
            });
            
            if($(this).val()=="502" || $(this).val()=="510" || $(this).val()=="511")
            {
                $('#sp_field').empty();
                $('#sp_field').append(
                    '<div class="form-group">\
                        <label>SOLIDARI</label>\
                        <input id="check_special" type="checkbox">\
                    </div>\
                    <div class="form-group">\
                        <label>AUTOCAR</label>\
                        <input id="check_1" type="checkbox">\
                    </div>\
                    <div class="form-group">\
                        <label>CORRENT</label>\
                        <input id="check_2" type="checkbox">\
                    </div>\
                    <div class="form-group">\
                        <label>CELIAQUIA</label>\
                        <input id="check_3" type="checkbox">\
                    </div>\
                    <div class="form-group">\
                        <button id="nova_dada" class="btn btn-primary">Afegir camp de dades</button>\
                    </div>\
                    <div id="dades">\
                    </div>');

                $('#nova_dada').click(function(){
                    $('#dades').append(
                        '<div class="row dades_linia">\
                            <div class="form-group col-sm-2">\
                                <label>GÈNERE</label>\
                                <select class="form-control camp_1">\
                                    <option value="-1">-</option>\
                                    <option value="1">Home</option>\
                                    <option value="2">Dona</option>\
                                    <option value="3">No binari</option>\
                                </select>\
                            </div>\
                            <div class="form-group col-sm-6">\
                                <label>NOM</label>\
                                <input class="form-control camp_2" type="text" value=""/>\
                            </div>\
                            <div class="form-group col-sm-4">\
                                <label>DNI</label>\
                                <input class="form-control camp_3" type="text" value=""/>\
                            </div>\
                            <div class="form-group col-sm-12">\
                                <label>MENOR</label>\
                                <input class="camp_4" type="checkbox">\
                            </div>\
                        </div>'
                    );
                });
            }

        });
        
        $('#edit_session').change(function(){
            switch(parseInt($(this).val()))
            {
                case -1:    // Reserva manual
                    etype_state_str(1);
                    $('#edit_data_r1').val("");
                    $("#etype_1").show();
                    $("#etype_2").hide();
                    break;
                    
                case -2:    // Restaurant 
                    etype_state_str(2);
                    $("#etype_2").show();
                    $("#etype_1").hide();
                    break;
                    
                default:
                    etype_state_str(1);                    
                    data = $("#edit_session option:selected").text();                    
                    //$('#edit_data_r1').val(data);
                    $("#etype_1").hide();
                    $("#etype_2").hide();
                    break;
            }
        });
        
        $('#save').one('click',function(){
            validate_reserva();
        });
        
        $('#cancel').one('click',function(){
            window.location.href = '/admin/2';
        });

        $('#nova_dada').click(function(){
            $('#dades').append(
                '<div class="row dades_linia">\
                    <div class="form-group col-sm-2">\
                        <label>GÈNERE</label>\
                        <select class="form-control camp_1">\
                            <option value="-1">-</option>\
                            <option value="1">Home</option>\
                            <option value="2">Dona</option>\
                            <option value="3">No binari</option>\
                        </select>\
                    </div>\
                    <div class="form-group col-sm-6">\
                        <label>NOM</label>\
                        <input class="form-control camp_2" type="text" value=""/>\
                    </div>\
                    <div class="form-group col-sm-4">\
                        <label>DNI</label>\
                        <input class="form-control camp_3" type="text" value=""/>\
                    </div>\
                    <div class="form-group col-sm-12">\
                        <label>MENOR</label>\
                        <input class="camp_4" type="checkbox">\
                    </div>\
                </div>'
            );
        });
    });
    
    
    function UpdateView(myetype)
    {
        $("#box_id").attr("etype",myetype);
        
        $('.vtype1').hide();
        $('.vtype2').hide();
        $('.vtype3').hide();
        $('.vtype4').hide();
        $('.vtype5').hide();
        $('.vtype7').hide();
        
        switch(myetype)
        {
            case 1:
                $('.vtype1').show();
                break;
            case 2:
                $('.vtype2').show();
                break;
            case 3:
                $('.vtype3').show();
                break;
            case 4:
                $('.vtype4').show();
                break;
            case 5:
                $('.vtype5').show();
                break;
            case 7:
                $('.vtype7').show();
                break;
            default:
                $('.vtype1').show();
                $('.vtype2').show();
                $('.vtype3').show();
                $('.vtype4').show();
                $('.vtype5').show();
                $('.vtype7').show();
                break;
        }
    }
    
    function Calendar()
    {
        $("#edit_data_r2").datepicker({                        
            minDate: 0,
            firstDay: 1,
            dayNamesMin: ["Dg", "Dl", "Dm", "Dx", "Dj", "Dv", "Ds" ],
            monthNamesShort: [ "Gen", "Feb", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Des" ],
            monthNames: [ "Gener", "Febrer", "Març", "Abril", "Maig", "Juny", "Juliol", "Agost", "Setembre", "Octubre", "Novembre", "Desembre" ],                
            onSelect: function(selectedDate,inst) {

                var date = $(this).datepicker('getDate');
                var wday = (parseInt(date.getUTCDay())+1)%7;                    

                var result = selectedDate.split('/');
                var day = result[1];
                var month = result[0];
                var year = result[2];

                $('.quant_input').empty();
                $("#eventsession").empty();

                var str = "";
                if(res_day[2*wday].act==1)
                {
                    str = str + '<input data="' + day + '/' + month + '/' + year + '" sessio="migdia"';
                    str += ' id="servei_0" type="radio" name="sess" value="0">';
                    str += '<label for="servei_0">Migdia</label>';
                }
                if(res_day[2*wday+1].act==1)
                {
                    str = str + '<input data="' + day + '/' + month + '/' + year + '" sessio="nit"';
                    str += ' id="servei_1" type="radio" name="sess" value="1">';
                    str += '<label for="servei_1">Nit</label>';
                }


                $("#eventsession").html(str);

                $("#eventsession input").click(function(){

                    $('.quant_input').empty();
                    if($(this).val()==0)
                    {
                        amount = res_day[2*wday].places;
                    }
                    else
                    {
                        amount = res_day[2*wday+1].places;
                    }

                    for(var i=1;i<=amount;i++)
                    {
                        var str = '<option value="' + i + '">' + i + (i==1?' persona':' persones') + '</option>';
                        $('.quant_input').append(str);	
                    }                                                

                });
            }, 
            beforeShowDay: function(date){ 
                var day = parseInt(date.getDay());                    
                if(res_day[2*day].act==1 || res_day[2*day+1].act==1)
                {
                    return [true,"available_date"];
                }
                else
                {
                    return [false,""];
                }
            },
            afterShow: function() {
            },
        });
    }
    
    function etype_state_str(etype)
    {
        if(etype<=1)
        {
            $('#edit_state_0').html("<?php echo translate('Pagament en curs', $lang); ?>");
            $('#edit_state_1').html("<?php echo translate('Pagament denegat', $lang); ?>");
            $('#edit_state_2').html("<?php echo translate('Pendent de pagament', $lang); ?>");
            $('#edit_state_3').html("<?php echo translate('Reserva correcta', $lang); ?>");
            $('#edit_state_4').html("<?php echo translate('Activitat realitzada', $lang); ?>");
            $('#edit_state_5').html("<?php echo translate('Pre-reserva', $lang); ?>");
        }
        if(etype==4 || etype==5 || etype==7)
        {
            $('#edit_state_0').html("<?php echo translate('Pagament en curs', $lang); ?>");
            $('#edit_state_1').html("<?php echo translate('Pagament denegat', $lang); ?>");
            $('#edit_state_2').html("<?php echo translate('Pendent de pagament', $lang); ?>");
            $('#edit_state_3').html("<?php echo translate('Compra correcta', $lang); ?>");
            $('#edit_state_4').html("<?php echo translate('Compra correcta', $lang); ?>");
            $('#edit_state_5').html("<?php echo translate('Pre-reserva', $lang); ?>");
        }
        else  
        {
            $('#edit_state_0').html("<?php echo translate('Reserva en curs', $lang); ?>");
            $('#edit_state_1').html("<?php echo translate('Reserva denegada', $lang); ?>");
            $('#edit_state_2').html("<?php echo translate('Reserva enviada', $lang); ?>");
            $('#edit_state_3').html("<?php echo translate('Reserva acceptada', $lang); ?>");
            $('#edit_state_4').html("<?php echo translate('Reserva realitzada', $lang); ?>");
            $('#edit_state_5').html("<?php echo translate('Pre-reserva', $lang); ?>");
        }
    }
    
    function validate_reserva()
    {        
        var b_ok = true;
        $('.required').each(function(){
            if($(this).val()=="")  
            {
                $(this).addClass('missing');
                b_ok = false;
            }
            else                   
            {
                $(this).removeClass('missing');
            }
        });
        
        if(b_ok)
        {
            if($("#box_id").attr("etype")==5)
            {
                var quant_str = "";
                $('.quant_list').each(function(){
                    quant_str += $(this).attr('pid');
                    quant_str += ':';
                    quant_str += $(this).attr('pkid');
                    quant_str += ':';
                    quant_str += $(this).find('input').val();
                    quant_str += ';';
                });
            }
            else
            {
                var quant_str = "";
                $('.quant_list').each(function(){
                    quant_str += $(this).find('input').val();
                    quant_str += ';';
                });
            }

            var dades_str = "";
            $('.dades_linia').each(function(){
                dades_str+=$(this).find('.camp_1').val();
                dades_str+='::';
                dades_str+=$(this).find('.camp_2').val();
                dades_str+='::';
                dades_str+=$(this).find('.camp_3').val();
                dades_str+='::';
                dades_str+=($(this).find('.camp_4').is(":checked")?1:0);
                dades_str+=';;';
            });

            var b_check_1=b_check_2=b_check_3=b_check_special=0;
            var val_genere = -1;
            if ($("#check_special").length){
                b_check_special = $('#check_special').is(":checked")?1:0;
            }
            if ($("#check_1").length){
                b_check_1 = $('#check_1').is(":checked")?1:0;
            }
            if ($("#check_2").length){
                b_check_2 = $('#check_2').is(":checked")?1:0;
            }
            if ($("#check_3").length){
                b_check_3 = $('#check_3').is(":checked")?1:0;
            }
            
            $.ajax({  
                type: "POST",
                url: "<?php echo $rootfolder; ?>" + "php/server_actions.php",                
                data: {
                    op:"insert_reservation",
                    reservation_id:'<?php echo $id; ?>',
                    num_reserva:'<?php echo $ref; ?>',
                    quant_str:quant_str,
                    box_id:$('#box_id').val(),
                    edit_number:1,
                    edit_state:$('#edit_state').val(),
                    edit_session:$('#edit_session').val(),
                    edit_name:$('#edit_name').val(),
                    edit_short_text:$('#edit_short_text').val(),
                    edit_nom:$('#edit_nom').val(),
                    edit_email:$('#edit_email').val(),
                    edit_tel:$('#edit_tel').val(),
                    edit_addr1:$('#edit_add1').val(),
                    edit_cp:$('#edit_cp').val(),
                    edit_mun:$('#edit_mun').val(),
                    edit_data:$('#edit_data').val(),
                    edit_data_r:$('#edit_data_r1').val(),
                    edit_data_e:$('#edit_data_e').val(),
                    edit_total:$('#edit_total').val(),
                    edit_qtotal:$('#edit_qtotal').val(),
                    edit_comentaris:$('#edit_comentaris').val(),
                    edit_newsletter: $('#edit_newsletter').is(":checked")?1:0,
                    genere: $('#edit_genere').val(),
                    check_1: b_check_1,
                    check_2: b_check_2,
                    check_3: b_check_3,
                    check_special: b_check_special,
                    dades: dades_str,
                }
            }).success(function(ret){               
                window.location.href = '/admin/2';
            });
        }
        else
        {
            $('#save').one('click',function(){
                validate_reserva();
            });
        }
    }        
    
</script>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Edita la reserva</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">  
            <div class="panel-heading">
                <div class="col-lg-6">
                <?php 
                if($id!=-1)
                {
                    echo "<h4>" . translate("Reserva", $lang) . ' ' . strtoupper($ref) . "</h4>";
                }
                else
                {
                    echo "<h4>" . translate("Nova reserva", $lang) . "</h4>";
                }
                ?>
                </div>
                
                <div style="text-align:right">
                    <button id="save" class="btn btn-success"><?php echo translate('Guardar', $lang); ?></button>
                    <button id="cancel" class="btn btn-warning"><?php echo translate('Cancel·lar', $lang); ?></button>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label><?php echo translate("Taquilla", $lang); ?></label>
                            <select id="box_id" class="form-control" name="box_id" etype=-1>
                                <option value="-1" <?php if($box_id==-1) echo 'selected'; ?>>Personalitzada</option>
                            <?php                
                            for($i=0; $i<count($activitats); $i++)
                            {
                                $activitat = $activitats[$i];
                            ?>
                                <option value="<?php echo $activitat['id']; ?>" <?php if($box_id!=-1 && $activitat['id']==$box_id) echo 'selected'; ?>><?php echo $activitat['name']; ?></option>
                            <?php
                            }
                            ?>
                            </select>                                
                        </div>
                        <div class="form-group vtype1 vtype2 vtype3 vtype4 vtype5 vtype7">
                            <label><?php echo translate("Estat de la reserva", $lang); ?></label>
                            <select id="edit_state" class="form-control" name="edit_state">
                                <option id="edit_state_0" value="-2" <?php if($estat==-2) echo 'selected'; ?>><?php if($session_id==-2) echo translate('Reserva en curs', $lang); else echo translate('Pagament en curs', $lang); ?></option>
                                <option id="edit_state_1" value="-1" <?php if($estat==-1) echo 'selected'; ?>><?php if($session_id==-2) echo translate('Reserva denegada', $lang); else echo translate('Pagament denegat', $lang); ?></option>
                                <option id="edit_state_2" value="0" <?php if($estat==0) echo 'selected'; ?>><?php if($session_id==-2) echo translate('Reserva enviada', $lang); else echo translate('Pendent de pagament', $lang); ?></option>
                                <option id="edit_state_3" value="1" <?php if($estat==1) echo 'selected'; ?>><?php if($session_id==-2) echo translate('Reserva acceptada', $lang); else echo translate('Reserva correcta', $lang); ?></option>
                                <option id="edit_state_4" value="2" <?php if($estat==2) echo 'selected'; ?>><?php if($session_id==-2) echo translate('Reserva realitzada', $lang); else echo translate('Activitat realitzada', $lang); ?></option>
                                <option id="edit_state_5" value="3" <?php if($estat==3) echo 'selected'; ?>><?php if($session_id==-2) echo translate('Pre-reserva', $lang); else echo translate('Pre-reserva', $lang); ?></option>
                            </select>                              
                        </div>
                        <div class='form-group vtype1 vtype2 vtype3 vtype4 vtype5 vtype7'>
                            <label><?php echo translate("Data de compra", $lang); ?></label>
                            <input class="form-control date_input" id="edit_data" name="edit_data" type="text" value="<?php echo $date_reservation; ?>"/>
                        </div>
                        <div class='form-group vtype1 vtype2 vtype3'>
                            <label><?php echo translate("Tipus d'activitat/Sessions disponibles", $lang); ?></label>
                            <select id="edit_session" class="form-control" name="edit_session">
                                <option value="-1" <?php if($session_id==-1) echo 'selected'; ?>><?php echo translate('Reserva manual', $lang); ?></option>
<!--                                <option value="-2" <?php if($session_id==-2) echo 'selected'; ?>><?php echo translate('Restaurant', $lang); ?></option>-->
                                <?php                
                                for($i=0; $i<count($sessions); $i++)
                                {
                                    $sessio = $sessions[$i];
                                ?>
                                <option value="<?php echo $sessio['id']; ?>" <?php if($session_id==$sessio['id']) echo 'selected'; ?>><?php echo $sessio['data'] . " - " . $sessio['session_name']; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div> 
                        <div id="etype_1" class='form-group  vtype1 vtype2 vtype3' <?php if($session_id!=-1 && $session_id!=0) echo "style='display:none'"; ?>>
                            <label><?php echo translate("Data de la reserva", $lang); ?></label>
                            <input class="form-control date_input" id="edit_data_r1" name="edit_data_r1" type="text" value="<?php if($date_session!="" || $time_session!="") echo $date_session . ' ' . $time_session; ?>"/>
                        </div>

                        <div class='form-group vtype1 vtype2 vtype3'>
                            <label><?php echo translate("Nom alternatiu", $lang); ?></label>
                            <input name="edit_name" class="form-control" type="text" value="<?php echo $bnom; ?>"/>
                        </div>
                        <div class='form-group vtype1 vtype2 vtype3'>
                            <label><?php echo translate("Text curt", $lang); ?></label>
                            <textarea style="height:100px" class="form-control" name="edit_short_text"><?php echo $bdesc; ?></textarea>
                        </div>
                        <div id="sp_field">
                        <?php
                        if($box_id==502 || $box_id==510 || $box_id==511 || $box_id==207) 
                        {?>
                        <div class="form-group">
                            <label>SOLIDARI</label>
                            <input id="check_special" type="checkbox" <?php if($check_special==1) echo 'checked'; ?>>
                        </div>
                        <div class="form-group">
                            <label>AUTOCAR</label>
                            <input id="check_1" type="checkbox" <?php if($check_1==1) echo 'checked'; ?>>
                        </div>
                        <div class="form-group">
                            <label>CORRENT</label>
                            <input id="check_2" type="checkbox" <?php if($check_2==1) echo 'checked'; ?>>
                        </div>
                        <div class="form-group">
                            <label>CELIAQUIA</label>
                            <input id="check_3" type="checkbox" <?php if($check_3==1) echo 'checked'; ?>>
                        </div>

                        <div class="form-group">
                            <button id="nova_dada" class="btn btn-primary">Afegir camp de dades</button>
                        </div>
                        <div id="dades">
                        <?php
                        if($dades_info!=null)
                        {
                            foreach($dades_info as $dades_iter)
                            {?>
                        <div class="row dades_linia">
                            <div class="form-group col-sm-2">
                                <label>GÈNERE</label>
                                <select class="form-control camp_1">
                                    <option value="-1" <?php if($dades_iter['genere']<=0) echo 'selected'; ?>>-</option>
                                    <option value="1" <?php if($dades_iter['genere']==1) echo 'selected'; ?>>Home</option>
                                    <option value="2" <?php if($dades_iter['genere']==2) echo 'selected'; ?>>Dona</option>
                                    <option value="3" <?php if($dades_iter['genere']==3) echo 'selected'; ?>>No binari</option>
                                </select>                              
                            </div>
                            <div class='form-group col-sm-6'>
                                <label>NOM</label>
                                <input class="form-control camp_2" type="text" value="<?php echo $dades_iter['nom'] ; ?>"/>
                            </div>
                            <div class='form-group col-sm-4'>
                                <label>DNI</label>
                                <input class="form-control camp_3" type="text" value="<?php echo $dades_iter['dni'] ; ?>"/>
                            </div>
                            <div class="form-group col-sm-12">
                                <label>MENOR</label>
                                <input class="camp_4" type="checkbox" <?php if($dades_iter['menor']==1) echo 'checked'; ?>>
                            </div>
                        </div>

                        <?php
                            }
                        }?>
                        </div>
                        <?php
                        }?>
                        </div>
                    </div>
                    <!-- /.col-lg-6 (nested) -->
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="form-group col-sm-2">
                                    <label>GÈNERE</label>
                                    <select class="form-control"  name="edit_genere" id="edit_genere">
                                        <option value="-1" <?php if($genere<=0) echo 'selected'; ?>>-</option>
                                        <option value="1" <?php if($genere==1) echo 'selected'; ?>>Home</option>
                                        <option value="2" <?php if($genere==2) echo 'selected'; ?>>Dona</option>
                                        <option value="3" <?php if($genere==3) echo 'selected'; ?>>No binari</option>
                                    </select>                              
                                </div>
                            <div class='form-group vtype1 vtype2 vtype3 vtype4 vtype5 vtype7 col-sm-10'>
                                <label><?php echo translate("Nom", $lang); ?></label>
                                <input class="form-control" name="edit_nom" id="edit_nom" type="text" value="<?php echo $rnom; ?>"/>       
                            </div>
                        </div>                
                        <div class='form-group vtype1 vtype2 vtype3 vtype4 vtype5 vtype7'>
                            <label><?php echo translate("Email", $lang); ?></label>
                            <input class="form-control" name="edit_email" id="edit_email" type="text" value="<?php echo $rmail; ?>"/>
                        </div>
                        <div class='form-group vtype1 vtype2 vtype3 vtype4 vtype5 vtype7'>
                            <label><?php echo translate("Telèfon", $lang); ?></label>
                            <input class="form-control" name="edit_tel" id="edit_tel" type="text" value="<?php echo $rtel; ?>"/>
                        </div>
                        <div class='form-group vtype1 vtype2 vtype3 vtype4 vtype5 vtype7'>
                            <label><?php echo translate("Adreça 1", $lang); ?></label>
                            <input class="form-control" id="edit_add1" type="text" name="edit_add1" value="<?php echo $res_adr_1; ?>"/>
                        </div>   
                        <div class='form-group vtype1 vtype2 vtype3 vtype4 vtype5 vtype7'>
                            <label><?php echo translate("Municipi", $lang); ?></label>
                            <input class="form-control" id="edit_mun" type="text" name="edit_mun" value="<?php echo $rmun; ?>"/>
                        </div>
                        <div class='form-group vtype1 vtype2 vtype3 vtype4 vtype5 vtype7'>
                            <label><?php echo translate("Codi Postal", $lang); ?></label>
                            <input class="form-control" id="edit_cp" type="text" name="edit_cp" value="<?php echo $res_cp; ?>"/>
                        </div>
                        <div class='form-group vtype1 vtype2 vtype3 vtype4 vtype5 vtype7'>
                            <label><?php echo translate("Comentari", $lang); ?></label>
                            <textarea style="height:100px" class="form-control" id="edit_comentaris" name="edit_comentaris"><?php echo $comentaris; ?></textarea>
                        </div>
                        <div class="form-group vtype1 vtype2 vtype3 vtype4 vtype5 vtype7">
                                <label>Newsletter</label>
                                <input id="edit_newsletter" type="checkbox" <?php if($newsletter==1) echo 'checked'; ?>>
                        </div>
                        <div id="quant_input">
                        <?php
                        if($etype==5)
                        {
                            $producte_list = GetProductefromList($mysqli,$box["productes"]);
                            foreach($producte_list as $producte)
                            {
                                foreach($producte['modalitat'] as $prod_item)
                                {
                                    $carret = decode_carret($quantitat,$producte['id'],$prod_item['id']);
                                    $quant = intval($carret[0]['quant']);
                            ?>
                            <div class='quant_list form-group' pid='<?php echo $producte['id']; ?>' pkid='<?php echo $prod_item['id']; ?>'>
                                <label><?php echo $producte['name'] . ' - ' . $prod_item['nom'] . ' (' . $prod_item['preu'] . '€)'; ?></label>
                                <input style="width:80px" class="form-control" type="number" value='<?php echo $quant; ?>' min='0'/>
                            </div>
                            <?php
                                }
                            }
                        }
                        else if($etype==7)
                        {
                            // en aquest cas no cal posar-hi res
                        }
                        else
                        {
                            //for($i=0;$i<min(count($price_modalities),count($quant_modalities));$i++)
			                for($i=0;$i<count($price_modalities);$i++)
                            {
                                $price = $price_modalities[$i];
                                if($quant_modalities[$i]!='undefined' && $quant_modalities[$i]!=null)
                                {
                                    $quant = intval($quant_modalities[$i]);
                                }
                                else
                                {
                                    $quant = 0;
                                }
                            ?>
                            <div class='quant_list form-group' qid='<?php echo $i; ?>'>
                                <label><?php echo $price[0] . ' (' . $price[1] . '€)'; ?></label>
                                <input style="width:80px" class="form-control" type="number" value='<?php echo $quant; ?>' min='0'/>
                            </div>
                            <?php
                            }
                        }
                        ?>
                        </div>
                        <div class='form-group vtype1 vtype2 vtype3 vtype4 vtype5 vtype7'>
                            <label><?php echo translate("Preu Total", $lang); ?></label>
                            <input style="width:80px" class="form-control required" id="edit_total" name="edit_total" type="number" value='<?php echo $total; ?>' min='0'/>
                        </div>
                        <div class='form-group vtype1 vtype2 vtype3 vtype4'>
                            <label><?php echo translate("Quantitat total", $lang); ?></label>
                            <input style="width:80px" class="form-control" id="edit_qtotal" name="edit_qtotal" type="number" value='<?php echo $q_total; ?>' min='0'/>
                        </div>                          

                    </div>                    
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
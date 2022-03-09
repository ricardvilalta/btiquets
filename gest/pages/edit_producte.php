<?php
    global $mysqli;
    global $id;
    global $lang;
    global $zone;    
    
    if($id>0)
    {   
        $sql="SELECT name,poblacio,mail,tel,web,description,type,modalitat,propietari,ocult,name_es,description_es,name_en,description_en,modalitat_es,modalitat_en,mail_aux FROM productes WHERE id='$id'";
        
        $res = $mysqli->query($sql);
        $row = $res->fetch_row();
        $name = $row[0];
        $municipi = $row[1];        
        $mail = $row[2];
        $tel = $row[3];
        $web = $row[4];
        $description = $row[5];
        $type = intval($row[6]);
        $capacitat = $row[7];        
        $propietari = intval($row[8]); 
        $ocult = intval($row[9]);
        $name_es = $row[10];
        $description_es = $row[11];
        $name_en = $row[12];
        $description_en = $row[13];
        $capacitat_es = $row[14];
        $capacitat_en = $row[15];
        $col_mail = $row[16];
        
        // decodifico l'string de capacitats i preu
        $cap_modalities = decode_prod($capacitat,true);
        $cap_es_modalities = decode_prod($capacitat_es,true);
        $cap_en_modalities = decode_prod($capacitat_en,true);
        
        // tb he d'agafar totes les imatges de la carpeta /boxes/box_id
        $imglist = GetFolderImages("../../productes/p_" . $id);               
    }
    else
    {
        $name = "";
        $municipi = "";        
        $mail = "";        
        $tel = "";
        $web  = "";
        $description  = "";
        $type = 0;
        $capacitat = "";
        $propietari = -1;
        $ocult = 0;
        $name_es = "";
        $description_es = "";
        $name_en = "";
        $description_en = "";
        $capacitat_es = "";
        $capacitat_en = "";
        $col_mail = "";
        
        $cap_modalities = null;
        $cap_es_modalities = null;
        $cap_en_modalities = null;
        $imglist = null;
    }

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
                    path: '<?php echo $rootfolder . "productes/p_" . $id . "/"; ?>',
                    name: 'p_image_0.jpg',
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
                    str = str + '<?php echo $rootfolder; ?>' + 'productes/p_';
                    str += '<?php echo $id; ?>';
                    str += '/';
                    str += data.result.files[0].name;
                    str += '?nocache='
                    str += Math.random();
                    str += '" path="';
                    str += data.result.files[0].name;
                    str += '">';
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
                    path: '<?php echo $rootfolder . "productes/p_" . $id . "/"; ?>',
                    name: 'p_image_1.jpg',
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
                    str = str + '<?php echo $rootfolder; ?>' + 'productes/p_';
                    str += '<?php echo $id; ?>';
                    str += '/';
                    str += data.result.files[0].name;
                    str += '?nocache='
                    str += Math.random();
                    str += '" path="';
                    str += data.result.files[0].name;
                    str += '">';
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
                    path: '<?php echo $rootfolder . "productes/p_" . $id . "/"; ?>',
                    name: 'p_image_2.jpg',
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
                    str = str + '<?php echo $rootfolder; ?>' + 'productes/p_';
                    str += '<?php echo $id; ?>';
                    str += '/';
                    str += data.result.files[0].name;
                    str += '?nocache='
                    str += Math.random();
                    str += '" path="';
                    str += data.result.files[0].name;
                    str += '">';
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
                    path: '<?php echo $rootfolder . "productes/p_" . $id . "/"; ?>',
                    name: 'p_image_3.jpg',
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
                    str = str + '<?php echo $rootfolder; ?>' + 'productes/p_';
                    str += '<?php echo $id; ?>';
                    str += '/';
                    str += data.result.files[0].name;
                    str += '?nocache='
                    str += Math.random();
                    str += '" path="';
                    str += data.result.files[0].name;
                    str += '">';
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
            window.location.href = '/admin/8';
        });
        
        $('#edit_etype').change(function(){
            switch(parseInt($(this).val()))
            {
                case 0: //mòduls sencers
                    break;
                case 1: //habitacions                    
                    break;                
            }
        });
                                
        $('#new_mod').click(function(){
            var str = 
                '<div class="mod_block">' +
                    '<div class="form-group">' +
                        '<label>Nom</label>' +
                        '<input class="form-control mod_nom" placeholder="Nom - català"><br>' +
                        '<input class="form-control mod_nom_es" placeholder="Nom - castellà"><br>' +
                        '<input class="form-control mod_nom_en" placeholder="Nom - anglès">' +
                    '</div>' +
                    '<div class="form-group">' +
                        '<label>Descripció</label>' +
                        '<input class="form-control mod_desc" placeholder="Descripció - català"><br>' +
                        '<input class="form-control mod_desc_es" placeholder="Descripció - castellà"><br>' +
                        '<input class="form-control mod_desc_en" placeholder="Descripció - anglès">' +
                    '</div>' +                    
                    '<div class="form-group input-group">' +
                        '<span class="input-group-addon"><i class="fa fa-eur"></i>' +
                        '</span>' +
                        '<input type="text" class="form-control mod_preu" placeholder="Preu">' +
                    '</div>' +
                    '<div class="form-group input-group no-padding">' +
                        '<div class="col-sm-6">' +
                            '<label>Stock actual</label><input type="text" class="form-control mod_stock">' +
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
            $('.del_mod').off('click');
            $('.del_mod').on('click',function(){
                $(this).parent().parent().remove();
            });
        }
                
        
        function ResetEvents()
        {                            
            $('.del_image').off('click');
            $('.del_image').on('click',function(){
                $(this).parent().parent().remove();
                
                $.ajax({  
                    type: "POST",  
                    url: "<?php echo $rootfolder; ?>" + "php/server_actions.php",  
                    data: {
                        op:"delete_image_producte",
                        path:$(this).parent().next().attr('path'),
                        id:<?php echo $id; ?>
                    },
                });
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
                    var imgname = this.src.substr(this.src.lastIndexOf('/')+1);
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
                img.src = '<?php echo $rootfolder . "productes/p_" . $id . "/p_image_" . $i . ".jpg?nocache=" . rand(); ?>';
            <?php
            } 
            
            for($i=0;$i<count($cap_modalities);$i++)
            {
                $cap = $cap_modalities[$i];
                $cap_es = $cap_es_modalities[$i];
                $cap_en = $cap_en_modalities[$i];
                ?>
                var str =                 
                '<div class="mod_block">' +
                    '<div class="form-group">' +
                        '<label>Nom</label>' +
                        '<input class="form-control mod_nom" placeholder="Nom - català" value="' + "<?php echo $cap['nom']; ?>" + '"><br>' +
                        '<input class="form-control mod_nom_es" placeholder="Nom - castellà" value="' + "<?php echo $cap_es['nom']; ?>" + '"><br>' +
                        '<input class="form-control mod_nom_en" placeholder="Nom - anglès" value="' + "<?php echo $cap_en['nom']; ?>" + '">' +
                    '</div>' +
                    '<div class="form-group">' +
                        '<label>Descripció</label>' +
                        '<input class="form-control mod_desc" placeholder="Descripció - català" value="' + "<?php echo $cap['desc']; ?>" + '"><br>' +
                        '<input class="form-control mod_desc_es" placeholder="Descripció - castellà" value="' + "<?php echo $cap_es['desc']; ?>" + '"><br>' +
                        '<input class="form-control mod_desc_en" placeholder="Descripció - anglès" value="' + "<?php echo $cap_en['desc']; ?>" + '">' +
                    '</div>' +                    
                    '<div class="form-group input-group">' +
                        '<span class="input-group-addon"><i class="fa fa-eur"></i>' +
                        '</span>' +
                        '<input type="text" class="form-control mod_preu" placeholder="Preu" value="' + "<?php echo $cap['preu']; ?>" + '">' +
                    '</div>' +
                    '<div class="form-group input-group no-padding">' +
                        '<div class="col-sm-6">' +
                            '<label>Stock actual</label><input type="text" class="form-control mod_stock" value="' + "<?php echo $cap['stock']; ?>" + '">' +
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
                        price_str += $(this).find('.mod_desc').val();
                        price_str += ':';
                        price_str += $(this).find('.mod_stock').val();
                        price_str += ':';
                        price_str += $(this).find('.mod_preu').val();
                        price_str += ';'; 
                        
                        price_es_str += $(this).find('.mod_nom_es').val();
                        price_es_str += ':';
                        price_es_str += $(this).find('.mod_desc_es').val();
                        price_es_str += ':';
                        price_es_str += $(this).find('.mod_stock').val();
                        price_es_str += ':';
                        price_es_str += $(this).find('.mod_preu').val();
                        price_es_str += ';'; 
                        
                        price_en_str += $(this).find('.mod_nom_en').val();
                        price_en_str += ':';
                        price_en_str += $(this).find('.mod_desc_en').val();
                        price_en_str += ':';
                        price_en_str += $(this).find('.mod_stock').val();
                        price_en_str += ':';
                        price_en_str += $(this).find('.mod_preu').val();
                        price_en_str += ';'; 
                    }
                });
                

                $.ajax({  
                    type: "POST",  
                    url: "<?php echo $rootfolder; ?>" + "php/server_actions.php",
                    data: {
                        op:"insert_producte",
                        id:'<?php echo $id; ?>',
                        name:$('#edit_title').val(),
//                        poblacio:$('#edit_mun').val(),
//                        mail:$('#edit_mail').val(),
//                        tel:$('#edit_tel').val(),
//                        web:$('#edit_web').val(),
                        description:$('#edit_description').val(),
                        name_es:$('#edit_title_es').val(),                        
                        description_es:$('#edit_description_es').val(),
                        name_en:$('#edit_title_en').val(),                    
                        description_en:$('#edit_description_en').val(),
//                        type:$('#edit_etype').val(),
                        mod:price_str,
                        mod_es:price_es_str,
                        mod_en:price_en_str,                        
                        propietari:'<?php echo $compte["id"]; ?>',
                        ocult:$('#edit_actiu').prop('checked')?0:1,
//                        col_mail:$('#edit_col_mail').val(),
                    },
                }).success(function(ret)
                {
                    window.location.href = '/admin/8';
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
        <h1 class="page-header">Edita el producte</h1>
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
                    if($id==-1)
                    {
                        echo "<h4>" . "Nou producte" . "</h4>";
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
                                <label>Nom del producte</label>
                                <input id="edit_title" class="form-control" value="<?php echo $name; ?>">
                                <p class="help-block">català</p>
                                <input id="edit_title_es" class="form-control" value="<?php echo $name_es; ?>">
                                <p class="help-block">castellano</p>
                                <input id="edit_title_en" class="form-control" value="<?php echo $name_en; ?>">
                                <p class="help-block">english</p>
                            </div>
                            <div class="form-group">
                                <label>Descripció del producte</label>
                                <textarea id="edit_description" class="form-control" rows="3"><?php echo $description; ?></textarea>
                                <p class="help-block">català</p>
                                <textarea id="edit_description_es" class="form-control" rows="3"><?php echo $description_es; ?></textarea>
                                <p class="help-block">castellano</p>
                                <textarea id="edit_description_en" class="form-control" rows="3"><?php echo $description_en; ?></textarea>
                                <p class="help-block">english</p>
                            </div>
<!--
                            <div class="form-group">
                                <label>Municipi</label>
                                <input id="edit_mun" class="form-control" value="<?php echo $municipi; ?>">
                            </div>
                            <div class="form-group">
                                <label>Mail</label>
                                <input id="edit_mail" class="form-control" value="<?php echo $mail; ?>">
                            </div>
                            <div class="form-group">
                                <label>Tel</label>
                                <input id="edit_tel" class="form-control" value="<?php echo $tel; ?>">
                            </div>
                            <div class="form-group">
                                <label>Web</label>
                                <input id="edit_web" class="form-control" value="<?php echo $web; ?>">
                            </div>
                            <div class="form-group">
                                <label>Tipus de reserva</label>
                                <select id="edit_etype" class="form-control">
                                    <option value="0" <?php if($type==0) echo 'selected="selected"'; ?>><?php echo translate("Allotjament sencer", $lang); ?></option>
                                    <option value="1" <?php if($type==1) echo 'selected="selected"'; ?>><?php echo translate("Habitacions", $lang); ?></option>
                                </select>
                            </div>                                                                                
-->
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
                        <div class="form-group col-lg-12">
                            <label>Mail notificacions</label>
                            <input type="text" id="edit_col_mail" class="form-control" value="<?php echo $col_mail; ?>">
                            <p class="help-block">Mail per atendre les sol·licituds de reserva</p>
                        </div>
-->
                        
                    </div>                    
                    <!-- /.col-lg-6 (nested) -->                   
                    <div class="col-lg-6">                        
                        <div id="payment_mod">
                            <h2>Modalitats/Preus</h2>
                            <div class="form-group">
                                <button id="new_mod" class="btn btn-primary">Afegir</button>
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
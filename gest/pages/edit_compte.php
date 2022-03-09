<?php
    $id = intval($_GET['id']);
    global $mysqli;
    global $lang;
    global $zone;    

    if($id>0)
    {
        $sql="SELECT nom,propietari,tpv_merchantCode,tpv_terminal,tpv_currency,tpv_key,tpv_url,btype_0,btype_1,btype_2,btype_3,btype_4,btype_5,mail,lopd,bizum,btype_6,btype_7,versio FROM comptes WHERE id='$id'";
        $res = $mysqli->query($sql);
        $row = $res->fetch_row();
        $nom = $row[0];
        $cuser = $row[1];
        $tpv_merchantcode = $row[2];
        $tpv_terminal = $row[3];
        $tpv_currency = $row[4];
        $tpv_key = $row[5];
        $tpv_url = $row[6];
        $btype_0 = $row[7];
        $btype_1 = $row[8];
        $btype_2 = $row[9];
        $btype_3 = $row[10];
        $btype_4 = $row[11];
        $btype_5 = $row[12];
        $btype_6 = $row[16];
        $btype_7 = $row[17];
        $mail = $row[13];        
        $lopd = stripslashes($row[14]);
        $propietari = GetUInfo($mysqli,$row[1]);
        $uactivities = GetActivitiesfromUser($mysqli,$id);
        $num_btype_0 = $uactivities['btype_0'];
        $num_btype_1 = $uactivities['btype_1'];
        $num_btype_2 = $uactivities['btype_2'];
        $num_btype_3 = $uactivities['btype_3'];
        $num_btype_4 = $uactivities['btype_4'];
        $num_btype_5 = $uactivities['btype_5'];
        $num_btype_6 = $uactivities['btype_6'];
        $num_btype_7 = $uactivities['btype_7'];
        $bizum = intval($row[15]);
        $versio = intval($row[18]);  
    }
    else
    {   
        $nom = "";
        $cuser = -1;        
        $tpv_merchantcode = "";
        $tpv_terminal = "";
        $tpv_currency = "";
        $tpv_key = "";
        $tpv_url = "";
        $btype_0 = 10;
        $btype_1 = 10;
        $btype_2 = 10;
        $btype_3 = 0;
        $btype_4 = 0;
        $btype_5 = 0;
        $btype_6 = 0;
        $btype_7 = 0;
        $mail = "";        
        $lopd = "";
        $propietari = "";
        $num_btype_0 = 0;
        $num_btype_1 = 0;
        $num_btype_2 = 0;
        $num_btype_3 = 0;
        $num_btype_4 = 0;
        $num_btype_5 = 0;
        $num_btype_6 = 0;
        $num_btype_7 = 0;
        $bizum = 0;
        $versio = 1;
    }

    $users = GetUsersInfo($mysqli);
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
                    path: '<?php echo $rootfolder . "boxes/"; ?>',
                    name: '<?php echo "logo_image_" . $id . ".png"; ?>',
                },
                dataType: 'json',
                cache: false,
                disableImageResize: /Android(?!.*Chrome)|Opera/
                    .test(window.navigator && navigator.userAgent),                
                imageCrop: false,
                done: function (e, data) {
                    var str="";
                    str += '<li class="img_frame">';
                    str += '<div class="img_options"><a class="del_image"><?php echo translate("Elimina", $lang); ?></a></div>';
                    str += '<img width="100px" src="';
                    str = str + '<?php echo $rootfolder; ?>' + 'boxes/';
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
        });
        
        initialize();
        
        $('#save').one('click',function(){
            validate_compte();
        });
        
        $('#cancel').one('click',function(){
            window.location.href = '/admin/5';
        });
        
        function initialize()
        {
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

                aux = '#image_0';
                $(aux).append(str);
                ResetEvents();
            }
            img.src = '<?php echo $rootfolder . "boxes/logo_image_" . $id . ".png?nocache=" . rand(); ?>';
        }
        
        function ResetEvents()
        {                            
            $('.del_image').off('click');
            $('.del_image').on('click',function(){
                $(this).parent().parent().remove();
                
                $.ajax({  
                    type: "POST",  
                    url: "<?php echo $rootfolder; ?>" + "/php/server_actions.php",  
                    data: {
                        op:"delete_logo_image",
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
                
        
        function validate_compte()
        {
            $('#edit_name').val()=="" ? $('#edit_name').parent().addClass('has-error') : $('#edit_name').parent().removeClass('has-error');            

            if($('#edit_name').val()!="")
            {                
                $.ajax({  
                    type: "POST",  
                    url: "<?php echo $rootfolder; ?>" +"php/server_actions.php",  
                    data: {
                        op:"edit_compte",
                        id:'<?php echo $id; ?>',
                        name:$('#edit_name').val(),
                        user:$('#edit_user').val(),
                        merchantcode:$('#edit_merchantcode').val(),
                        terminal:$('#edit_terminal').val(),
                        currency:$('#edit_currency').val(),
                        key:$('#edit_key').val(),
                        url:$('#edit_url').val(),
                        btype_0:$('#edit_btype_0').val(),
                        btype_1:$('#edit_btype_1').val(),
                        btype_2:$('#edit_btype_2').val(),
                        btype_3:$('#edit_btype_3').val(),
                        btype_4:$('#edit_btype_4').val(),
                        btype_5:$('#edit_btype_5').val(),
                        btype_6:$('#edit_btype_6').val(),
                        btype_7:$('#edit_btype_7').val(),
                        mail:$('#edit_mail').val(),
                        lopd:$('#edit_lopd').val(),
                        bizum:$('#edit_bizum').is(":checked")?1:0,
                        versio:$('#edit_versio').val(),
                    },
                }).success(function(ret)
                {
                    window.location.href = '/admin/5';
                });
            }
            else
            {
                $('#save').one('click',function(){
                    validate_compte();
                });
            }
        }
    });
</script>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Edita el compte</h1>
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
                        echo "<h4>" . "Nou compte" . "</h4>";
                    }
                    else
                    {
                        echo "<h4>" . $nom . "</h4>";
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
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Nom</label>
                                <input id="edit_name" class="form-control" value="<?php echo $nom; ?>">
                            </div>
                        </div>
                        <div class="col-lg-6">                      
                            <div class="form-group">
                                <label>Usuari</label>
                                <select id="edit_user" class="form-control">                                    
                                <?php
                                foreach ($users as $user)
                                {?>
                                <option value="<?php echo $user['id']; ?>" <?php if($cuser==$user['id']) echo 'selected="selected"'; ?>><?php echo $user['name'] . ' ' . $user['surnames']; ?></option>
                                <?php
                                }?>                            
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">    
                            <div class="form-group">
                                <label>Versió BTiquets</label>
                                <select id="edit_versio" class="form-control">
                                    <option value='1' <?php if($versio==1) echo 'selected="selected"'; ?>>1</option>
                                    <option value='2' <?php if($versio==2) echo 'selected="selected"'; ?>>2</option>
                                </select>
                            </div> 
                        </div>
                        <div class="col-lg-6">    
                            <div class="form-group">
                                <label>Mail atenció al client</label>
                                <input id="edit_mail" class="form-control" value="<?php echo $mail; ?>">
                            </div>
                        </div>
                        <div class="col-lg-12">    
                            <div class="form-group">
                                <label>LOPD</label>
                                <textarea id="edit_lopd" class="form-control"><?php echo $lopd; ?></textarea>
                            </div>
                        </div>
                        <div class="col-lg-12">    
                            <div class="form-group" style="display: flex;">    
                                <div class="col-lg-5">
                                    <label><?php echo translate("Logo", $lang); ?></label>
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
                        </div>                                                                        
                    </div>
                    <div class="col-lg-6">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Sessió única</label>
                                <input id="edit_btype_0" class="form-control" value="<?php echo $btype_0; ?>">
                                <input disabled id="num_btype_0" class="form-control" value="<?php echo $num_btype_0; ?>">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Sessions múltiples</label>
                                <input id="edit_btype_1" class="form-control" value="<?php echo $btype_1; ?>">
                                <input disabled id="num_btype_1" class="form-control" value="<?php echo $num_btype_1; ?>">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Restaurant (s/pagament)</label>
                                <input id="edit_btype_2" class="form-control" value="<?php echo $btype_2; ?>">
                                <input disabled id="num_btype_2" class="form-control" value="<?php echo $num_btype_2; ?>">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Suite allotjaments</label>
                                <input id="edit_btype_3" class="form-control" value="<?php echo $btype_3; ?>">
                                <input disabled id="num_btype_3" class="form-control" value="<?php echo $num_btype_3; ?>">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Productes simples</label>
                                <input id="edit_btype_4" class="form-control" value="<?php echo $btype_4; ?>">
                                <input disabled id="num_btype_4" class="form-control" value="<?php echo $num_btype_4; ?>">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Productes avançats</label>
                                <input id="edit_btype_5" class="form-control" value="<?php echo $btype_5; ?>">
                                <input disabled id="num_btype_5" class="form-control" value="<?php echo $num_btype_5; ?>">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Data oberta</label>
                                <input id="edit_btype_6" class="form-control" value="<?php echo $btype_6; ?>">
                                <input disabled id="num_btype_6" class="form-control" value="<?php echo $num_btype_6; ?>">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Aportació voluntària</label>
                                <input id="edit_btype_7" class="form-control" value="<?php echo $btype_7; ?>">
                                <input disabled id="num_btype_7" class="form-control" value="<?php echo $num_btype_7; ?>">
                            </div>
                        </div>
                        <div class="col-lg-6">
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>TPV - Codi del começ</label>
                                <input id="edit_merchantcode" class="form-control" value="<?php echo $tpv_merchantcode; ?>">
                            </div>
                            <div class="form-group">
                                <label>TPV - Terminal</label>
                                <input id="edit_terminal" class="form-control" value="<?php echo $tpv_terminal; ?>">
                            </div> 
                            <div class="form-group">
                                <label>TPV - Codi moneda</label>
                                <input id="edit_currency" class="form-control" value="<?php echo $tpv_currency; ?>">
                            </div> 
                            <div class="form-group">
                                <label>TPV - Clau</label>
                                <input id="edit_key" class="form-control" value="<?php echo $tpv_key; ?>">
                            </div> 
                            <div class="form-group">
                                <label>TPV - URL</label>
                                <input id="edit_url" class="form-control" value="<?php echo $tpv_url; ?>">
                            </div> 
                            <div class="form-group">
                                <label>BIZUM</label>
                                <input id="edit_bizum" type="checkbox" <?php if($bizum) echo 'checked'; ?>>
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
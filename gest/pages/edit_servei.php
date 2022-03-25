<?php
    $id = intval($_GET['id']);
    global $mysqli;
    global $lang;
    global $zone;    

    if($id>0)
    {
        $sql="SELECT * FROM serveis WHERE id='$id'";
        $res = $mysqli->query($sql);
        $row = $res->fetch_row();
        $clientid = intval($row[1]);
        $estat = intval($row[2]);
        $adminid = intval($row[3]);
        $notes = stripslashes($row[4]);
        $n_persones = intval($row[5]);
        $base_total = floatval($row[6]);
        $iva_total = floatval($row[7]);
        $espai_1 = intval($row[12]);
        $espai_2 = intval($row[13]);
        $espai_3 = intval($row[14]);
        $espai_4 = intval($row[15]);
        $guia_1 = intval($row[17]);
        $guia_2 = intval($row[18]);
        $guia_3 = intval($row[19]);
        $guia_4 = intval($row[20]);

    }
    else
    {   
        $clientid = -1;
        $estat = -1;
        $adminid = -1;
        $notes = "";
        $n_persones = 0;
        $base_total = 0;
        $iva_total = 0;
        $espai_1 = -1;
        $espai_2 = -1;
        $espai_3 = -1;
        $espai_4 = -1;
        $guia_1 = -1;
        $guia_2 = -1;
        $guia_3 = -1;
        $guia_4 = -1;
    }

    $compte = GetAccountfromUserInfo($mysqli,$_SESSION['user_id']);
    $clients = GetDBData("clients","propietari=".$compte['id'],"nom_entitat");
    $admins = GetDBData("administradors","propietari=".$compte['id'],"nom");
    $espais = GetDBData("espais","propietari=".$compte['id'],"nom");
    $guies = GetDBData("guies","propietari=".$compte['id'],"name");
?>

<script type="text/javascript">
        
    $(document).ready(function()
    {     
        
        $('#save').one('click',function(){
            validate_servei();
        });
        
        $('#cancel').one('click',function(){
            window.location.href = '/admin/18';
        });

        $('#edit_client').on('change',function(){
            if($(this).val()>0) $('#nou-client-grup').hide();
            else $('#nou-client-grup').show();
        });
            
        
        function validate_servei()
        {
            $('#edit_name').val()=="" ? $('#edit_name').parent().addClass('has-error') : $('#edit_name').parent().removeClass('has-error');            

            if($('#edit_name').val()!="")
            {                
                $.ajax({  
                    type: "POST",  
                    url: "<?php echo $rootfolder; ?>" +"php/server_actions.php",  
                    data: {
                        op:"edit_servei",
                        id:'<?php echo $id; ?>',
                        client:$('#edit_client').val(),
                        estat:$('#edit_estat').val(),
                        admin:$('#edit_admin').val(),
                        notes:$('#edit_notes').val(),
                        n_persones:$('#edit_n_persones').val(),
                        base_total:$('#edit_base_total').val(),
                        iva_total:$('#edit_iva_total').val(),
                        propietari:'<?php echo $compte["id"]; ?>',
                    },
                }).success(function(ret)
                {
                    window.location.href = '/admin/18';
                });
            }
            else
            {
                $('#save').one('click',function(){
                    validate_servei();
                });
            }
        }
    });
</script>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Edita el servei</h1>
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
                        echo "<h4>" . "Nou servei" . "</h4>";
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
                        <h4 class="mb-10">Dades client</h4>
                        <div class="row mb-25">
                            <div class="col-lg-12">    
                                <div class="form-group">
                                    <label>Client</label>
                                    <select id="edit_client" class="form-control">
                                        <option value='-1'>Nou client</option>
                                        <?php
                                        foreach($clients as $client) {?>
                                        <option value='<?php echo $client[0];?>' <?php if($clientid==$client[0]) echo 'selected="selected"'; ?>><?php echo ($client[1]!=""?$client[1]:$client[2]);?></option>
                                        <?php
                                        }?>
                                    </select>
                                </div> 
                            </div>
                            <div id="nou-client-grup">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Nom entitat</label>
                                        <input id="edit_name_1" class="form-control" value="<?php echo $nom_entitat; ?>">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Nom contacte</label>
                                        <input id="edit_name_2" class="form-control" value="<?php echo $nom_contacte; ?>">
                                    </div>
                                </div>                        
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>NIF</label>
                                        <input id="edit_nif" class="form-control" value="<?php echo $nif; ?>">
                                    </div>
                                </div>
                                <div class="col-lg-6">    
                                    <div class="form-group">
                                        <label>Genere</label>
                                        <select id="edit_genere" class="form-control">
                                            <option value="-1" <?php if($genere<=0) echo 'selected'; ?>>-</option>
                                            <option value="1" <?php if($genere==1) echo 'selected'; ?>>Home</option>
                                            <option value="2" <?php if($genere==2) echo 'selected'; ?>>Dona</option>
                                            <option value="3" <?php if($genere==3) echo 'selected'; ?>>No binari</option>
                                        </select>
                                    </div> 
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Telèfon</label>
                                        <input id="edit_tel" class="form-control" value="<?php echo $tel; ?>">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Mail</label>
                                        <input id="edit_mail" class="form-control" value="<?php echo $mail; ?>">
                                    </div>
                                </div>                        
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Adreça</label>
                                        <input id="edit_adr_1" class="form-control" value="<?php echo $adr_1; ?>">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Codi Postal</label>
                                        <input id="edit_cp" class="form-control" value="<?php echo $cp; ?>">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Municipi</label>
                                        <input id="edit_ciutat" class="form-control" value="<?php echo $ciutat; ?>">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>País</label>
                                        <input id="edit_pais" class="form-control" value="<?php echo $pais; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-25">
                            <div class="col-lg-6">    
                                <div class="form-group">
                                    <label>Administrador</label>
                                    <select id="edit_admin" class="form-control">
                                        <option value='-1'>-</option>
                                        <?php
                                        foreach($admins as $adminiter) {?>
                                        <option value='<?php echo $adminiter[0];?>' <?php if($adminid==$adminiter[0]) echo 'selected="selected"'; ?>><?php echo $adminiter[1];?></option>
                                        <?php
                                        }?>
                                    </select>
                                </div> 
                            </div> 
                        </div>
                        <div class="row mb-40">
                            <div class="col-lg-12">    
                                <div class="form-group">
                                    <label>Notes</label>
                                    <textarea id="edit_notes" class="form-control"><?php echo $notes; ?></textarea>
                                </div>
                            </div> 
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <h4 class="mb-10">Dades Servei</h4>
                        <div class="row mb-25">
                            <div class="col-lg-6">    
                                <div class="form-group">
                                    <label>Espai 1</label>
                                    <select id="edit_espai_1" class="form-control">
                                        <option value='-1'>-</option>
                                        <?php
                                        foreach($espais as $espai) {?>
                                        <option value='<?php echo $espai[0];?>' <?php if($espai_1==$espai[0]) echo 'selected="selected"'; ?>><?php echo $espai[1];?></option>
                                        <?php
                                        }?>
                                    </select>
                                </div> 
                                <div class="form-group">
                                    <label>Espai 2</label>
                                    <select id="edit_espai_2" class="form-control">
                                        <option value='-1'>-</option>
                                        <?php
                                        foreach($espais as $espai) {?>
                                        <option value='<?php echo $espai[0];?>' <?php if($espai_2==$espai[0]) echo 'selected="selected"'; ?>><?php echo $espai[1];?></option>
                                        <?php
                                        }?>
                                    </select>
                                </div>  
                                <div class="form-group">
                                    <label>Espai 3</label>
                                    <select id="edit_espai_3" class="form-control">
                                        <option value='-1'>-</option>
                                        <?php
                                        foreach($espais as $espai) {?>
                                        <option value='<?php echo $espai[0];?>' <?php if($espai_3==$espai[0]) echo 'selected="selected"'; ?>><?php echo $espai[1];?></option>
                                        <?php
                                        }?>
                                    </select>
                                </div> 
                                <div class="form-group">
                                    <label>Espai 4</label>
                                    <select id="edit_espai_4" class="form-control">
                                        <option value='-1'>-</option>
                                        <?php
                                        foreach($espais as $espai) {?>
                                        <option value='<?php echo $espai[0];?>' <?php if($espai_4==$espai[0]) echo 'selected="selected"'; ?>><?php echo $espai[1];?></option>
                                        <?php
                                        }?>
                                    </select>
                                </div> 
                            </div> 
                            <div class="col-lg-6">    
                                <div class="form-group">
                                    <label>Guia 1</label>
                                    <select id="edit_guia_1" class="form-control">
                                        <option value='-1'>-</option>
                                        <?php
                                        foreach($guies as $guia) {?>
                                        <option value='<?php echo $guia[0];?>' <?php if($guia_1==$guia[0]) echo 'selected="selected"'; ?>><?php echo $guia[1];?></option>
                                        <?php
                                        }?>
                                    </select>
                                </div> 
                                <div class="form-group">
                                    <label>Guia 2</label>
                                    <select id="edit_guia_2" class="form-control">
                                        <option value='-1'>-</option>
                                        <?php
                                        foreach($guies as $guia) {?>
                                        <option value='<?php echo $guia[0];?>' <?php if($guia_2==$guia[0]) echo 'selected="selected"'; ?>><?php echo $guia[1];?></option>
                                        <?php
                                        }?>
                                    </select>
                                </div>  
                                <div class="form-group">
                                    <label>Guia 3</label>
                                    <select id="edit_guia_3" class="form-control">
                                        <option value='-1'>-</option>
                                        <?php
                                        foreach($guies as $guia) {?>
                                        <option value='<?php echo $guia[0];?>' <?php if($guia_3==$guia[0]) echo 'selected="selected"'; ?>><?php echo $guia[1];?></option>
                                        <?php
                                        }?>
                                    </select>
                                </div> 
                            </div> 
                            <div class="col-lg-6">    
                                <div class="form-group">
                                    <label>Guia 4</label>
                                    <select id="edit_guia_4" class="form-control">
                                        <option value='-1'>-</option>
                                        <?php
                                        foreach($guies as $guia) {?>
                                        <option value='<?php echo $guia[0];?>' <?php if($guia_4==$guia[0]) echo 'selected="selected"'; ?>><?php echo $guia[1];?></option>
                                        <?php
                                        }?>
                                    </select>
                                </div> 
                            </div> 
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Número de persones</label>
                                    <input id="edit_name" class="form-control" value="<?php echo $n_persones; ?>">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Base total</label>
                                    <input id="edit_cognom" class="form-control" value="<?php echo $base_total; ?>">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>IVA total</label>
                                    <input id="edit_cognom" class="form-control" value="<?php echo $iva_total; ?>">
                                </div>
                            </div>
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
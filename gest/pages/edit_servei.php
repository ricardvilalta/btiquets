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

        // $espais = 
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
    }

    $compte = GetAccountfromUserInfo($mysqli,$_SESSION['user_id']);
    $clients = GetDBData("clients","propietari=".$compte['id'],"nom_entitat");
    $admins = GetDBData("administradors","propietari=".$compte['id'],"nom");
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
                        <div class="col-lg-12">    
                            <div class="form-group">
                                <label>Notes</label>
                                <textarea id="edit_notes" class="form-control"><?php echo $notes; ?></textarea>
                            </div>
                        </div>
                        <div class="col-lg-6">    
                            <div class="form-group">
                                <label>Client</label>
                                <select id="edit_client" class="form-control">
                                    <option value='-1'>-</option>
                                    <?php
                                    foreach($clients as $client) {?>
                                    <option value='<?php echo $client[0];?>' <?php if($clientid==$client[0]) echo 'selected="selected"'; ?>><?php echo ($client[1]!=""?$client[1]:$client[2]);?></option>
                                    <?php
                                    }?>
                                </select>
                            </div> 
                        </div>  
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
                    <div class="col-lg-6">
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
                <!-- /.row (nested) -->
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
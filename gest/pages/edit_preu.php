<?php
    $id = intval($_GET['id']);
    global $mysqli;
    global $lang;
    global $zone;    

    if($id>0)
    {
        $sql="SELECT * FROM preus WHERE id='$id'";
        $res = $mysqli->query($sql);
        $row = $res->fetch_row();
        $nom = stripslashes($row[1]);
        $descripcio = stripslashes($row[2]);
        $base = floatval($row[3]);
        $iva = intval($row[4]);
    }
    else
    {   
        $nom = "";
        $descripcio = "";
        $base = 0;
        $iva = 0;
    }
?>

<script type="text/javascript">
        
    $(document).ready(function()
    {     
        
        $('#save').one('click',function(){
            validate_preu();
        });
        
        $('#cancel').one('click',function(){
            window.location.href = '/admin/20';
        });
                
        
        function validate_preu()
        {
            $('#edit_name').val()=="" ? $('#edit_name').parent().addClass('has-error') : $('#edit_name').parent().removeClass('has-error');            

            if($('#edit_name').val()!="")
            {                
                $.ajax({  
                    type: "POST",  
                    url: "<?php echo $rootfolder; ?>" +"php/server_actions.php",  
                    data: {
                        op:"edit_preu",
                        id:'<?php echo $id; ?>',
                        nom:$('#edit_nom').val(),
                        descripcio:$('#edit_descripcio').val(),
                        base:$('#edit_base').val(),
                        iva:$('#edit_iva').val(),
                        propietari:'<?php echo $compte["id"]; ?>',
                    },
                }).success(function(ret)
                {
                    window.location.href = '/admin/20';
                });
            }
            else
            {
                $('#save').one('click',function(){
                    validate_preu();
                });
            }
        }
    });
</script>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Edita el preu</h1>
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
                        echo "<h4>" . "Nou preu" . "</h4>";
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
                                <label>Nom</label>
                                <input id="edit_nom" class="form-control" value="<?php echo $nom; ?>">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Descripció</label>
                                <textarea id="edit_descripcio" class="form-control" rows="3"><?php echo $descripcio; ?></textarea>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>Base</label>
                                <input type="number" id="edit_base" class="form-control" value="<?php echo $base; ?>" placeholder="Base">
                            </div> 
                        </div>  
                        <div class="col-lg-3">    
                            <div class="form-group">
                                <label>Tipus IVA</label>
                                <select id="edit_iva" class="form-control">
                                    <option value='0' <?php if($iva==0) echo 'selected="selected"'; ?>><?php echo _TIPUSIVA[0]; ?></option>
                                    <option value='1' <?php if($iva==1) echo 'selected="selected"'; ?>><?php echo _TIPUSIVA[1]; ?></option>
                                    <option value='2' <?php if($iva==2) echo 'selected="selected"'; ?>><?php echo _TIPUSIVA[2]; ?></option>
                                    <option value='3' <?php if($iva==3) echo 'selected="selected"'; ?>><?php echo _TIPUSIVA[3]; ?></option>
                                </select>
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
<?php
    $id = intval($_GET['id']);
    global $mysqli;
    global $lang;
    global $zone;    

    if($id>0)
    {
        $sql="SELECT * FROM descomptes WHERE id='$id'";
        $res = $mysqli->query($sql);
        $row = $res->fetch_row();
        $nom = stripslashes($row[1]);
        $codi = stripslashes($row[2]);
        $type = intval($row[3]);
        $valor = floatval($row[4]);
    }
    else
    {   
        $nom = "";
        $codi = "";        
        $type = "";
        $valor = 0;
    }
?>

<script type="text/javascript">
        
    $(document).ready(function()
    {     
        
        $('#save').one('click',function(){
            validate_descompte();
        });
        
        $('#cancel').one('click',function(){
            window.location.href = '/admin/22';
        });
        
        
        function validate_descompte()
        {
            $('#edit_name').val()=="" ? $('#edit_name').parent().addClass('has-error') : $('#edit_name').parent().removeClass('has-error');            

            if($('#edit_name').val()!="")
            {                
                $.ajax({  
                    type: "POST",  
                    url: "<?php echo $rootfolder; ?>" +"php/server_actions.php",  
                    data: {
                        op:"edit_descompte",
                        id:'<?php echo $id; ?>',
                        nom:$('#edit_name').val(),
                        codi:$('#edit_codi').val(),
                        type:$('#edit_type').val(),
                        valor:$('#edit_valor').val(),
                        propietari:'<?php echo $compte["id"]; ?>',
                    },
                }).success(function(ret)
                {
                    window.location.href = '/admin/32';
                });
            }
            else
            {
                $('#save').one('click',function(){
                    validate_descompte();
                });
            }
        }
    });
</script>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Edita el descompte</h1>
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
                        echo "<h4>" . "Nou descompte" . "</h4>";
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
                                <label>Codi</label>
                                <input id="edit_codi" class="form-control" value="<?php echo $codi; ?>">
                            </div>
                        </div>
                        <div class="col-lg-3">    
                            <div class="form-group">
                                <label>Tipus</label>
                                <select id="edit_type" class="form-control">
                                    <option value='0' <?php if($type==0) echo 'selected="selected"'; ?>>Import</option>
                                    <option value='1' <?php if($type==1) echo 'selected="selected"'; ?>>Percentatge</option>
                                </select>
                            </div> 
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>Valor</label>
                                <input id="edit_valor" type="number" class="form-control" value="<?php echo $valor; ?>">
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
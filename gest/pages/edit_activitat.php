<?php
    $id = intval($_GET['id']);
    global $mysqli;
    global $lang;
    global $zone;    

    if($id>0)
    {
        $sql="SELECT * FROM activitats WHERE id='$id'";
        $res = $mysqli->query($sql);
        $row = $res->fetch_row();
        $nom = stripslashes($row[1]);
        $descripcio = stripslashes($row[2]);
        $espai = intval($row[3]);
        $preu = intval($row[4]);
        $tipus = intval($row[6]);
    }
    else
    {   
        $nom = "";
        $descripcio = "";        
        $espai = -1;
        $preu = -1;
        $tipus = -1;
    }

    $espais = GetDBData("espais", "propietari=" . $compte['id'], "nom");
    $preus = GetDBData("preus", "propietari=" . $compte['id'], "nom");
?>

<script type="text/javascript">
        
    $(document).ready(function()
    {     
        
        $('#save').one('click',function(){
            validate_activitat();
        });
        
        $('#cancel').one('click',function(){
            window.location.href = '/admin/30';
        });   
        
        function validate_activitat()
        {
            $('#edit_name').val()=="" ? $('#edit_name').parent().addClass('has-error') : $('#edit_name').parent().removeClass('has-error');            

            if($('#edit_name').val()!="")
            {                
                $.ajax({  
                    type: "POST",  
                    url: "<?php echo $rootfolder; ?>" +"php/server_actions.php",  
                    data: {
                        op:"edit_activitat",
                        id:'<?php echo $id; ?>',
                        nom:$('#edit_name').val(),
                        descripcio:$('#edit_descricio').val(),
                        espai:$('#edit_espai').val(),
                        preu:$('#edit_preu').val(),
                        tipus:$('#edit_tipus').val(),
                        propietari:'<?php echo $compte["id"]; ?>',
                    },
                }).success(function(ret)
                {
                    window.location.href = '/admin/30';
                });
            }
            else
            {
                $('#save').one('click',function(){
                    validate_activitat();
                });
            }
        }
    });
</script>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Edita l'activitat</h1>
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
                        echo "<h4>" . "Nova activitat" . "</h4>";
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
                                <label>Descripció</label>
                                <input id="edit_descricio" class="form-control" value="<?php echo $descripcio; ?>">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Espai</label>
                                <select id="edit_espai" class="form-control">
                                    <option value='-1'>-</option>
                                    <?php
                                    foreach ($espais as $espaiiter) { ?>
                                        <option value='<?php echo $espaiiter[0]; ?>' <?php if ($espai == $espaiiter[0]) echo 'selected="selected"'; ?>><?php echo $espaiiter[1]; ?></option>
                                    <?php
                                    } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Preu</label>
                                <select id="edit_preu" class="form-control">
                                    <option value='-1'>-</option>
                                    <?php
                                    foreach ($preus as $preuiter) { ?>
                                        <option value='<?php echo $preuiter[0]; ?>' <?php if ($preu == $preuiter[0]) echo 'selected="selected"'; ?>><?php echo $preuiter[1]; ?></option>
                                    <?php
                                    } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Tipus</label>
                                <select id="edit_tipus" class="form-control">
                                    <?php
                                    foreach ($tipusactivitat as $key=>$iter) { ?>
                                        <option value='<?php echo $key; ?>' <?php if ($tipus == $key) echo 'selected="selected"'; ?>><?php echo $iter; ?></option>
                                    <?php
                                    } ?>
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
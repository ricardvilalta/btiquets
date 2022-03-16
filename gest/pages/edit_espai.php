<?php
    $id = intval($_GET['id']);
    global $mysqli;
    global $lang;
    global $zone;    

    if($id>0)
    {
        $sql="SELECT * FROM espais WHERE id='$id'";
        $res = $mysqli->query($sql);
        $row = $res->fetch_row();
        $nom = stripslashes($row[1]);
        $descripcio = stripslashes($row[2]);
        $estat = intval($row[3]);
    }
    else
    {   
        $nom = "";
        $descripcio = "";        
        $estat = 0;
    }
?>

<script type="text/javascript">
        
    $(document).ready(function()
    {     
        
        $('#save').one('click',function(){
            validate_espai();
        });
        
        $('#cancel').one('click',function(){
            window.location.href = '/admin/24';
        });   
        
        function validate_espai()
        {
            $('#edit_name').val()=="" ? $('#edit_name').parent().addClass('has-error') : $('#edit_name').parent().removeClass('has-error');            

            if($('#edit_name').val()!="")
            {                
                $.ajax({  
                    type: "POST",  
                    url: "<?php echo $rootfolder; ?>" +"php/server_actions.php",  
                    data: {
                        op:"edit_espai",
                        id:'<?php echo $id; ?>',
                        nom:$('#edit_name').val(),
                        descripcio:$('#edit_descricio').val(),
                        estat:$('#edit_estat').val(),
                        propietari:'<?php echo $compte["id"]; ?>',
                    },
                }).success(function(ret)
                {
                    window.location.href = '/admin/24';
                });
            }
            else
            {
                $('#save').one('click',function(){
                    validate_espai();
                });
            }
        }
    });
</script>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Edita l'espai</h1>
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
                        echo "<h4>" . "Nou espai" . "</h4>";
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
                        <div class="col-lg-3">    
                            <div class="form-group">
                                <label>Estat</label>
                                <select id="edit_estat" class="form-control">
                                    <option value='1' <?php if($estat==1) echo 'selected="selected"'; ?>>Actiu</option>
                                    <option value='0' <?php if($estat==0) echo 'selected="selected"'; ?>>Inactiu</option>
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
<?php
    $id = intval($_GET['id']);
    global $mysqli;
    global $lang;
    global $zone;    

    if($id>0)
    {
        $sql="SELECT * FROM administradors WHERE id='$id'";
        $res = $mysqli->query($sql);
        $row = $res->fetch_row();
        $nom = stripslashes($row[1]);
    }
    else
    {   
        $nom = "";
    }
?>

<script type="text/javascript">
        
    $(document).ready(function()
    {     
        
        $('#save').one('click',function(){
            validate_administrador();
        });
        
        $('#cancel').one('click',function(){
            window.location.href = '/admin/26';
        });
        
        function validate_administrador()
        {
            $('#edit_name').val()=="" ? $('#edit_name').parent().addClass('has-error') : $('#edit_name').parent().removeClass('has-error');            

            if($('#edit_name').val()!="")
            {                
                $.ajax({  
                    type: "POST",  
                    url: "<?php echo $rootfolder; ?>" +"php/server_actions.php",  
                    data: {
                        op:"edit_administrador",
                        id:'<?php echo $id; ?>',
                        nom:$('#edit_name').val(),
                        propietari:'<?php echo $compte["id"]; ?>',
                    },
                }).success(function(ret)
                {
                    window.location.href = '/admin/26';
                });
            }
            else
            {
                $('#save').one('click',function(){
                    validate_administrador();
                });
            }
        }
    });
</script>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Edita l'administrador</h1>
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
                        echo "<h4>" . "Nou administrador" . "</h4>";
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
                    <div class="col-lg-12">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Nom</label>
                                <input id="edit_name" class="form-control" value="<?php echo $nom; ?>">
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
<?php
    $id = intval($_GET['id']);
    global $mysqli;
    global $lang;
    global $zone;    

    if($id>0)
    {
        $sql="SELECT * FROM guies WHERE id='$id'";
        $res = $mysqli->query($sql);
        $row = $res->fetch_row();
        $nom = stripslashes($row[1]);
        $cognom = stripslashes($row[2]);
        $type = intval($row[3]);
    }
    else
    {   
        $nom = "";
        $cognom = "";        
        $type = "";
    }
?>

<script type="text/javascript">
        
    $(document).ready(function()
    {     
        
        $('#save').one('click',function(){
            validate_guia();
        });
        
        $('#cancel').one('click',function(){
            window.location.href = '/admin/22';
        });
        
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
                
        
        function validate_guia()
        {
            $('#edit_name').val()=="" ? $('#edit_name').parent().addClass('has-error') : $('#edit_name').parent().removeClass('has-error');            

            if($('#edit_name').val()!="")
            {                
                $.ajax({  
                    type: "POST",  
                    url: "<?php echo $rootfolder; ?>" +"php/server_actions.php",  
                    data: {
                        op:"edit_guia",
                        id:'<?php echo $id; ?>',
                        nom:$('#edit_name').val(),
                        cognom:$('#edit_cognom').val(),
                        type:$('#edit_type').val(),
                        propietari:'<?php echo $compte["id"]; ?>',
                    },
                }).success(function(ret)
                {
                    window.location.href = '/admin/22';
                });
            }
            else
            {
                $('#save').one('click',function(){
                    validate_guia();
                });
            }
        }
    });
</script>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Edita el guia</h1>
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
                        echo "<h4>" . "Nou guia" . "</h4>";
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
                                <label>Cognom</label>
                                <input id="edit_cognom" class="form-control" value="<?php echo $cognom; ?>">
                            </div>
                        </div>
                        <div class="col-lg-3">    
                            <div class="form-group">
                                <label>Tipus</label>
                                <select id="edit_type" class="form-control">
                                    <option value='1' <?php if($type==1) echo 'selected="selected"'; ?>>1</option>
                                    <option value='2' <?php if($type==2) echo 'selected="selected"'; ?>>2</option>
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
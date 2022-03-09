<?php
    global $mysqli;
    global $id;
    global $lang;
    global $zone;    
    
    if($id>0)
    {   
        $sql="SELECT name,description,type,deststr FROM enviaments WHERE id='$id'";
        
        $res = $mysqli->query($sql);
        $row = $res->fetch_row();
        $name = $row[0];        
        $description = $row[1];
        $type = intval($row[2]);
        $deststr = $row[3];
        
        // decodifico l'string de destinacions i preus
        $destarray = decode_deststr($deststr,false);
    }
    else
    {
        $name = "";
        $description  = "";
        $type = 0;
        $deststr = "";
        
        $destarray = decode_deststr($deststr,true);
    }    


    $compte = GetAccountfromUserInfo($mysqli,$_SESSION['user_id']);    
?>

<script type="text/javascript">
        
    $(document).ready(function()
    {                          
        $('#save').one('click',function(){
            validate_box();
        });
        
        $('#cancel').one('click',function(){
            window.location.href = '/admin/9';
        });
                
        
        function validate_box()
        {            
            $('#edit_title').val()=="" ? $('#edit_title').parent().addClass('has-error') : $('#edit_title').parent().removeClass('has-error');
            
            if($('#edit_title').val()!="")
            {                
                var deststr = "";
                $("#destination-table > tbody > tr").each(function() {
                    deststr += $(this).find('.dest-nom').html();
                    deststr += ':';
                    deststr += $(this).find('.dest-act > input').is(':checked')?1:0;
                    deststr += ':';
                    deststr += $(this).find('.dest-val > input').val();
                    deststr += ';';
                });
                

                $.ajax({  
                    type: "POST",  
                    url: "/php/server_actions.php",
                    data: {
                        op:"insert_enviament",
                        id:'<?php echo $id; ?>',
                        name:$('#edit_title').val(),
                        description:$('#edit_description').val(),
                        type:$('input[name=type-radio]:checked').val(),
                        deststr:deststr,                      
                        propietari:'<?php echo $compte["id"]; ?>',
                    },
                }).success(function(ret)
                {
                    window.location.href = '/admin/9';
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
        <h1 class="page-header">Edita l'enviament</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="col-lg-10">
                    <?php
                    if($id==-1)
                    {
                        echo "<h4>" . "Nou enviament" . "</h4>";
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
                                <label>Nom de l'enviament</label>
                                <input id="edit_title" class="form-control" value="<?php echo $name; ?>">
                            </div>
                            <div class="form-group">
                                <label>Descripció de l'enviament</label>
                                <textarea id="edit_description" class="form-control" rows="3"><?php echo $description; ?></textarea>
                            </div>
                        </div>
                    </div>
                    <!-- /.col-lg-6 (nested) -->
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Tipus d'enviament</label>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="type-radio" value="0" <?php if($type==0) echo 'checked'; ?>>
                                    Preu per comanda
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="type-radio" value="1" <?php if($type==1) echo 'checked'; ?>>
                                    Preu per producte
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="type-radio" value="2" <?php if($type==2) echo 'checked'; ?>>
                                    Recollida
                                </label>
                            </div>
                        </div>
                        <label>Destinacions</label>
                        <div class="form-group">
                            <div class="panel-body">
                                <div class="dataTable_wrapper">
                                    <table class="table table-striped table-bordered table-hover" id="destination-table">
                                        <thead>
                                            <tr>
                                                <th>Província</th>
                                                <th>Activa</th>
                                                <th>Preu</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach($destarray as $desti)
                                            {
                                            ?>
                                            <tr class="">
                                            <td class="dest-nom"><?php echo $desti['nom']; ?></td>
                                            <td class="center dest-act"><input id="" type="checkbox" <?php if($desti['actiu']) echo 'checked'; ?>></td>
                                            <td class="center dest-val"><input id="" type="text" value="<?php echo $desti['val']; ?>"></td>
                                            <?php
                                            }
                                            ?>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
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
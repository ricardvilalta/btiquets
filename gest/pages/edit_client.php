<?php
    $id = intval($_GET['id']);
    global $mysqli;
    global $lang;
    global $zone;    

    if($id>0)
    {
        $sql="SELECT * FROM clients WHERE id='$id'";
        $res = $mysqli->query($sql);
        $row = $res->fetch_row();
        $nom_entitat = stripslashes($row[1]);
        $nom_contacte = stripslashes($row[2]);
        $tel = stripslashes($row[3]);
        $mail = stripslashes($row[4]);
        $genere = intval($row[5]);
        $adr_1 = stripslashes($row[6]);
        $adr_2 = stripslashes($row[7]);
        $cp = stripslashes($row[8]);
        $ciutat = stripslashes($row[9]);
        $pais = stripslashes($row[10]);
        $nif = stripslashes($row[11]);
        $propietari = intval($row[12]);
    }
    else
    {   
        $nom_entitat = "";
        $nom_contacte = "";
        $tel = "";
        $mail = "";
        $genere = 0;
        $adr_1 = "";
        $adr_2 = "";
        $cp = "";
        $ciutat = "";
        $pais = "";
        $nif = "";
        $propietari = -1;
    }
?>

<script type="text/javascript">
        
    $(document).ready(function()
    {     
        
        $('#save').one('click',function(){
            validate_client();
        });
        
        $('#cancel').one('click',function(){
            window.location.href = '/admin/28';
        });
                
        
        function validate_client()
        {            
            $.ajax({  
                type: "POST",  
                url: "<?php echo $rootfolder; ?>" +"php/server_actions.php",  
                data: {
                    op:"edit_client",
                    id:'<?php echo $id; ?>',
                    nom_entitat:$('#edit_name_1').val(),
                    nom_contacte:$('#edit_name_2').val(),
                    tel:$('#edit_tel').val(),
                    mail:$('#edit_mail').val(),
                    genere:$('#edit_genere').val(),
                    adr_1:$('#edit_adr_1').val(),
                    cp:$('#edit_cp').val(),
                    ciutat:$('#edit_ciutat').val(),
                    pais:$('#edit_pais').val(),
                    nif:$('#edit_nif').val(),
                    propietari:'<?php echo $compte["id"]; ?>',
                },
            }).success(function(ret)
            {
                window.location.href = '/admin/28';
            });
        }
    });
</script>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Edita el client</h1>
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
                        echo "<h4>" . "Nou client" . "</h4>";
                    }
                    else
                    {
                        echo "<h4>" . ($nom_entitat!=""?$nom_entitat:$nom_contacte) . "</h4>";
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
                        <div class="col-lg-3">    
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
                <!-- /.row (nested) -->
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
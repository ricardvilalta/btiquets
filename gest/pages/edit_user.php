<script type="text/javascript" src="/js/sha512.js"></script>
<script type="text/javascript" src="/js/forms.js"></script>

<?php

    include_once '../../php/countrycodes.php';

    $id = intval($_GET['id']);
    global $mysqli;
    global $lang;
    global $zone;    

    if($id>0)
    {
        $sql="SELECT username,surnames,email,country_code,tel FROM members WHERE id='$id'";
        $res = $mysqli->query($sql);
        $row = $res->fetch_row();
        $nom = $row[0];
        $cognoms = $row[1];
        $email = $row[2];
        $country_code = $row[3];
        $tel = $row[4];  
    }
    else
    {   
        $nom = "";
        $cognoms = "";
        $email = "";
        $tel = "";
        $country_code = "ES";
    }

    $countrycodes = getCountryInformation();
?>

<script type="text/javascript">
        
    $(document).ready(function()
    {                     
        $('#save').one('click',function(){
            validate_user();
        });
        
        $('#cancel').one('click',function(){
            window.location.href = '/admin/4';
        });
        
        $('#new_password').click(function(){
            checkregisterform_edit_password($(this).parent().parent(),$('#reg_password'),$('#reg_password_r'),$('#pr'));
        });
                
        
        function validate_user()
        {
            $('#edit_name').val()=="" ? $('#edit_name').parent().addClass('has-error') : $('#edit_name').parent().removeClass('has-error');
            $('#edit_email').val()=="" ? $('#edit_email').parent().addClass('has-error') : $('#edit_email').parent().removeClass('has-error');

            if($('#edit_email').val()!="" && $('#edit_name').val())
            {
                $.ajax({  
                    type: "POST",  
                    url: "<?php echo $rootfolder; ?>" +"php/server_actions.php",  
                    data: {
                        op:"edit_user",
                        id:'<?php echo $id; ?>',
                        name:$('#edit_name').val(),
                        surnames:$('#edit_surnames').val(),
                        email:$('#edit_email').val(),
                        countrycode:$('#countryCode').val(),
                        city:"",
                        tel:$('#edit_tel').val(),
                    },
                }).success(function(ret)
                {
                    window.location.href = '/admin/4';
                });
            }
            else
            {
                $('#save').one('click',function(){
                    validate_user();
                });
            }
        }
    });
</script>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Edita l'usuari</h1>
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
                        echo "<h4>" . "Nou usuari" . "</h4>";
                    }
                    else
                    {
                        echo "<h4>" . $nom . " " . $cognoms . "</h4>";
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
                                <label>Nom</label>
                                <input id="edit_name" class="form-control" value="<?php echo $nom; ?>">
                            </div>
                            <div class="form-group">
                                <label>Cognoms</label>
                                <input id="edit_surnames" class="form-control" value="<?php echo $cognoms; ?>">
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input id="edit_email" class="form-control" value="<?php echo $email; ?>">
                            </div>
                            <div class="form-group">
                                <label>Telèfon</label>
                                <input id="edit_tel" class="form-control" value="<?php echo $tel; ?>">
                            </div>
                            <div class="form-group">
                                <label>País</label>
                                <select id="countryCode" class="form-control">                                    
                                <?php
                                foreach ($countrycodes as $code => $country)
                                {?>
                                    <option value="<?php echo $code; ?>" <?php if($code==$country_code) echo 'selected'; ?>><?php echo $country['country_name'] . ' (' . $country['dial_code'] . ')'; ?></option>
                                <?php
                                }
                                ?>                                    
                                </select>
                            </div>
                        </div>
                    </div> 
                    <div class="col-lg-6">
                        <form action="/php/process_edit_password.php" method="post">
                            <div>
                                <input type="hidden" name="user_id" value="<?php echo $id; ?>"/>
                                <input type="hidden" id="pr" name="p"/>
                                <div class="form-group">
                                    <label>Contrasenya</label>
                                    <input name="reg_password" id="reg_password" class="form-control" value="">
                                </div>
                                <div class="form-group">
                                    <label>Repeteix la contrasenya</label>
                                    <input name="reg_password_r" id="reg_password_r" class="form-control" value="">
                                </div>
                                <button id="new_password" class="btn btn-success"><?php echo translate('Canvia la contrasenya', $lang); ?></button>
                            </div>
                        </form>
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
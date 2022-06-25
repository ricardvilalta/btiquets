<?php
    
    if($_SESSION['user_id']==$SUPERUSER)
    {
        if ($accountuid > 0) {
            $compte = GetAccountInfo($mysqli, $accountuid);
            $boxlist = GetBoxListAdmin($mysqli,-1,$compte['id']);
        } else {
            $boxlist = GetBoxListAdmin($mysqli,-1);
        }        
    }
    else
    {
        $compte = GetAccountfromUserInfo($mysqli,$_SESSION['user_id']);
        $boxlist = GetBoxListAdmin($mysqli,-1,$compte['id']);
    }     
?>

<script type="text/javascript">
        
    $(document).ready(function()
    {    
        TableSelectionEvent();
        $("#experiencies").tablesorter(); 
        
        $('#edit_box').click(function(){
            var id = $('#experiencies .success').attr('id');
            if(id!=undefined)
            {
                window.open('/admin/edit-activity/' + id, '_blank');
            }
        });
        
        $('tr').dblclick(function(){
            var id = $(this).attr('id');
            if(id!=undefined)
            {
                window.open('/admin/edit-activity/' + id, '_blank');
            }
        });
        
        $('#delete_box').click(function(){
            var id = $('#experiencies .success').attr('id');
            if(id!=undefined)
            {
                if(confirm('<?php echo translate("N\'estàs segur?", $lang); ?>'))
                {
                    $.ajax({  
                        type: "POST",  
                        url: "<?php echo $rootfolder; ?>" + "php/server_actions.php",  
                        data: {
                            op:"delete_box",
                            id:id
                        },
                        dataType: 'json'
                    }).always(function(ret)
                    {
                        if(ret)
                        {
                            location.reload();
                        }
                        else
                        {
                            alert('<?php echo translate("Aquesta taquilla té reserves actives", $lang); ?>');
                        }
                    });
                }
            }
        });
        
        $('#mini_images').click(function(){

            if(confirm('<?php echo translate("N\'estàs segur?", $lang); ?>'))
            {
                $.ajax({  
                    type: "POST",  
                    url: "<?php echo $rootfolder; ?>" + "php/server_actions.php",  
                    data: {
                        op:"mini_images",
                    },
                    dataType: 'json'
                }).always(function(ret)
                {
                    alert('<?php echo translate("operació finalitzada", $lang); ?>');
                });
            }
        });
        
        $('#copy_box').click(function(){
            
            var id = $('#experiencies .success').attr('id');
            if(id!=undefined)
            {                
                if(confirm('<?php echo translate("N\'estàs segur?", $lang); ?>'))
                {
                    $.ajax({  
                        type: "POST",  
                        url: "<?php echo $rootfolder; ?>" + "php/server_actions.php",  
                        data: {
                            op:"copy_box",
                            id:id
                        },
                        dataType: 'json'
                    }).always(function()
                    {            
                        location.reload();
                    });
                }
            }
        }); 
    });
</script>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Taquilles</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <!-- /.panel -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-tasks fa-fw"></i> Llista de taquilles
                <div class="pull-right">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                            Accions
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu pull-right" role="menu">
                            <li><a href="/admin/edit-activity/-1" target="_blank">Nova taquilla</a>
                            </li>
                            <li><a id="edit_box">Edita taquilla</a>
                            </li>
                            <li><a id="copy_box">Copia taquilla</a>
                            </li>
                            <li><a id="delete_box">Elimina taquilla</a>
                            </li>
                            <?php
                            if($_SESSION['user_id']==$SUPERUSER)
                            {
                            ?>
                            <li><a id="mini_images">Generar miniatures</a>
                            </li>
                            <?php
                            }?>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsive">
                            <table id="experiencies" class="table table-bordered table-hover noselect tablesorter">
                                <thead>
                                    <tr class="head_row header">
                                        <?php if($_SESSION['user_id']==$SUPERUSER){?><th>#</th><?php } ?>
                                        <th>Nom</th>
                                        <th>Url</th>
                                        <th>Tipus</th>
                                        <?php
                                        if($_SESSION['user_id']==$SUPERUSER)
                                        {
                                        ?>
                                        <th>Propietari</th>
                                        <?php
                                        }
                                        ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php                
                                    for($i=0; $i<count($boxlist); $i++)
                                    {
                                        $box = $boxlist[$i];
                                        $compte = GetAccountInfo($mysqli,$box['propietari']);
                                    ?>
                                    <tr id='<?php echo $box["id"]; ?>' tid=';<?php echo $box["type"]; ?>;' oid='<?php echo $box["ocult"]; ?>' did='<?php echo $box["destacat"]; ?>' nid='<?php echo $box["nou"]; ?>'>
                                        <?php if($_SESSION['user_id']==$SUPERUSER){?><td><?php echo $box['id']; ?></td><?php } ?>
                                        <td><?php echo $box['name']; ?></td>
                                        <td><?php echo $server . "event/" . $box['url']; ?></td>
                                        <td><?php if($box['etype']==0) echo "Sessió única"; else if($box['etype']==1) echo "Sessions múltiples"; else if($box['etype']==2) echo "Restaurant"; else if($box['etype']==3) echo "Suite allotjaments"; else if($box['etype']==4) echo "Productes simples"; else if($box['etype']==5) echo "Productes avançats"; ?></td>
                                        <?php
                                        if($_SESSION['user_id']==$SUPERUSER)
                                        {
                                        ?>
                                        <td><?php if($compte!=null) echo $compte['nom']; ?></td>
                                        <?php
                                        }
                                        ?>
                                    </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.table-responsive -->
                    </div>                    
                </div>
                <!-- /.row -->
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
</div>
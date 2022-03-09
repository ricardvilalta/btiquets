<?php
    
    if($_SESSION['user_id']==$SUPERUSER)
    {
        $boxlist = GetProductListAdmin($mysqli,-1);
    }
    else
    {
        $compte = GetAccountfromUserInfo($mysqli,$_SESSION['user_id']);
        $boxlist = GetProductListAdmin($mysqli,-1,$compte['id']);        
    }     
?>

<script type="text/javascript">
        
    $(document).ready(function()
    {    
        TableSelectionEvent();
        
        $('#edit_producte').click(function(){
            var id = $('#experiencies .success').attr('id');
            if(id!=undefined)
            {
                window.location.href = '/admin/edit-producte/' + id;
            }
        });
        
        $('tr').dblclick(function(){
            var id = $(this).attr('id');
            if(id!=undefined)
            {
                window.location.href = '/admin/edit-producte/' + id;
            }
        });
        
        $('#delete_producte').click(function(){
            var id = $('#experiencies .success').attr('id');
            if(id!=undefined)
            {
                if(confirm('<?php echo translate("N\'estàs segur?", $lang); ?>'))
                {
                    $.ajax({  
                        type: "POST",  
                        url: "<?php echo $rootfolder; ?>" + "php/server_actions.php",  
                        data: {
                            op:"delete_producte",
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
                            alert('<?php echo translate("Aquest producte té reserves actives", $lang); ?>'); 
                        }
                    });
                }
            }
        });
        
        $('#copy_producte').click(function(){
            
            var id = $('#experiencies .success').attr('id');
            if(id!=undefined)
            {                
                if(confirm('<?php echo translate("N\'estàs segur?", $lang); ?>'))
                {
                    $.ajax({  
                        type: "POST",  
                        url: "<?php echo $rootfolder; ?>" + "php/server_actions.php",  
                        data: {
                            op:"copy_producte",
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
        <h1 class="page-header">Productes</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <!-- /.panel -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-tasks fa-fw"></i> Llista de productes
                <div class="pull-right">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                            Accions
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu pull-right" role="menu">
                            <li><a href="/admin/edit-producte/-1">Nou producte</a>
                            </li>
                            <li><a id="edit_producte">Edita producte</a>
                            </li>
                            <li><a id="copy_producte">Copia producte</a>
                            </li>
                            <li><a id="delete_producte">Elimina producte</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsive">
                            <table id="experiencies" class="table table-bordered table-hover noselect">
                                <thead>
                                    <tr>
                                        <?php if($_SESSION['user_id']==$SUPERUSER){?><th>#</th><?php } ?>
                                        <th>Nom</th>
<!--
                                        <th>Municipi</th>
                                        <th>Tipus</th>
-->
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
                                    <tr id='<?php echo $box["id"]; ?>' tid=';<?php echo $box["type"]; ?>;' oid='<?php echo $box["ocult"]; ?>'>
                                        <?php if($_SESSION['user_id']==$SUPERUSER){?><td><?php echo $box['id']; ?></td><?php } ?>
                                        <td><?php echo $box['name']; ?></td>
<!--
                                        <td><?php echo $box['poblacio']; ?></td>
                                        <td><?php if($box['type']==0) echo "Allotjament sencer"; else if($box['type']==1) echo "Per habitacions"; else echo "Allotjament sencer" ?></td>
-->
                                        <?php
                                        if($_SESSION['user_id']==$SUPERUSER)
                                        {
                                        ?>
                                        <td><?php echo $compte['nom']; ?></td>
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
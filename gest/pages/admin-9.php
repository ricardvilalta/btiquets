<?php
    
    if($_SESSION['user_id']==$SUPERUSER)
    {
        $boxlist = GetEnviamentListAdmin($mysqli,-1);
    }
    else
    {
        $compte = GetAccountfromUserInfo($mysqli,$_SESSION['user_id']);
        $boxlist = GetEnviamentListAdmin($mysqli,-1,$compte['id']);
    }     
?>

<script type="text/javascript">
        
    $(document).ready(function()
    {    
        TableSelectionEvent();
        
        $('#edit_enviament').click(function(){
            var id = $('#experiencies .success').attr('id');
            if(id!=undefined)
            {
                window.location.href = '/admin/edit-enviament/' + id;
            }
        });
        
        $('tr').dblclick(function(){
            var id = $(this).attr('id');
            if(id!=undefined)
            {
                window.location.href = '/admin/edit-enviament/' + id;
            }
        });
        
        $('#delete_enviament').click(function(){
            var id = $('#experiencies .success').attr('id');
            if(id!=undefined)
            {
                if(confirm('<?php echo translate("N\'estàs segur?", $lang); ?>'))
                {
                    $.ajax({  
                        type: "POST",  
                        url: "<?php echo $rootfolder; ?>" + "php/server_actions.php",  
                        data: {
                            op:"delete_enviament",
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
                            alert('<?php echo translate("Aquest enviament té productes associats", $lang); ?>'); 
                        }
                    });
                }
            }
        });
        
        $('#copy_enviament').click(function(){
            
            var id = $('#experiencies .success').attr('id');
            if(id!=undefined)
            {                
                if(confirm('<?php echo translate("N\'estàs segur?", $lang); ?>'))
                {
                    $.ajax({  
                        type: "POST",  
                        url: "<?php echo $rootfolder; ?>" + "php/server_actions.php",  
                        data: {
                            op:"copy_enviament",
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
        <h1 class="page-header">Enviaments</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <!-- /.panel -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-tasks fa-fw"></i> Modalitats d'enviament
                <div class="pull-right">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                            Accions
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu pull-right" role="menu">
                            <li><a href="/admin/edit-enviament/-1">Nou enviament</a>
                            </li>
                            <li><a id="edit_enviament">Edita enviament</a>
                            </li>
                            <li><a id="copy_enviament">Copia enviament</a>
                            </li>
                            <li><a id="delete_enviament">Elimina enviament</a>
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
                                    <tr id='<?php echo $box["id"]; ?>'>
                                        <?php if($_SESSION['user_id']==$SUPERUSER){?><td><?php echo $box['id']; ?></td><?php } ?>
                                        <td><?php echo $box['name']; ?></td>
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
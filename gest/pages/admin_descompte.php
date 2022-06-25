<?php
    
    if($_SESSION['user_id']==$SUPERUSER)
    {
        if ($accountuid > 0) {
            $compte = GetAccountInfo($mysqli, $accountuid);
            $descomptes = GetDBData("descomptes","propietari=".$compte['id'],"name");
        } else {
            $descomptes = GetDBData("descomptes","","name");
        }        
    }
    else
    {
        $compte = GetAccountfromUserInfo($mysqli,$_SESSION['user_id']);
        $descomptes = GetDBData("descomptes","propietari=".$compte['id'],"name");
    } 
?>

<script type="text/javascript">
        
    $(document).ready(function()
    {    
        TableSelectionEvent();
        
        $('#edit_descompte').click(function(){
            var id = $('#experiencies .success').attr('id');
            if(id!=undefined)
            {
                window.location.href = '/admin/edit-descompte/' + id;
            }
        });
        
        $('tr').dblclick(function(){
            var id = $(this).attr('id');
            if(id!=undefined)
            {
                window.location.href = '/admin/edit-descompte/' + id;
            }
        });
        
        $('#delete_descompte').click(function(){
            var id = $('#experiencies .success').attr('id');
            if(id!=undefined)
            {
                if(confirm('<?php echo translate("N\'estàs segur?", $lang); ?>'))
                {
                    $.ajax({  
                        type: "POST",  
                        url: "<?php echo $rootfolder; ?>" + "php/server_actions.php",  
                        data: {
                            op:"delete_descompte",
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
        <h1 class="page-header">Descomptes</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <!-- /.panel -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-tasks fa-fw"></i> Llista de descomptes
                <div class="pull-right">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                            Accions
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu pull-right" role="menu">
                            <li><a href="/admin/edit-descompte/-1">Nou descompte</a>
                            </li>
                            <li><a id="edit_descompte">Edita descompte</a>
                            </li>
                            <li><a id="delete_descompte">Elimina descompte</a>
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
                                        <th>#</th>
                                        <th>Nom</th>
                                        <th>Tipus</th>
                                        <th>Codi</th>
                                        <th>Valor</th>                                
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php                
                                    foreach($descomptes as $descompte)
                                    {
                                    ?>
                                    <tr id='<?php echo $descompte[0]; ?>'>
                                        <td><?php echo $descompte[0]; ?></td>
                                        <td><?php echo $descompte[1]; ?></td>
                                        <td><?php echo $tipusdescompte[$descompte[3]]; ?></td>
                                        <td><?php echo $descompte[2]; ?></td>
                                        <td><?php echo $descompte[4]; ?></td>
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
<?php
    
    $users = GetUsersInfo($mysqli);
?>

<script type="text/javascript">
        
    $(document).ready(function()
    {    
        TableSelectionEvent();
        
        $('#edit_user').click(function(){
            var id = $('#experiencies .success').attr('id');
            if(id!=undefined)
            {
                window.location.href = '/admin/edit-user/' + id;
            }
        });
        
        $('tr').dblclick(function(){
            var id = $(this).attr('id');
            if(id!=undefined)
            {
                window.location.href = '/admin/edit-user/' + id;
            }
        });
        
        $('#delete_user').click(function(){
            var id = $('#experiencies .success').attr('id');
            if(id!=undefined)
            {
                if(confirm('<?php echo translate("N\'estàs segur?", $lang); ?>'))
                {
                    $.ajax({  
                        type: "POST",  
                        url: "<?php echo $rootfolder; ?>" + "php/server_actions.php",  
                        data: {
                            op:"delete_user",
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
        <h1 class="page-header">Usuaris</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <!-- /.panel -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-tasks fa-fw"></i> Llista d'usuaris
                <div class="pull-right">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                            Accions
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu pull-right" role="menu">
                            <li><a href="/admin/edit-user/-1">Nou usuari</a>
                            </li>
                            <li><a id="edit_user">Edita usuari</a>
                            </li>
                            <li><a id="delete_user">Elimina usuari</a>
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
                                        <th>Usuari</th>
                                        <th>Email</th>
                                        <th>Tel</th>
                                        <th>Creació</th>
                                        <th>Última visita</th>
                                        <th>Confirmat</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php                
                                    for($i=0; $i<count($users); $i++)
                                    {
                                        $user = $users[$i];
                                    ?>
                                    <tr id='<?php echo $user["id"]; ?>'>
                                        <td><?php echo $user['id']; ?></td>
                                        <td><?php echo $user['name'] . " " . $user['surnames']; ?></td>
                                        <td><?php echo $user['email']; ?></td>
                                        <td><?php echo $user['tel']; ?></td>
                                        <td><?php echo $user['creation']; ?></td>
                                        <td><?php echo $user['last_visit']; ?></td>
                                        <td><?php echo $user['confirmed']; ?></td>                                        
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
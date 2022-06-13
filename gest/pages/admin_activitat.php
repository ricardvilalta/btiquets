<?php
    
    if($_SESSION['user_id']==$SUPERUSER && $accountuid<0)
    {
        $activitats = GetDBData("activitats","","nom");
    }
    else
    {        
        $compte = GetAccountfromUserInfo($mysqli,$_SESSION['user_id']);
        $activitats = GetDBData("activitats","propietari=".$compte['id'],"nom");
    }   
?>

<script type="text/javascript">
        
    $(document).ready(function()
    {    
        TableSelectionEvent();
        
        $('#edit_activitat').click(function(){
            var id = $('#experiencies .success').attr('id');
            if(id!=undefined)
            {
                window.location.href = '/admin/edit-activitat/' + id;
            }
        });
        
        $('tr').dblclick(function(){
            var id = $(this).attr('id');
            if(id!=undefined)
            {
                window.location.href = '/admin/edit-activitat/' + id;
            }
        });
        
        $('#delete_activitat').click(function(){
            var id = $('#experiencies .success').attr('id');
            if(id!=undefined)
            {
                if(confirm('<?php echo translate("N\'estàs segur?", $lang); ?>'))
                {
                    $.ajax({  
                        type: "POST",  
                        url: "<?php echo $rootfolder; ?>" + "php/server_actions.php",  
                        data: {
                            op:"delete_activitat",
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
        <h1 class="page-header">Activitats</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <!-- /.panel -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-tasks fa-fw"></i> Llista d'activitats
                <div class="pull-right">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                            Accions
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu pull-right" role="menu">
                            <li><a href="/admin/edit-activitat/-1">Nova activitat</a>
                            </li>
                            <li><a id="edit_activitat">Edita activitat</a>
                            </li>
                            <li><a id="delete_activitat">Elimina activitat</a>
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
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php                
                                    foreach($activitats as $activitat)
                                    {
                                    ?>
                                    <tr id='<?php echo $activitat[0]; ?>'>
                                        <td><?php echo $activitat[0]; ?></td>
                                        <td><?php echo $activitat[1]; ?></td>
                                        <td><?php echo $activitat[2]; ?></td>                                    
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
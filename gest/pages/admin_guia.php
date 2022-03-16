<?php
    
    if($_SESSION['user_id']==$SUPERUSER && $accountuid<0)
    {
        $guies = GetDBData("guies","","name");
    }
    else
    {        
        $compte = GetAccountfromUserInfo($mysqli,$_SESSION['user_id']);
        $guies = GetDBData("guies","propietari=".$compte['id'],"name");
    }   
?>

<script type="text/javascript">
        
    $(document).ready(function()
    {    
        TableSelectionEvent();
        
        $('#edit_guia').click(function(){
            var id = $('#experiencies .success').attr('id');
            if(id!=undefined)
            {
                window.location.href = '/admin/edit-guia/' + id;
            }
        });
        
        $('tr').dblclick(function(){
            var id = $(this).attr('id');
            if(id!=undefined)
            {
                window.location.href = '/admin/edit-guia/' + id;
            }
        });
        
        $('#delete_guia').click(function(){
            var id = $('#experiencies .success').attr('id');
            if(id!=undefined)
            {
                if(confirm('<?php echo translate("N\'estàs segur?", $lang); ?>'))
                {
                    $.ajax({  
                        type: "POST",  
                        url: "<?php echo $rootfolder; ?>" + "php/server_actions.php",  
                        data: {
                            op:"delete_guia",
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
        <h1 class="page-header">Guies</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <!-- /.panel -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-tasks fa-fw"></i> Llista de guies
                <div class="pull-right">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                            Accions
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu pull-right" role="menu">
                            <li><a href="/admin/edit-guia/-1">Nou guia</a>
                            </li>
                            <li><a id="edit_guia">Edita guia</a>
                            </li>
                            <li><a id="delete_guia">Elimina guia</a>
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
                                        <th>Cognoms</th>                                     
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php                
                                    foreach($guies as $guia)
                                    {
                                    ?>
                                    <tr id='<?php echo $guia[0]; ?>'>
                                        <td><?php echo $guia[0]; ?></td>
                                        <td><?php echo $guia[1]; ?></td>
                                        <td><?php echo $guia[2]; ?></td>                                    
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
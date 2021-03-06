<?php
    
    if($_SESSION['user_id']==$SUPERUSER && $accountuid<0)
    {
        $serveis = GetDBData("serveis","","data_inicial DESC");
    }
    else
    {        
        $compte = GetAccountfromUserInfo($mysqli,$_SESSION['user_id']);
        $serveis = GetDBData("serveis","propietari=".$compte['id'],"data_inicial DESC");
    }   
?>

<script type="text/javascript">
        
    $(document).ready(function()
    {    
        TableSelectionEvent();
        
        $('#edit_servei').click(function(){
            var id = $('#experiencies .success').attr('id');
            if(id!=undefined)
            {
                window.location.href = '/admin/edit-servei/' + id;
            }
        });
        
        $('tr').dblclick(function(){
            var id = $(this).attr('id');
            if(id!=undefined)
            {
                window.location.href = '/admin/edit-servei/' + id;
            }
        });
        
        $('#delete_servei').click(function(){
            var id = $('#experiencies .success').attr('id');
            if(id!=undefined)
            {
                if(confirm('<?php echo translate("N\'estàs segur?", $lang); ?>'))
                {
                    $.ajax({  
                        type: "POST",  
                        url: "<?php echo $rootfolder; ?>" + "php/server_actions.php",  
                        data: {
                            op:"delete_servei",
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
        <h1 class="page-header">Serveis</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <!-- /.panel -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-tasks fa-fw"></i> Llista de serveis
                <div class="pull-right">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                            Accions
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu pull-right" role="menu">
                            <li><a href="/admin/edit-servei/-1">Nou servei</a>
                            </li>
                            <li><a id="edit_servei">Edita servei</a>
                            </li>
                            <li><a id="delete_servei">Elimina servei</a>
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
                                        <th>Data</th>
                                        <th>Data servei</th>
                                        <th>Client</th>
                                        <th>Activitat</th>                              
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php                
                                    foreach($serveis as $servei)
                                    {
                                        $client = GetDBItem('clients',$servei[1]);
                                        $activitat = GetDBItem('espais',$servei[21]);
                                    ?>
                                    <tr id='<?php echo $servei[0]; ?>'>
                                        <td><?php echo $servei[0]; ?></td>
                                        <td><?php echo $servei[9]; ?></td>
                                        <td><?php echo $servei[10]; ?></td>
                                        <td><?php echo $client[1]; ?></td>  
                                        <td><?php echo $activitat[1]; ?></td>
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
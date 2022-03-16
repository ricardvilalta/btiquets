<?php
    
    if($_SESSION['user_id']==$SUPERUSER && $accountuid<0)
    {
        $preus = GetDBData("preus");
    }
    else
    {        
        $compte = GetAccountfromUserInfo($mysqli,$_SESSION['user_id']);
        $preus = GetDBData("preus","propietari=".$compte['id']);
    }   
?>

<script type="text/javascript">
        
    $(document).ready(function()
    {    
        TableSelectionEvent();
        
        $('#edit_preu').click(function(){
            var id = $('#experiencies .success').attr('id');
            if(id!=undefined)
            {
                window.location.href = '/admin/edit-preu/' + id;
            }
        });
        
        $('tr').dblclick(function(){
            var id = $(this).attr('id');
            if(id!=undefined)
            {
                window.location.href = '/admin/edit-preu/' + id;
            }
        });
        
        $('#delete_preu').click(function(){
            var id = $('#experiencies .success').attr('id');
            if(id!=undefined)
            {
                if(confirm('<?php echo translate("N\'estàs segur?", $lang); ?>'))
                {
                    $.ajax({  
                        type: "POST",  
                        url: "<?php echo $rootfolder; ?>" + "php/server_actions.php",  
                        data: {
                            op:"delete_preu",
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
        <h1 class="page-header">Preus</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <!-- /.panel -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-tasks fa-fw"></i> Llista de preus
                <div class="pull-right">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                            Accions
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu pull-right" role="menu">
                            <li><a href="/admin/edit-preu/-1">Nou preu</a>
                            </li>
                            <li><a id="edit_preu">Edita preu</a>
                            </li>
                            <li><a id="delete_preu">Elimina preu</a>
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
                                        <th>Descripció</th>
                                        <th>Base</th>
                                        <th>IVA</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php                
                                    foreach($preus as $preu)
                                    {
                                    ?>
                                    <tr id='<?php echo $preu[0]; ?>'>
                                        <td><?php echo $preu[0]; ?></td>
                                        <td><?php echo $preu[1]; ?></td>
                                        <td><?php echo $preu[2]; ?></td>
                                        <td><?php echo $preu[3]; ?></td>
                                        <td><?php echo _TIPUSIVA[$preu[4]]; ?></td>
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
<?php
    $backuplist = GetBackupList("../../CS");
?>

<script type="text/javascript">
        
    $(document).ready(function()
    {    
        TableSelectionEvent();
        
        $('#new_cs').click(function()
        {
            $(".loading").show();
            $.ajax({                                      
                url: "/php/backup.php",
                type: "POST"
            })
            .always(function()
            {                
                location.reload();
            });
        });
        
        $('#load_cs').click(function()
        {            
            var backup_id = $('#copies .success').attr('id');
            $(".loading").show();
            $.ajax({                   
                url: "/php/restore.php",
                type: "POST",
                data: {
                    backup_folder:backup_id                
                },
                dataType: 'json'
            })
            .always(function()
            {
                location.reload(); 
            });
        });
        
        $('#daily_op').click(function()
        {            
            $(".loading").show();
            $.ajax({                   
                url: "/php/cronjob_24.php"
            })
            .always(function()
            {
                location.reload();
            });
        });
    });
</script>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Còpies de seguretat</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <!-- /.panel -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-tasks fa-fw"></i> Llista de còpies
                <div class="pull-right">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                            Accions
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu pull-right" role="menu">
                            <li><a id="new_cs">Nova còpia</a>
                            </li>
                            <li><a id="load_cs">Carrega la còpia</a>
                            </li>
                            <li><a id="delete_user">Elimina la còpia</a>
                            </li>
                            <li><a id="daily_op">Operacions diàries</a>
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
                            <table id="copies" class="table table-bordered table-hover noselect">
                                <thead>
                                    <tr>
                                        <th>Còpia</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php                                    
                                    for($i=0; $i<count($backuplist); $i++)
                                    {
                                    ?>
                                    <tr id='<?php echo $backuplist[$i]; ?>'>
                                        <td><?php echo $backuplist[$i]; ?></td>                                      
                                    </tr>
                                    <?php
                                    }?>
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
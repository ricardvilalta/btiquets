
<?php global $accountuid;?>
<script type="text/javascript">

    $(document).ready(function()
    {
        $('#compte_selector').change(function(){
            $.ajax({  
                type: "POST",  
                url: "/php/server_actions.php",
                data: {
                    op:"account_session",
                    value:$(this).find(":selected").val()
                },
                dataType: 'json'
            }).always(function(ret)
            {
            }); 
        });
    });
</script>

<!-- Navigation -->
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.html">BTiquets Admin</a>
    </div>
    <!-- /.navbar-header -->

    <ul class="nav navbar-top-links navbar-right">

        <!-- /.dropdown -->
<!--
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-bell fa-fw"></i>  <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-alerts">
                <li>
                    <a href="#">
                        <div>
                            <i class="fa fa-comment fa-fw"></i> New Comment
                            <span class="pull-right text-muted small">4 minutes ago</span>
                        </div>
                    </a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="#">
                        <div>
                            <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                            <span class="pull-right text-muted small">12 minutes ago</span>
                        </div>
                    </a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="#">
                        <div>
                            <i class="fa fa-envelope fa-fw"></i> Message Sent
                            <span class="pull-right text-muted small">4 minutes ago</span>
                        </div>
                    </a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="#">
                        <div>
                            <i class="fa fa-tasks fa-fw"></i> New Task
                            <span class="pull-right text-muted small">4 minutes ago</span>
                        </div>
                    </a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="#">
                        <div>
                            <i class="fa fa-upload fa-fw"></i> Server Rebooted
                            <span class="pull-right text-muted small">4 minutes ago</span>
                        </div>
                    </a>
                </li>
                <li class="divider"></li>
                <li>
                    <a class="text-center" href="#">
                        <strong>See All Alerts</strong>
                        <i class="fa fa-angle-right"></i>
                    </a>
                </li>
            </ul>
             /.dropdown-alerts 
        </li>
-->
        <!-- /.dropdown -->
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <li><a href=""><i class="fa fa-user fa-fw"></i> <?php echo $_SESSION['username']; ?></php></a>
                </li>
                <li><a href="/admin/configuracio"><i class="fa fa-gear fa-fw"></i> Configuració</a>
                </li>
                <li class="divider"></li>
                <li><a href="/php/logout.php"><i class="fa fa-sign-out fa-fw"></i> Desconnecta't</a>
                </li>
            </ul>
            <!-- /.dropdown-user -->
        </li>
        <!-- /.dropdown -->
    </ul>
    <!-- /.navbar-top-links -->

    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">
<!--
                <li class="sidebar-search">
                    <div class="input-group custom-search-form">
                        <input type="text" class="form-control" placeholder="Search...">
                        <span class="input-group-btn">
                        <button class="btn btn-default" type="button">
                            <i class="fa fa-search"></i>
                        </button>
                    </span>
                    </div>
                </li>
-->
<!--
                <li>
                    <a href="/admin/1"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                </li>
-->
                <li>
                    <a href="/admin/2"><i class="fa fa-table fa-fw"></i> Reserves</a>
                </li>
                <?php
                if(!$compte['extern'])
                {?>
                <li>
                    <a href="/admin/3"><i class="fa fa-ticket fa-fw"></i> Taquilles</a>
                </li>
                <?php
                }
                if($_SESSION['user_id']==$SUPERUSER || $uactivities['btype_3']>0)
                {?>
                <li>
                    <a href="/admin/7"><i class="fa fa-home fa-fw"></i> Allotjaments</a>
                </li>
                <?php
                }
                if($_SESSION['user_id']==$SUPERUSER || $uactivities['btype_5']>0)
                {?>
                <li>
                    <a href="/admin/8"><i class="fa fa-lemon-o fa-fw"></i> Productes</a>
                </li>
                <li>
                    <a href="/admin/9"><i class="fa fa-truck fa-fw"></i> Enviaments</a>
                </li>
                <?php
                }
                if($_SESSION['user_id']==$SUPERUSER || $compte['versio']==2)
                {?>
                <li>
                    <a href="/admin/18"><i class="fa fa-camera fa-fw"></i> Serveis</a>
                </li>
                <li>
                    <a href="/admin/20"><i class="fa fa-money fa-fw"></i> Preus</a>
                </li>
                <li>
                    <a href="/admin/22"><i class="fa fa-male fa-fw"></i> Guies</a>
                </li>
                <li>
                    <a href="/admin/24"><i class="fa fa-university fa-fw"></i> Espais</a>
                </li>                
                <li>
                    <a href="/admin/28"><i class="fa fa-users fa-fw"></i> Clients</a>
                </li>
                <li>
                    <a href="/admin/26"><i class="fa fa-user fa-fw"></i> Administrador</a>
                </li>
                <?php
                }
                if($_SESSION['user_id']==$SUPERUSER)
                {?>
                <li>
                    <a href="/admin/5"><i class="fa fa-folder-open-o fa-fw"></i> Comptes</a>
                </li>
                <li>
                    <a href="/admin/4"><i class="fa fa-users fa-fw"></i> Usuaris</a>
                </li>
                <li>
                    <a href="/admin/6"><i class="fa fa-copy fa-fw"></i> Còpies de seguretat</a>
                </li>
                <li>
                    <select id="compte_selector" style="margin: 15px;" vid='<?php echo $accountuid;?>'>
                        <option value='-1' <?php if($accountuid==-1) echo "selected";?>>Tots</option>
                        <?php
                        $comptes = GetAccountsInfo($mysqli);
                        foreach($comptes as $thiscompte)
                        {
                        ?>
                        <option value='<?php echo $thiscompte["id"];?>' <?php if($accountuid==$thiscompte["id"]) echo "selected";?>><?php echo $thiscompte['nom'];?></option>
                        <?php
                        }?>
                    </select>
                </li>
                <?php
                }?>
            </ul>
        </div>
        <!-- /.sidebar-collapse -->
    </div>
    <!-- /.navbar-static-side -->
</nav>
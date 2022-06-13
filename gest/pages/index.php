<?php
    include_once '../../php/common.php';
    include_once '../../php/funcions.php';
    include_once '../../php/btdv_funcions.php';

    sec_session_start('btiquets_session_id');

    if(isSet($_COOKIE['btiquets-cookie-compliance']))
	{
		$cookies_session_started = true;        
	}
    else
    {
        $cookies_session_started = false;
        setcookie("btiquets-cookie-compliance","approved",time() + (3600 * 24 * 30));
    }

    global $mysqli;
?>


<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>BTiquets Admin</title>

    <!-- Bootstrap Core CSS -->
    <link href="/gest/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/front/assets/css/default.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="/gest/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="/gest/dist/css/timeline.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="/gest/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="/gest/bower_components/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="/gest/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    
    <link href="/css/style.css" rel="stylesheet">

    <!-- jQuery -->
    <script type="text/javascript" src="/js/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="/js/ui/jquery-ui.js"></script>
    <link rel="stylesheet" type="text/css" href="/js/themes/base/jquery-ui.css" />
<!--    <script src="/gest/bower_components/jquery/dist/jquery.min.js"></script>-->
    <script type="text/javascript" src="/js/appearance.js"></script>    
    
    <script type="text/javascript" src="/js/jquery.datetimepicker.full.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/css/jquery.datetimepicker.css" />
    
    <script type="text/javascript" src="/js/jquery-ui.multidatespicker.js"></script>    
    <link rel="stylesheet" type="text/css" href="/css/jquery-ui.multidatespicker.css" />
    
    <link rel="stylesheet" type="text/css" href="<?php echo $rootfolder; ?>css/style.css" />
    
    <script type="text/javascript" src="/js/load-image.min.js"></script>
    <script type="text/javascript" src="/js/canvas-to-blob.min.js"></script>
    <script type="text/javascript" src="/plugins/fileuploadmaster/js/jquery.iframe-transport.js"></script>
    <script type="text/javascript" src="/plugins/fileuploadmaster/js/jquery.fileupload.js"></script>
    <script type="text/javascript" src="/plugins/fileuploadmaster/js/jquery.fileupload-process.js"></script>
    <script type="text/javascript" src="/plugins/fileuploadmaster/js/jquery.fileupload-image.js"></script>
    <script type="text/javascript" src="/js/jquery.tablesorter.min.js"></script>
    
    <link rel="stylesheet" type="text/css" href="/plugins/fileuploadmaster/css/jquery.fileupload.css" />
    
    <script type="text/javascript" src="/js/funcions.js"></script>
    <script type="text/javascript" src="/gest/js/funcions.js"></script>
    
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<?php
$submenu=-1;
$page=1;
$pagination=1;
$xid=-1;$sid=-10;$tid=-10;$did1="";$did2="";
if(isset($_GET['submenu']))
{
    $submenu = $_GET['submenu'];
}
if(isset($_GET['id']))
{
    $id = $_GET['id'];
}
if(isset($_GET['page']))
{
    $page = $_GET['page'];
}
if(isset($_GET['pagination']))
{
    $pagination = $_GET['pagination'];
}
if(isset($_GET['xid']))
{
    $xid = $_GET['xid'];
}
if(isset($_GET['tid']))
{
    $tid = $_GET['tid'];
}
if(isset($_GET['sid']))
{
    $sid = $_GET['sid'];
}
if(isset($_GET['did1']))
{
    $did1 = $_GET['did1'];
}
if(isset($_GET['did2']))
{
    $did2 = $_GET['did2'];
}

?>  
    
<body>
    
    <?php
    if(login_check($mysqli,"btiquets_login_string") != true)
    {
        include('login.php'); 
    }
    else
    {
        if(isset($_SESSION['account_id'])) $accountuid = $_SESSION['account_id'];
        else $accountuid = -1;

        if($_SESSION['user_id']==$SUPERUSER)
        {
            if($accountuid>0)
            {
                $compte = GetAccountInfo($mysqli,$accountuid);
            }
            else
            {
                $compte = GetAccountfromUserInfo($mysqli,$_SESSION['user_id']);                
            }
        }
        else
        {
            $compte = GetAccountfromUserInfo($mysqli,$_SESSION['user_id']);
        }
        $uactivities = GetActivitiesfromUser($mysqli,$compte['id']);
    ?>

    <div id="wrapper">

        <?php include('navigation.php'); ?>        

        <div id="page-wrapper">
            
            <div class="loading"></div>
            <div id="pop_up"></div>
            
            <?php

            switch($submenu)
            {
                case 1:                
                    include('admin-1.php');
                    include('flot.html');
                    include('grid.html');
                    include('forms.html');
                    include('icons.html');
                    include('morris.html');
                    include('notifications.html');
                    include('panel-wells.html');
                    include('tables.html');
                    include('typography.html');
                    break;
                case 2:
                    include('admin-2.php');
                    break;
                case 3:
                    include('admin-3.php');
                    break;
                case 4:
                    include('admin-4.php');
                    break;
                case 5:
                    include('admin-5.php');
                    break;
                case 6:
                    include('admin-6.php');
                    break;
                case 7:
                    include('admin-7.php');
                    break;
                case 8:
                    include('admin-8.php');
                    break;
                case 9:
                    include('admin-9.php');
                    break;
                case 10:
                    include('edit_activity.php');
                    break;
                case 11:
                    include('edit_user.php');
                    break;
                case 12:
                    include('edit_reservation.php');
                    break;
                case 13:
                    include('edit_compte.php');
                    break;
                case 14:
                    include('configuracio.php');
                    break;
                case 15:
                    include('edit_hotel.php');
                    break;
                case 16:
                    include('edit_producte.php');
                    break;
                case 17:
                    include('edit_enviament.php');
                    break;
                case 18:
                    include('admin_servei.php');
                    break;
                case 19:
                    include('edit_servei.php');
                    break;
                case 20:
                    include('admin_preu.php');
                    break;
                case 21:
                    include('edit_preu.php');
                    break;
                case 22:
                    include('admin_guia.php');
                    break;
                case 23:
                    include('edit_guia.php');
                    break;
                case 24:
                    include('admin_espai.php');
                    break;
                case 25:
                    include('edit_espai.php');
                    break;
                case 26:
                    include('admin_admin.php');
                    break;
                case 27:
                    include('edit_admin.php');
                    break;
                case 28:
                    include('admin_client.php');
                    break;
                case 29:
                    include('edit_client.php');
                    break;
                case 30:
                    include('admin_activitat.php');
                    break;
                case 31:
                    include('edit_activitat.php');
                    break;
                default:                
                    include('admin-2.php');
                    break;            
            }?>
                                    
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
    
    <?php
    }?>

    <!-- Bootstrap Core JavaScript -->
    <script src="/gest/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="/gest/bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <?php
    if($submenu==1)
    {?>
    <!-- Morris Charts JavaScript -->
    <script src="/gest/bower_components/raphael/raphael-min.js"></script>
    <script src="/gest/bower_components/morrisjs/morris.min.js"></script>
    <script src="/gest/js/morris-data.js"></script>
    <?php
    }?>

    <!-- Custom Theme JavaScript -->
    <script src="/gest/dist/js/sb-admin-2.js"></script>

</body>

</html>

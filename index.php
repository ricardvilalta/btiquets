<!DOCTYPE HTML>
<?php
    
    include_once './php/common.php';
    include_once './php/funcions.php';
    include_once './php/btdv_funcions.php';

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

    $event=-1;
    global $mysqli;
    global $lang;
    global $zone;
    $sessions = "";
    $event_not_found = false;
    $page = -1;
    $home = false;
    $compte = -1;
    $lang = "ca";
    date_default_timezone_set($zone);
    

    if(isset($_GET['lang']))
    {
        $lang = $_GET['lang'];
    }

    if(isset($_GET['home']))
    {
        $home = $_GET['home'];
        $box_list = GetBoxListAdmin($mysqli,-1,-1);
    }

    if(isset($_GET['reserva']))
    {
        $reserva = $_GET['reserva'];
    }

    if(isset($_GET['event']))
    {
        $event_url = $_GET['event'];
        $event = decode_url($mysqli,$event_url,"box_data");
        $valid = 1;      
        if($event>0)
        {
            $box = GetBox($mysqli,$event);
            $compte = GetAccountInfo($mysqli,$box['propietari']);
            if($box['ocult']==0 && $box['arxivada']==0)
            {
                $sessions = GetSessions($mysqli,$event);
                $reslist = GetActivityReservations($mysqli,$event);                                

                $price_modalities = decode_price($box['price'],false);
                $price_type = 0;
                if(sizeof($price_modalities)>0) $price_type = $price_modalities[0]['type'];
                $res_days = decode_res_days($box['res_days']);

                $data_o = "";
                $subtitle = "";
                switch($box['etype'])
                {
                    case 0:

                        if($box["sessio_unica"]>0)
                        {
                            $session = GetSession($mysqli,$box["sessio_unica"]);
                            $data_o = str_replace('-','/',$session['data']);
                            $hora_o = $session['hora'];
                            if($session['session_name']!="")
                            {
                                $subtitle = $session['session_name'];
                            }
                            else
                            {
                                $subtitle = $data_o . ' ' . $session['hora'];
                            }

                            // Comprovar si queden places > SENSE PLACES
                            $ocupacio = GetReservationFromBox($mysqli,$box['id']);                            
                            if($ocupacio>$session['places'])
                            {
                                $valid = -2;
                            }
                            // També agafo la ocupació per cada modalitat
                            $ocupacio_modality = GetReservationFromBox_modalities($mysqli,$box['id'],count($price_modalities));
                            
                            // Comprovar si estem en vigència de reserva > TAQUILLA TANCADA
                            $now = strtotime('now');
                            $ses = strtotime($session['data'].' '.$session['hora']);
                            $ant = strtotime(' - ' . $session['antelacio'] . ' hour',$ses);                            
                            if($now>$ant)
                            {
                                $valid = -1;
                            }
                        }
                        break;

                    case 1:
                    
                        // Comprovar si hi ha sessions futures obertes > TAQUILLA TANCADA
                        $valid = -1;
                        foreach($sessions as $session)
                        {                
                            $now = strtotime('now');
                            $ses = strtotime($session['data'].' '.$session['hora']);
                            $ant = strtotime(' - ' . $session['antelacio'] . ' hour',$ses);                            
                            if($now<$ant)
                            {
                                $valid = 1;
                                break;
                            }
                        }

                        break;

                    case 2:
                        break;
                    
                    case 3:
                                            
                        $hotel_list = GetHotelfromList($mysqli,$box["collaboradors"]);

                        break;
                    
                    case 4:
                        
                        $subtitle = "";
                        $ocupacio_modality = GetReservationFromBox_modalities($mysqli,$box['id'],count($price_modalities));
                        break;
                    
                    case 5:
                        
                        $producte_list = GetProductefromList($mysqli,$box["productes"]);
                        $enviament = GetEnviamentsfromBox($mysqli,$box["enviament_id"],$box["enviament_str"]);

                        break;
                    
                    case 6:
                        break;

                    default:

                        break;  
                }
                
                if($box['taquilla_tancada']) $valid = -1;
            }
            else
            {
                $event_not_found = true;
            }
        }
        else
        {
            $event_not_found = true;
        }
    }    
    else
    {
        $event_not_found = true;
    }

    if(isset($_GET['page']))
    {
        $page = $_GET['page'];
        $command = "";
        $ref = "";
        if(isset($_GET['compte']))
        {
            $compte = intval($_GET['compte']);
        }
        if(isset($_GET['command']))
        {
            $command = $_GET['command'];
        }
        if(isset($_GET['code']))
        {
            $ref = $_GET['code'];
        }
        $event_not_found = false;
    }

    switch($lang)
    {           
        case 'es':
            $firstday = 1;
            $dayNamesMin = '"Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"';
            $monthNamesShort = '"Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"';
            $monthNames = '"Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"';
            break;
        
        case 'en':
            $firstday = 0;
            $dayNamesMin = '"Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"';
            $monthNamesShort = '"Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"';
            $monthNames = '"January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"';
            break;
        
        default:
            $firstday = 1;
            $dayNamesMin = '"Dg", "Dl", "Dm", "Dx", "Dj", "Dv", "Ds" ';
            $monthNamesShort = '"Gen", "Feb", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Des"';
            $monthNames = '"Gener", "Febrer", "Març", "Abril", "Maig", "Juny", "Juliol", "Agost", "Setembre", "Octubre", "Novembre", "Desembre"';
            break;
    }

?>

<?php
if($event_not_found || $page>0)
{?>
<html style="background-image:url('/images/overlay.png')">
<?php
}
else
{?>
<html style="background-image:url('images/overlay.png'),url('<?php echo $rootfolder . "boxes/box_" . $event . "/box_image_0.jpg"; ?>')">
<?php
}?>
	<head>
		<title>BTiquets</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
        <!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
		<link rel="stylesheet" href="/assets/css/main.css" />
        <link rel="stylesheet" href="/css/style.css" />
		<!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
		<!--[if lte IE 9]><link rel="stylesheet" href="assets/css/ie9.css" /><![endif]-->   
        
        <script type="text/javascript" src="/js/jquery-1.11.0.min.js"></script>        
        <script type="text/javascript" src="/js/ui/jquery-ui.js"></script>                        
        <script type="text/javascript" src="/js/funcions.js"></script>        
        
        <link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Amatic+SC' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Lora:400,700' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" type="text/css" href="/js/themes/base/jquery-ui.css" />
        <link rel="shortcut icon" href="/favicon.png" type="image/png">
        
	</head>
    
	<body>                

        <!-- Header -->			
        
        <?php
        if($home)
        {?>
            <section id="header">
				<?php include('assets/step-0-home.php'); ?>
			</section>
            <section id="one" class="main special">
                <?php include('assets/home.php'); ?>
            </section>
        <?php
        }
        else if($event_not_found)
        {
        }
        else if($page>0)
        {
        }
        else
        {?>
            <section id="header">
				<?php include('assets/step-0.php'); ?>
			</section>
        <?php 
            
            $urlOK 	= $server.'process-ok/'.$box['url'];
            $urlKO 	= $server.'process-fail/'.$box['url'];
            switch($box['etype'])
            {                
                case 0: //sessió única

                    if($valid==1)
                    {
                    ?>		

                <!-- One -->
                    <section id="one" class="main special">
                        <?php include('assets/step-1-0.php'); ?>
                    </section>

                <!-- Two -->
                    <section id="two" class="main special">
                        <?php include('assets/step-2-0.php'); ?>
                    </section>

                <!-- Final -->
                    <section id="final" class="main special">                
                    </section>

                    <?php
                    }
                    break;

                    case 1: //sessions calendari
                    if($valid==1)
                    {
                    ?>	
                <!-- One -->
                    <section id="one" class="main special">
                        <?php include('assets/step-1-1.php'); ?>
                    </section>

                <!-- Two -->
                    <section id="two" class="main special">
                        <?php include('assets/step-2-1.php'); ?>
                    </section>

                <!-- Three -->
                    <section id="three" class="main special">
                        <?php include('assets/step-3-1.php'); ?>
                    </section>

                <!-- Final -->
                    <section id="final" class="main special">                
                    </section>

                    <?php
                    }
                    break;

                case 2: //restaurant
                    ?>		

                <!-- One -->
                    <section id="one" class="main special">
                        <?php include('assets/step-1-2.php'); ?>
                    </section>

                <!-- Two -->
                    <section id="two" class="main special">
                        <?php include('assets/step-2-2.php'); ?>
                    </section>


                    <?php
                    break;

                case 3: //suite allotjaments
                    ?>		

                <!-- One -->
                    <section id="one" class="main special">
                        <?php include('assets/step-1-3.php'); ?>
                    </section>

                <!-- Two -->
                    <section id="two" class="main special">
                        <?php include('assets/step-2-3.php'); ?>
                    </section>

                <!-- Three -->
                    <section id="three" class="main special">
                        <?php include('assets/step-3-3.php'); ?>
                    </section>

                <!-- Four -->
                    <section id="four" class="main special">
                        <?php include('assets/step-4-3.php'); ?>
                    </section>

                <!-- Final -->
                    <section id="final" class="main special">                
                    </section>

                    <?php
                    break;

                case 4: //productes simples
                    if($valid==1)
                    {
                    ?>

                <!-- One -->
                    <section id="one" class="main special">
                        <?php include('assets/step-1-0.php'); ?>
                    </section>

                <!-- Two -->
                    <section id="two" class="main special">
                        <?php include('assets/step-2-0.php'); ?>
                    </section>

                <!-- Final -->
                    <section id="final" class="main special">                
                    </section>

                    <?php
                    }
                    break;

                case 5: //productes avançats
                    if($valid==1)
                    {
                    ?>	

                <!-- One -->
                    <section id="one" class="main special">
                        <?php include('assets/step-1-5.php'); ?>
                    </section>

                <!-- Two -->
                    <section id="two" class="main special">
                        <?php include('assets/step-2-5.php'); ?>
                    </section>

                <!-- Three -->
                    <section id="three" class="main special">
                        <?php include('assets/step-3-5.php'); ?>
                    </section>

                <!-- Final -->
                    <section id="final" class="main special">                
                    </section>

                    <?php
                    }
                    break;

                case 6: //data oberta

                    ?>		

                <!-- One -->
                    <section id="one" class="main special">
                        <?php include('assets/step-1-0.php'); ?>
                    </section>

                <!-- Two -->
                    <section id="two" class="main special">
                        <?php include('assets/step-2-6.php'); ?>
                    </section>

                <!-- Three -->
                    <section id="three" class="main special">
                        <?php include('assets/step-3-6.php'); ?>
                    </section>

                <!-- Final -->
                    <section id="final" class="main special">                
                    </section>

                    <?php
                    break;

                case 7: //Aportació voluntària

                    ?>		

                <!-- One -->
                    <section id="one" class="main special">
                        <?php include('assets/step-1-7.php'); ?>
                    </section>

                <!-- Two -->
                    <section id="two" class="main special">
                        <?php include('assets/step-2-7.php'); ?>
                    </section>

                <!-- Final -->
                    <section id="final" class="main special">                
                    </section>

                    <?php
                    break;
            }
        }?>

		<!-- Footer -->
			<section id="footer">	
                <?php
                if($event_not_found)
                {?>
                    <section id="header-no-event">
                        <?php include('assets/no-event.php'); ?>
                    </section>
                <?php
                }
                else if($page>0)
                {?>
                    <section id="header-no-event">
                    <?php
                    switch($page)
                    {
                        case 1:
                            include('assets/cond.php');
                            break;

                        case 2:
                            include('assets/lopd.php');
                            break;
                        
                        case 3:
                            include('assets/process-ok.php');
                            break;
                        
                        case 4:
                            include('assets/process-ko.php');
                            break;
                        
                        case 5:
                            include('php/admin_reservation.php');
                            break;

                        case 6:
                                include('assets/qrvalidation.php');
                                break;

                        default:
                            include('assets/cond.php');
                            break;
                    }
                    ?>
                    </section>
                <?php
                }?>
				<footer>                
<!--
					<ul class="icons">
						<li><a href="#" class="icon alt fa-twitter"><span class="label">Twitter</span></a></li>
						<li><a href="#" class="icon alt fa-facebook"><span class="label">Facebook</span></a></li>
						<li><a href="#" class="icon alt fa-instagram"><span class="label">Instagram</span></a></li>
						<li><a href="#" class="icon alt fa-dribbble"><span class="label">Dribbble</span></a></li>
						<li><a href="#" class="icon alt fa-envelope"><span class="label">Email</span></a></li>
					</ul>
-->
					<ul class="copyright">
						<li><a href="http://btiquets.com" target="_blank"> &copy; BTiquets.com</li>
<!--                        <li>Design: <a href="http://html5up.net">HTML5 UP</a></li>-->
<!--                        <li>Demo Images: <a href="http://unsplash.com">Unsplash</a></li>-->
					</ul>
				</footer>
			</section>

		<!-- Scripts -->	
<!--            <script src="assets/js/jquery.min.js"></script>-->
			<script src="/assets/js/jquery.scrollex.min.js"></script>
			<script src="/assets/js/jquery.scrolly.min.js"></script>
			<script src="/assets/js/skel.min.js"></script>
			<script src="/assets/js/util.js"></script>
			<!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
			<script src="/assets/js/main.js"></script>

	</body>
</html>
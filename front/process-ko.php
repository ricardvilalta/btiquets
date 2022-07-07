<!doctype html>
<html lang="ca">
    
<?php
    
    include_once './../php/common.php';
    include_once './../php/funcions.php';
    include_once './../php/btdv_funcions.php';

    global $mysqli;
    global $lang;
    global $zone;


    if(isset($_GET['reserva']))
    {
        $reserva = $_GET['reserva'];
    }

    if(isset($_GET['event']))
    {
        $event_url = $_GET['event'];
    }


    $tipus = array(0=>'Esdeveniment amb data única',1=>'Esdeveniment amb múltiples sessions',2=>'Reserva de restaurant',3=>'Allotjaments',4=>'Venda de productes simple',5=>'Venda de productes avançada');
    $tipus_icons = array(0=>'lni-ticket',1=>'lni-calendar',2=>'lni-restaurant',3=>'lni-home',4=>'lni-tshirt',5=>'lni-cart'); 

    include 'header.php';
?>

<body>
   
    <!--====== PRELOADER PART START ======-->
    
    <div class="preloader">
        <div class="spin">
            <div class="cube1"></div>
            <div class="cube2"></div>
        </div>
    </div>
    
    <!--====== PRELOADER PART START ======-->
    
    <!--====== HEADER PART START ======-->
    
    <header class="header-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <nav class="navbar navbar-expand-lg">
                        <a class="navbar-brand portada" href="/">
                            <img src="/front/assets/images/logo.png" alt="Logo">
                        </a> <!-- Logo -->                        
                    </nav> <!-- navbar -->
                </div>
            </div> <!-- row -->
        </div> <!-- container -->
    </header>
    
    <!--====== HEADER PART ENDS ======-->
    
    <section class="pt-130 pb-10">
        <div class="container">
            <div class="row">
                <div class="col-12">
                <h2 class="mb-3"><?php echo translate("La compra ha fallat",$lang); ?></h1>        
                <h4 class="mb-3"><?php echo translate("El procés de pagament no ha pogut finalitzar",$lang); ?></h4>
                <ul class="actions mt-5">
                    <li><a href='<?php echo $server . 'event/' . $event_url; ?>' class="button special scrolly"><?php echo translate("Reintenta", $lang); ?></a></li>
                </ul>
                </div>
            </div>
        </div>
    </section>
   
    <!--====== PRODUCT PART START ======-->
    

  
    
    <?php
    include 'footer.php';
    ?>

</body>

</html>
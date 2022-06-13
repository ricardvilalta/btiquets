<!doctype html>
<html lang="en">
    
<?php
    
    include_once './../php/common.php';
    include_once './../php/funcions.php';
    include_once './../php/btdv_funcions.php';

    global $mysqli;
    global $lang;
    global $zone;


    $compte = "";
    $titol = "Taquilles BTiquets";

    if(isset($_GET['compte']))
        $nomcompte = $_GET['compte'];

    if($nomcompte!="")
    {
        $compteid = GetAccountId($mysqli,$nomcompte);
        $compteaux = GetAccountInfo($mysqli,$compteid);
        $titol = $compteaux['nom'];
    }

    $tipus = array(0=>'Esdeveniment amb data única',1=>'Esdeveniment amb múltiples sessions',2=>'Reserva de restaurant',3=>'Allotjaments',4=>'Venda de productes simple',5=>'Venda de productes avançada');
    $tipus_icons = array(0=>'lni-ticket',1=>'lni-calendar',2=>'lni-restaurant',3=>'lni-home',4=>'lni-tshirt',5=>'lni-cart'); 
?>

<head>
   
    <!--====== Required meta tags ======-->
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <!--====== Title ======-->
    <title>BTiquets</title>
    
    <!--====== Favicon Icon ======-->
    <link rel="shortcut icon" href="/favicon.png" type="image/png">

    <!--====== Bootstrap css ======-->
    <link rel="stylesheet" href="/front/assets/css/bootstrap.min.css">
    
    <!--====== Animate css ======-->
    <link rel="stylesheet" href="/front/assets/css/animate.css">
    
    <!--====== Magnific Popup css ======-->
    <link rel="stylesheet" href="/front/assets/css/magnific-popup.css">
    
    <!--====== Slick css ======-->
    <link rel="stylesheet" href="/front/assets/css/slick.css">
    
    <!--====== Line Icons css ======-->
    <link rel="stylesheet" href="/front/assets/css/LineIcons.css">
    
    <!--====== Default css ======-->
    <link rel="stylesheet" href="/front/assets/css/default.css">
    
    <!--====== Style css ======-->
    <link rel="stylesheet" href="/front/assets/css/style.css">
    
    <!--====== Responsive css ======-->
    <link rel="stylesheet" href="/front/assets/css/responsive.css">
  
  
</head>

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
                        <a class="navbar-brand portada" href="">
                            <img src="/front/assets/images/logo.png" alt="Logo">
                            <h1 class="header-title"><?php echo $titol; ?></h1>
                        </a> <!-- Logo -->                        
                    </nav> <!-- navbar -->
                </div>
            </div> <!-- row -->
        </div> <!-- container -->
    </header>
    
    <!--====== HEADER PART ENDS ======-->
   
   
    <!--====== PRODUCT PART START ======-->
    
    <!--====== ACTIVITATS ======-->
    
    <section id="product-A" class="product-area pt-150 pb-10">
        <div class="container">
            <h3>ACTIVITATS I VISITES</h3>
            <div class="row">
                <div class="col-12">
                    <div class="mt-30">
                        <div class="row">
                        <?php
                        $first = true;
                        if($nomcompte!="")
                        {
                            $box_list = GetBoxListHomebyCompte($mysqli,$nomcompte,1);
                        }
                        else
                        {
                            $box_list = GetBoxListHome($mysqli);
                        }
                        foreach($box_list as $box)
                        {
                            $compte = GetAccountInfo($mysqli,$box['propietari']);?> 
                            <div class="col-6 col-md-4 col-lg-3 mb-30">
                                <div class="single-product-items myproduct">
                                    <div class="product-item-image">
                                        <?php
                                        if(true)
                                        {?>
                                        <a href='<?php echo "/event/" . $box['url']; ?>' target="_blank">
                                            <div class="image_frame pt-4 px-2">
                                                <h4 class=""><?php echo $box['name']; ?></h4>
                                                <h5 class=""><?php echo $compte['nom']; ?></h5>
                                            </div>
                                            <!-- <img src='<?php echo "/boxes/box_" . $box["id"] . "/box_image_0_medium.jpg"; ?>' alt="<?php echo $box['name']; ?>"> -->
                                            <img src='<?php echo "/boxes/box_" . $box["id"] . "/box_image_0.jpg"; ?>' alt="<?php echo $box['name']; ?>">
                                        </a>
                                        <?php
                                        }
                                        else
                                        {?>

                                        <?php
                                        }
                                        ?>

                                    </div>
                                    <div class="product-item-content text-center">
                                        <div class="meta-product-1 d-flex justify-content-between align-items-center">
                                            <div class="image">
                                                <a href="#"><img src='<?php echo "/boxes/logo_image_" . $compte['id'] . ".png"; ?>' alt="compte"></a>
                                            </div>
                                            <div class="product-icon">
                                                <a href="#"><i class="<?php echo $tipus_icons[$box['etype']]; ?>"></i></a>
                                                <a href='<?php echo "/event/" . $box['url']; ?>' target="_blank"><i class="lni-share"></i></a>
                                            </div>
                                        </div>
<!--                                            <p class="product-rating"><?php echo $tipus[$box['etype']]; ?></p>-->
                                    </div>
                                </div> <!-- single product items -->
                            </div>
                        <?php
                        }

                        $first = false;
                        ?>
                        </div> <!-- row -->
                    </div> <!-- product items -->

                </div>
            </div> <!-- row -->
        </div> <!-- container -->
    </section>
    
    <!--====== PRODUCTES ======-->
    <?php
    if($nomcompte!="")
    {
        $box_list = GetBoxListHomebyCompte($mysqli,$nomcompte,2);
        if(count($box_list)>0)
        {?>
    <section id="product-B" class="product-area pt-10 pb-10">
        <div class="container">
            <h3>BOTIGA</h3>
            <div class="row">
                <div class="col-12">
                    <div class="mt-30">
                        <div class="row">
                        <?php
                        $first = true;                        
                        foreach($box_list as $box)
                        {
                            $compte = GetAccountInfo($mysqli,$box['propietari']);?> 
                            <div class="col-6 col-md-4 col-lg-3 mb-30">
                                <div class="single-product-items myproduct">
                                    <div class="product-item-image">
                                        <?php
                                        if(true)
                                        {?>
                                        <a href='<?php echo "/event/" . $box['url']; ?>' target="_blank">
                                            <div class="image_frame pt-4 px-2">
                                                <h4 class=""><?php echo $box['name']; ?></h4>
                                                <h5 class=""><?php echo $compte['nom']; ?></h5>
                                            </div>
                                            <img src='<?php echo "/boxes/box_" . $box["id"] . "/box_image_0_medium.jpg"; ?>' alt="<?php echo $box['name']; ?>">
                                        </a>
                                        <?php
                                        }
                                        else
                                        {?>

                                        <?php
                                        }
                                        ?>

                                    </div>
                                    <div class="product-item-content text-center">
                                        <div class="meta-product-1 d-flex justify-content-between align-items-center">
                                            <div class="image">
                                                <a href="#"><img src='<?php echo "/boxes/logo_image_" . $compte['id'] . ".png"; ?>' alt="compte"></a>
                                            </div>
                                            <div class="product-icon">
                                                <a href="#"><i class="<?php echo $tipus_icons[$box['etype']]; ?>"></i></a>
                                                <a href='<?php echo "/event/" . $box['url']; ?>' target="_blank"><i class="lni-share"></i></a>
                                            </div>
                                        </div>
<!--                                            <p class="product-rating"><?php echo $tipus[$box['etype']]; ?></p>-->
                                    </div>
                                </div> <!-- single product items -->
                            </div>
                        <?php
                        }

                        $first = false;
                        ?>
                        </div> <!-- row -->
                    </div> <!-- product items -->

                </div>
            </div> <!-- row -->
        </div> <!-- container -->
    </section>
        <?php
        }
    }?>
    
    
    <!--====== PRODUCT PART ENDS ======-->


    <!--====== FOOTER PART START ======-->
    
    <section id="footer" class="footer-area">
        <div class="container">
            <div class="footer-widget pt-75 pb-120">
                <div class="row">
                    <div class="col-lg-4 col-md-5 col-sm-7">
                        <div class="footer-logo mt-40">
                            <a href="#">
                                <img src="/front/assets/images/logo.png" alt="Logo">
                            </a>
                            <p class="mt-10">BTiquets és una marca de La Brocada Serveis SL <br>· Agència de Viatges GC-4734<br>· Serveis de desenvolupament turístic<br>· Promoció i comercialització web</p>

                        </div> <!-- footer logo -->
                    </div>
<!--
                    <div class="col-lg-2 col-md-4 col-sm-5">
                        
                    </div>
-->
                    <div class="col-lg-4 col-md-3 col-sm-5">
                        <div class="footer-link mt-50">
                            <h5 class="f-title">Legal</h5>
                            <ul>
                                <li><a href="#">Avís Legal</a></li>
                                <li><a href="#">Política de privacitat</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-5 col-sm-7">
                        <div class="footer-info mt-50">
                            <h5 class="f-title">Informació de contacte</h5>
                            <ul>
                                <li>
                                    <div class="single-footer-info mt-20">
                                        <span>Phone :</span>
                                        <div class="footer-info-content">
                                            <p>686 10 87 24</p>
                                        </div>
                                    </div> <!-- single footer info -->
                                </li>
                                <li>
                                    <div class="single-footer-info">
                                        <span>Email :</span>
                                        <div class="footer-info-content">
                                            <p>btiquets@btiquets.com</p>                                            
                                        </div>
                                    </div> <!-- single footer info -->
                                </li>                                
                            </ul>
                        </div> <!-- footer link -->
                    </div>
                </div> <!-- row -->
            </div> <!-- footer widget -->
            <div class="footer-copyright pt-15 pb-15">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="copyright text-center">
                            <p>BTiquets &#169; 2020 tots els drets reservats</p>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- container -->
    </section>
    
    <!--====== FOOTER PART ENDS ======-->
    
    <!--====== BACK TO TOP PART START ======-->
    
    <a href="#" class="back-to-top"><i class="lni-chevron-up"></i></a>
    
    <!--====== BACK TO TOP PART ENDS ======-->
    
    
    
    
    
    
    
    
    
    
    <!--====== jquery js ======-->
    <script src="/front/assets/js/vendor/modernizr-3.6.0.min.js"></script>
    <script src="/front/assets/js/vendor/jquery-1.12.4.min.js"></script>

    <!--====== Bootstrap js ======-->
    <script src="/front/assets/js/bootstrap.min.js"></script>
    
    
    <!--====== Slick js ======-->
    <script src="/front/assets/js/slick.min.js"></script>
    
    <!--====== Magnific Popup js ======-->
    <script src="/front/assets/js/jquery.magnific-popup.min.js"></script>

    
    <!--====== nav js ======-->
    <script src="/front/assets/js/jquery.nav.js"></script>
    
    <!--====== Nice Number js ======-->
    <script src="/front/assets/js/jquery.nice-number.min.js"></script>
    
    <!--====== Main js ======-->
    <script src="/front/assets/js/main.js"></script>

</body>

</html>

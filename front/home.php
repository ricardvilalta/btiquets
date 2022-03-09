<!doctype html>
<html lang="en">
    
<?php
    
    include_once './../php/common.php';
    include_once './../php/funcions.php';
    include_once './../php/btdv_funcions.php';

    global $mysqli;
    global $lang;
    global $zone;

    $tipus = array(0=>'Esdeveniment amb data única',1=>'Esdeveniment amb múltiples sessions',2=>'Reserva de restaurant',3=>'Allotjaments');
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
    <link rel="shortcut icon" href="./favicon.png" type="image/png">

    <!--====== Bootstrap css ======-->
    <link rel="stylesheet" href="./front/assets/css/bootstrap.min.css">
    
    <!--====== Animate css ======-->
    <link rel="stylesheet" href="./front/assets/css/animate.css">
    
    <!--====== Magnific Popup css ======-->
    <link rel="stylesheet" href="./front/assets/css/magnific-popup.css">
    
    <!--====== Slick css ======-->
    <link rel="stylesheet" href="./front/assets/css/slick.css">
    
    <!--====== Line Icons css ======-->
    <link rel="stylesheet" href="./front/assets/css/LineIcons.css">
    
    <!--====== Default css ======-->
    <link rel="stylesheet" href="./front/assets/css/default.css">
    
    <!--====== Style css ======-->
    <link rel="stylesheet" href="./front/assets/css/style.css">
    
    <!--====== Responsive css ======-->
    <link rel="stylesheet" href="./front/assets/css/responsive.css">
  
  
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
                        <a class="navbar-brand" href="">
                            <img src="./front/assets/images/logo.png" alt="Logo">
                        </a> <!-- Logo -->
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="bar-icon"></span>
                            <span class="bar-icon"></span>
                            <span class="bar-icon"></span>
                        </button>

                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul id="nav" class="navbar-nav ml-auto">
                                <li class="nav-item active">
                                    <a data-scroll-nav="0" href="#home">Inici</a>
                                </li>
<!--
                                <li class="nav-item">
                                    <a data-scroll-nav="0" href="/" target="_blank">Guixetes</a>
                                </li>
-->
                                <li class="nav-item">
                                    <a data-scroll-nav="0" href="#service">Serveis</a>
                                </li>
                                <li class="nav-item">
                                    <a data-scroll-nav="0" href="#contact">Contacte</a>
                                </li>
                            </ul> <!-- navbar nav -->
                        </div>
                    </nav> <!-- navbar -->
                </div>
            </div> <!-- row -->
        </div> <!-- container -->
    </header>
    
    <!--====== HEADER PART ENDS ======-->
   
    <!--====== SLIDER PART START ======-->
    
    <section id="home" class="slider-area pt-100 no-image-slider">
        <div class="container-fluid position-relative">
            <div class="slider-active">
                <div class="single-slider">
                    <div class="">
                        <div class="row no-gutters align-items-center ">
<!--
                            <div class="col-lg-4 col-md-5">
                                <div class="slider-product-image d-none d-md-block">
                                    <img src="/front/assets/images/slider/1.jpg" alt="Slider">
                                </div>
                            </div>
-->
                            <div class="col-12">
                                <div class="slider-product-content">
                                    <h1 class="slider-title mb-10" data-animation="fadeInUp" data-delay="0.3s">La <span>taquilla</span> més <span>còmode</span></h1>
                                    <p class="mb-25" data-animation="fadeInUp" data-delay="0.9s">Venda online d'esdeveniments, paquets turístics, productes <br> i tot tipus de propostes</p>
<!--                                    <a class="main-btn" href="/" target="_blank" data-animation="fadeInUp" data-delay="1.5s">Consulta les guixetes<i class="lni-chevron-right"></i></a>-->
                                </div> <!-- slider product content -->
                            </div>
                        </div> <!-- row -->
                    </div> <!-- container -->
                </div> <!-- single slider -->

                <div class="single-slider">
                        <div class="">
                            <div class="row no-gutters align-items-center">
<!--
                                <div class="col-lg-4 col-md-5">
                                    <div class="slider-product-image d-none d-md-block">
                                        <img src="/front/assets/images/slider/3.jpg" alt="Slider">
                                    </div>
                                </div>
-->
                                <div class="col-12">
                                    <div class="slider-product-content content-right">
                                        <h1 class="slider-title mb-10" data-animation="fadeInUp" data-delay="0.3s"><span>Incrementa</span> les <span>vendes</span></h1>
                                        <p class="mb-25" data-animation="fadeInUp" data-delay="0.9s">Millorant la presència<br> i facilitant la venda online</p>
<!--                                        <a class="main-btn" href="/" target="_blank" data-animation="fadeInUp" data-delay="1.5s">Consulta les guixetes <i class="lni-chevron-right"></i></a>-->
                                    </div> <!-- slider product content -->
                                </div>
                            </div> <!-- row -->
                        </div> <!-- container -->
                </div> <!-- single slider -->
                
                <div class="single-slider">
                        <div class="">
                            <div class="row no-gutters align-items-center">
                                <div class="col-12">
                                    <div class="slider-product-content">
                                        <h1 class="slider-title mb-10" data-animation="fadeInUp" data-delay="0.3s"><span>La solució</span> més <span>ràpida</span> i <span>eficaç</span></h1>
                                        <p class="mb-25" data-animation="fadeInUp" data-delay="0.9s">Diferents nivells d'integració <br> a la vostra web.</p>
                                    </div> <!-- slider product content -->
                                </div>
                            </div> <!-- row -->
                        </div> <!-- container -->
                </div> <!-- single slider -->

            </div> <!-- slider active -->
<!--
            <div class="slider-social">
                <div class="row justify-content-end">
                    <div class="col-lg-7 col-md-6">
                        <ul class="social text-right">
                            <li><a href="#"><i class="lni-facebook-filled"></i></a></li>
                            <li><a href="#"><i class="lni-twitter-original"></i></a></li>
                            <li><a href="#"><i class="lni-instagram"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
-->
        </div> <!-- container fluid -->
    </section>
    
    <!--====== SLIDER PART ENDS ======-->
   
    <!--====== SERVICES PART START ======-->
    
    <section id="service" class="services-area pt-125 pb-130">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="section-title pb-30">
                        <h5 class="mb-15">Els nostres serveis</h5>
                        <h3 class="title mb-15">Necessites administrar la teva pròpia taquilla?</h3>
                        <p>BTiquets és una eina que permet fer la venda online de tot tipus d'esdeveniments, podent-se utilitzar com un potent administrador de reserves o tan sols per gestionar la venda de tiquets d'un esdeveniment puntual. S'adapta a les teves necessitats.</p>
                    </div> <!-- section title -->
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="services-left mt-45">
                        <div class="services">
                            <img src="./front/assets/images/services/services.png" alt="">
                            <a href="#contact" class="main-btn mt-30">Sol·licita informació <i class="lni-chevron-right"></i></a>
                        </div> <!-- services btn -->
                    </div> <!-- services left -->
                </div>
                <div class="col-lg-6">
                    
                    <div class="services-right mt-45">
                        <div class="row justify-content-center">
                            <div class="col-md-6 col-sm-8">
                                <div class="single-services text-center">
                                    <div class="services-icon">
                                        <i class="lni-grid-alt"></i>
                                    </div>
                                    <div class="services-content mt-20">
                                        <h5 class="title mb-10">Administrador</h5>
                                        <p>Gestiona totes les teves reserves del teu establiment</p>
                                    </div>
                                </div> <!-- single services -->
                                
                                <div class="single-services text-center mt-30">
                                    <div class="services-icon">
                                        <i class="lni-ruler-pencil"></i>
                                    </div>
                                    <div class="services-content mt-20">
                                        <h5 class="title mb-10">Disseny</h5>
                                        <p>Edita els teus esdeveniments, administrant sessions, l'aspecte i les modalitats de preu</p>
                                    </div>
                                </div> <!-- single services -->
                            </div>
                            <div class="col-md-6 col-sm-8">
                                <div class="single-services text-center mt-30">
                                    <div class="services-icon">
                                        <i class="lni-customer"></i>
                                    </div>
                                    <div class="services-content mt-20">
                                        <h5 class="title mb-10">Suport</h5>
                                        <p>Us ajudem en tot el necessari, i trobem solucions específiques i creatives a les vostres necessitats.</p>
                                    </div>
                                </div> <!-- single services -->
                                
                                <div class="single-services text-center mt-30">
                                    <div class="services-icon">
                                        <i class="lni-support"></i>
                                    </div>
                                    <div class="services-content mt-20">
                                        <h5 class="title mb-10">Serveis addicionals</h5>
                                        <p>TPV virtual propi, disseny web i integració, i cobertura AAVV per a la venda de paquets combinats.</p>
                                    </div>
                                </div> <!-- single services -->
                            </div>
                        </div> <!-- row -->
                    </div> <!-- services right -->
                </div>
            </div> <!-- row -->
        </div> <!-- container -->
    </section>
    
    <!--====== SERVICES PART ENDS ======-->
    

    <!--====== CONTACT PART START ======-->
    
    <section id="contact" class="contact-area pt-115">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="contact-title text-center">
                        <h2 class="title">Escriu-nos</h2>
                    </div> <!-- contact title -->
                </div>
            </div> <!-- row -->
            <div class="contact-box mt-70">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="contact-info pt-25">
                            <h4 class="info-title">Informació de contacte</h4>
                            <ul>
                                <li>
                                    <div class="single-info mt-30">
                                        <div class="info-icon">
                                            <i class="lni-phone-handset"></i>
                                        </div>
                                        <div class="info-content">
                                            <p>686 10 87 24</p>
                                        </div>
                                    </div> <!-- single info -->
                                </li>
                                <li>
                                    <div class="single-info mt-30">
                                        <div class="info-icon">
                                            <i class="lni-envelope"></i>
                                        </div>
                                        <div class="info-content">
                                            <p>btiquets@btiquets.com</p>
                                        </div>
                                    </div> <!-- single info -->
                                </li>
                            </ul>
                        </div> <!-- contact info -->
                    </div> 
                    <div class="col-lg-8">
                        <div class="contact-form">
                            <form id="contactForm" method="post" data-toggle="validator">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="single-form form-group">
                                            <input type="text" name="name" id="name" placeholder="Nom" data-error="el nom és obligatori" required="required">
                                            <div class="help-block with-errors"></div>
                                        </div> <!-- single form -->
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="single-form form-group">
                                            <input type="email" name="email" id="email" placeholder="Email"  data-error="un email vàlid és obligatori" required="required">
                                            <div class="help-block with-errors"></div>
                                        </div> <!-- single form -->
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="single-form form-group">
                                            <textarea name="message" id="message" placeholder="Missatge" data-error="Sisplau, indica el missatge" required="required"></textarea>
                                            <div class="help-block with-errors"></div>
                                        </div> <!-- single form -->
                                    </div>
                                    <p class="form-message"></p>
                                    <div class="col-lg-12">
                                        <div class="single-form form-group">
                                            <button class="main-btn" type="submit">ENVIA</button>
                                        </div> <!-- single form -->
                                    </div>
                                </div> <!-- row -->
                            </form>
                        </div> <!-- row -->
                    </div> 
                </div> <!-- row -->
            </div> <!-- contact box -->
        </div> <!-- container -->
    </section>
    
    <!--====== CONTACT PART ENDS ======-->

    <!--====== FOOTER PART START ======-->
    
    <section id="footer" class="footer-area">
        <div class="container">
            <div class="footer-widget pt-75 pb-120">
                <div class="row">
                    <div class="col-lg-4 col-md-5 col-sm-7">
                        <div class="footer-logo mt-40">
                            <a href="#">
                                <img src="./front/assets/images/logo.png" alt="Logo">
                            </a>
                            <p class="mt-10">BTiquets és una marca de La Brocada Serveis SL <br>· Agència de Viatges GC-4734<br>· Serveis de desenvolupament turístic<br>· Promoció i comercialització web</p>
<!--
                            <ul class="footer-social mt-25">
                                <li><a href="#"><i class="lni-facebook-filled"></i></a></li>
                                <li><a href="#"><i class="lni-twitter-original"></i></a></li>
                                <li><a href="#"><i class="lni-instagram"></i></a></li>
                            </ul>
-->
                        </div> <!-- footer logo -->
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-5">
                        <div class="footer-link mt-50">
                            <h5 class="f-title">Menu</h5>
                            <ul>
                                <li><a href="#home">Inici</a></li>
<!--                                <li><a href="/" target="_blank">Guixetes</a></li>-->
                                <li><a href="#service">Serveis</a></li>
                                <li><a href="#contact">Contacte</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-5">
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
    <script src="./front/assets/js/vendor/modernizr-3.6.0.min.js"></script>
    <script src="./front/assets/js/vendor/jquery-1.12.4.min.js"></script>

    <!--====== Bootstrap js ======-->
    <script src="./front/assets/js/bootstrap.min.js"></script>
    
    
    <!--====== Slick js ======-->
    <script src="./front/assets/js/slick.min.js"></script>
    
    <!--====== Magnific Popup js ======-->
    <script src="./front/assets/js/jquery.magnific-popup.min.js"></script>

    
    <!--====== nav js ======-->
    <script src="./front/assets/js/jquery.nav.js"></script>
    
    <!--====== Nice Number js ======-->
    <script src="./front/assets/js/jquery.nice-number.min.js"></script>
    
    <!--====== Main js ======-->
    <script src="./front/assets/js/main.js"></script>
    
    <script src="./front/assets/js/contact-form-script.min.js"></script>
    
    

</body>

</html>

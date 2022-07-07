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


    
    <?php
    include 'footer.php';
    ?>

</body>

</html>

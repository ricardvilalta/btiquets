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

    $info_reserva = GetReservation_by_ref($mysqli,$reserva);
    if($info_reserva!=null)
    {
        $box = GetBox($mysqli,$info_reserva['box_id']);
        $quant_modalities = explode(';',$info_reserva['quantitat']);
        $price_modalities = decode_price($box['price'],false);        
        $total = 0;
        $tiquets_reservats = "";
        
        if($box['etype']==5 || $box['etype']==7)
        {
            $pvp = "TOTAL = " . $info_reserva['total'] . "€";
        }
        else
        {
            for($i=0;$i<count($price_modalities);$i++)
            {
                $price = floatval($price_modalities[$i]['price']);
                if($quant_modalities[$i]!='undefined' && $quant_modalities[$i]!=null)
                {
                    $quant = intval($quant_modalities[$i]);

                    if($quant>0)
                    {
                        $str = $quant . ' x ' . $price_modalities[$i]['name'] . '</br>';
                        $tiquets_reservats .= $str;
                    }
                }
                else
                {
                    $quant = 0;
                }

                $subtotal = $quant*$price;
                $total += $subtotal;
            }

            $pvp = "TOTAL = " . $total . "€";
        }        
        

        $sdata = date_create_from_format('Y-m-d H:i:s',$info_reserva['data_session']);
        $edate_d = date_format($sdata,'d-m-Y');  
        $edate_h = date_format($sdata,'H:i');  

        $rdata = date_create_from_format('Y-m-d H:i:s',$info_reserva['data_res']);
        $date_session = date_format($rdata,'d-m-Y');
        $time_session = date_format($rdata,'H:i');
        $data_2 = $date_session . " " . $time_session;
        $data_3 = $date_session;

        $rdata2 = date_create_from_format('Y-m-d',$info_reserva['data_res_out']);
        $date_session_out = date_format($rdata2,'d-m-Y');
        $data_4 = $date_session_out;
        
        $dades_personals = $info_reserva["rnom"] . '<br>' . $info_reserva["rmail"] . '<br>' . $info_reserva["rtel"] . '<br>';
        if($info_reserva["raddr1"]!="") {$dades_personals .= $info_reserva["raddr1"];$dades_personals .= '<br>';}
        if($info_reserva["raddr2"]!="") {$dades_personals .= $info_reserva["raddr2"];$dades_personals .= '<br>';}
        if($info_reserva["rcp"]!="") {$dades_personals .= $info_reserva["rcp"];$dades_personals .= '<br>';}
        if($info_reserva["rmun"]!="") {$dades_personals .= $info_reserva["rmun"];$dades_personals .= '<br>';}

        $reshotelinfo = GetHotelReservation($mysqli,$info_reserva['quantitat']);
    }

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
        <?php
        if($box["etype"]==2)
        {?>
        <h2 class="mb-3"><?php echo translate("Sol·litud de reserva correcta",$lang); ?></h2>        
        <h4 class="mb-3"><?php echo translate("La sol·licitud s'ha realitzat correctament.<br>Aquí tens les dades de la sol·licitud:",$lang); ?></h4>
        <div><?php echo translate("Recorda que la reserva no és vàlida fins que no rebis la corresponent confirmació de l'establiment. Si no rebeu la confirmació en les properes 2 hores, heu de considerar la reserva no atesa i, per tant, no vàlida",$lang); ?></div>
        <div class="rdades mt-5 font-weight-bold">
            <div><?php echo $box['name']; ?></div>
            <div><?php echo translate("Referència",$lang) . ": " . strtoupper($info_reserva['ref']); ?></div>
            <div><?php echo translate("Data",$lang) . ": " . $data_2; ?></div>
            <div><?php echo translate("Comentaris",$lang) . ": " . $info_reserva['comentaris']; ?></div>
            <div><?php echo $tiquets_reservats; ?></div>             
        </div>
        <?php
        }
        else if($box["etype"]==3)
        {?>
        <h2 class="mb-3"><?php echo translate("Sol·litud de reserva correcta",$lang); ?></h2>
        <h4 class="mb-3"><?php echo translate("La sol·licitud s'ha realitzat correctament.<br> Aquí tens les dades de la sol·licitud:",$lang); ?></h4>
        <div><?php echo translate("Recorda que la reserva no és vàlida fins que no rebis la corresponent confirmació de l'establiment. Si no rebeu la confirmació en les properes 2 hores, heu de considerar la reserva no atesa i, per tant, no vàlida",$lang); ?></div>
        <div class="rdades mt-5 font-weight-bold">
            <div><?php echo $box['name']; ?></div>
            <div><?php echo translate("Reserva",$lang) . ": " . $reshotelinfo['name'] . " - " . $reshotelinfo['modalitat']; ?></div>
            <div><?php echo translate("Referència",$lang) . ": " . strtoupper($info_reserva['ref']); ?></div>
            <div><?php echo translate("Data d'entrada",$lang) . ": " . $data_3; ?></div>
            <div><?php echo translate("Data de sortida",$lang) . ": " . $data_4; ?></div>
            <div><?php echo translate("Comentaris",$lang) . ": " . $info_reserva['comentaris']; ?></div>
            <div><?php echo $tiquets_reservats; ?></div>             
        </div>
        <?php
        }
        else if($box["etype"]==4 || $box["etype"]==5 || $box["etype"]==7)
        {?>
        <h2 class="mb-3"><?php echo translate("Compra correcta",$lang); ?></h2>        
        <h4 class="mb-3"><?php echo translate("La compra s'ha realitzat correctament.<br> Aquí tens les dades de la compra:",$lang); ?></h4>
        <div><?php echo translate("S'ha enviat un correu de confirmació a la teva adreça. Si no el reps, no pateixis, apunta la referència que et servirà d'identificador de la compra",$lang); ?></div>
        <div class="rdades mt-5 font-weight-bold">
            <div><?php echo $box['name']; ?></div>
            <div><?php echo translate("Referència",$lang) . ": " . strtoupper($info_reserva['ref']); ?></div>
            <div><?php echo $tiquets_reservats; ?></div>
            <div><?php echo $pvp; ?></div>
            <br>
            <div><?php echo $dades_personals; ?></div>
            <br>
            <div><?php if($box['recordatori']!="") echo translate("INFORMACIÓ",$lang) . ": " . $box['recordatori']; ?></div>
        </div>
        <?php
        }
        else
        {?>
        <h2 class="mb-3"><?php echo translate("Reserva correcta",$lang); ?></h2>
        <h4 class="mb-3"><?php echo translate("La reserva s'ha realitzat correctament.<br> Aquí tens les dades de la reserva:",$lang); ?></h4>
        <?php if($box['id']==502 || $box['id']==510 || $box['id']==511) {// TRANSÈQUIA 2022 ?>
        <div><?php echo translate("S'ha enviat un correu de confirmació a la teva adreça. Si no el reps, comprova el correu brossa o sol·licita'ns que us la reenviem indicant de nou el vostre correu electrònic. En qualsevol cas, anoteu la referència de la reserva.",$lang); ?></div>
        <?php } else {?>
        <div><?php echo translate("S'ha enviat un correu de confirmació a la teva adreça. Si no el reps, no pateixis, apunta la referència que et servirà d'identificador el dia que realitzis l'activitat",$lang); ?></div>
        <?php }?>
        <div class="rdades mt-5 font-weight-bold">
            <div><?php echo $box['name']; ?></div>
            <div><?php echo translate("Referència",$lang) . ": " . strtoupper($info_reserva['ref']); ?></div>
            <?php
            if($box['id']==502 || $box['id']==510 || $box['id']==511) {// TRANSÈQUIA 2022 ?>
            <div><?php echo translate("Data",$lang) . ": " . $edate_d; ?></div>
            <?php } else {?>
            <div><?php echo translate("Data",$lang) . ": " . $edate_d . " " . $edate_h; ?></div>
            <?php }?>
            <div><?php echo $tiquets_reservats; ?></div>
            <div><?php echo $pvp; ?></div>
            <br>
            <div><?php echo $dades_personals; ?></div>
            <br>
            <div><?php if($box['recordatori']!="") echo translate("INFORMACIÓ",$lang) . ": " . $box['recordatori']; ?></div>
        </div>
        <?php
        }?>
        <ul class="actions">
            <li><a href='<?php echo $server . 'event/' . $event_url; ?>' class="button special scrolly"><?php if($box["etype"]==4 || $box["etype"]==5) echo translate("Fer una nova compra", $lang); else echo translate("Fer una nova reserva", $lang); ?></a></li>
        </ul>
        <?php
        if($box['id']==348 || $box['id']==358 || $box['id']==359 || $box['id']==360 || $box['id']==361 || $box['id']==362 || $box['id']==363)
        {
            $url = $server . 'event/' . $event_url;
        ?>
        <ul class="actions mt-5">
            <li><button type="button" class="btn btn-outline btn-primary"><a href='<?php echo "https://www.facebook.com/sharer/sharer.php?u=".$url; ?>' target="_blank"><?php echo translate("Comparteix-ho a Facebook", $lang); ?></a></button></li>
            <li><button type="button" class="btn btn-outline btn-info"><a href='<?php echo "https://twitter.com/intent/tweet?url=".$url."&text=Jo%20ja%20he%20fet%20la%20meva%20aportaci%C3%B3%20a%20la%20TRANSÉQUIA%202021"; ?>' target="_blank"><?php echo translate("Comparteix-ho a Twitter", $lang); ?></a></button></li>
        </ul>
        <?php
        }?>
                </div>
            </div>
        </div>
    </section>
   
    <!--====== PRODUCT PART START ======-->
    
    <!--====== ACTIVITATS ======-->
    <?php
    $productes_relacionats = explode(';',$box['productes_relacionats']);
    if(sizeof($productes_relacionats)>0) {?>    
    <section id="product-A" class="product-area pt-80 pb-10">
        <div class="container">
            <h3>També et podria interessar</h3>
            <div class="row">
                <div class="col-12">
                    <div class="mt-30">
                        <div class="row">
                        <?php
                        $first = true;
                        foreach($productes_relacionats as $pid)
                        {
                            if(intval($pid)>0){
                                $boxiter = GetBox($mysqli,$pid);
                                $compte = GetAccountInfo($mysqli,$boxiter['propietari']);?> 
                                <div class="col-6 col-md-4 col-lg-3 mb-30">
                                    <div class="single-product-items myproduct">
                                        <div class="product-item-image">
                                            <?php
                                            if(true)
                                            {?>
                                            <a href='<?php echo "/event/" . $boxiter['url']; ?>' target="_blank">
                                                <div class="image_frame pt-4 px-2">
                                                    <h4 class=""><?php echo $boxiter['name']; ?></h4>
                                                    <h5 class=""><?php echo $compte['nom']; ?></h5>
                                                </div>
                                                <!-- <img src='<?php echo "/boxes/box_" . $boxiter["id"] . "/box_image_0_medium.jpg"; ?>' alt="<?php echo $boxiter['name']; ?>"> -->
                                                <img src='<?php echo "/boxes/box_" . $boxiter["id"] . "/box_image_0.jpg"; ?>' alt="<?php echo $boxiter['name']; ?>">
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
                                                    <a href="#"><i class="<?php echo $tipus_icons[$boxiter['etype']]; ?>"></i></a>
                                                    <a href='<?php echo "/event/" . $boxiter['url']; ?>' target="_blank"><i class="lni-share"></i></a>
                                                </div>
                                            </div>
    <!--                                            <p class="product-rating"><?php echo $tipus[$boxiter['etype']]; ?></p>-->
                                        </div>
                                    </div> <!-- single product items -->
                                </div>
                        <?php
                            }
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
    ?>
  
    
    <?php
    include 'footer.php';
    ?>

</body>

</html>
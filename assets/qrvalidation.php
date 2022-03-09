<script type="text/javascript">
    $(document).ready(function()
    {
        $('#validar').click(function(){
            $.ajax({  
                type: "POST",  
                url: "<?php echo $rootfolder; ?>" + "php/server_actions.php",  
                data: {
                    op:"validar_reserva",
                    id: "<?php echo $reserva; ?>",
                    com: $('#val_comment').val(),
                    val: 1
                },
                dataType: 'json'
            }).always(function(ret)
            {
                alert('<?php echo translate("Reserva validada", $lang); ?>');
                location.reload(); 
            });
        });
    });
</script>

<?php
    $info_reserva = GetReservation_by_ref($mysqli,$reserva);
    if($info_reserva!=null)
    {
        $box = GetBox($mysqli,$info_reserva['box_id']);
        $quant_modalities = explode(';',$info_reserva['quantitat']);
        $price_modalities = decode_price($box['price'],false);        
        $total = 0;
        $tiquets_reservats = "";
        global $ereserva_1,$ereserva_2,$ereserva_3;
        if($box['etype']<=1) $estat = $ereserva_1[$info_reserva['confirmat']]; 
        else if($box['etype']==4 || $box['etype']==5 || $box['etype']==7) $estat = $ereserva_3[$info_reserva['confirmat']]; 
        else $estat = $ereserva_2[$info_reserva['confirmat']];

        if($info_reserva['validat']) $estat = "Reserva validada";
        
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
        $edate = date_format($sdata,'d-m-Y H:i');  

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

//    if($time_session=="00:00")
//    {
//        $data_2 = $date_session . " MIGDIA";
//    }
//    else
//    {
//        $data_2 = $date_session . " NIT";
//    }
?>

<header>
    <div class="header_background">
    <h1><?php echo $estat; ?></h1>  
        <?php
        if($box["etype"]==2)
        {?>              
        <div style="margin-top:2em;margin-bottom:2em;font-weight: bold;color: #FFFFFF;" class="content">
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
        <div style="margin-top:2em;margin-bottom:2em;font-weight: bold;color: #FFF  FFF;" class="content">
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
        <div style="margin-top:2em;margin-bottom:2em;font-weight: bold;color: #FFFFFF;" class="content">
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
        <div style="margin-top:2em;margin-bottom:2em;font-weight: bold;color: #FFFFFF;" class="content">
            <div><?php echo $box['name']; ?></div>
            <div><?php echo translate("Referència",$lang) . ": " . strtoupper($info_reserva['ref']); ?></div>
            <div><?php echo translate("Data",$lang) . ": " . $edate; ?></div>
            <div><?php echo $tiquets_reservats; ?></div>
            <div><?php echo $pvp; ?></div>
            <br>
            <div><?php echo $dades_personals; ?></div>
            <br>
            <?php
            $dades_list = decode_dades($info_reserva['dades']);                
            foreach($dades_list as $dades_iter)
            {?>
            <div><?php echo "NOM: " . $dades_iter['nom'] . " DNI: " . $dades_iter['dni']; ?></div>
            <?php
            }?>
            <br>
            <div><?php echo "AUTOCAR: " . ($info_reserva['check_1']?"SI":"NO"); ?></div>
            <div><?php echo "CORRENT: " . ($info_reserva['check_2']?"SI":"NO"); ?></div>
            <div><?php echo "CELIAQUIA: " . ($info_reserva['check_3']?"SI":"NO"); ?></div>
            <br>
            <div><?php if($box['recordatori']!="") echo translate("INFORMACIÓ",$lang) . ": " . $box['recordatori']; ?></div>
            <br>
            <div><?php echo "RESERVA VALIDADA: " . ($info_reserva['validat']?"SI":"NO"); ?></div>
        </div>
        <?php
        }?>
        <?php
        if(login_check($mysqli,"btiquets_login_string")) {?>
        <ul class="actions">
            <li><a id="validar" class="button special"><?php echo translate("VALIDAR RESERVA", $lang);?></a></li>
        </ul>
        <div class="12u$">
            <label>Comentari validació</label>
            <textarea name="val_comment" id="val_comment"><?php if($info_reserva!=null) echo $info_reserva['val_com'];?></textarea>
        </div>
        <?php
        }?>
        <?php
        if($box['id']==348 || $box['id']==358 || $box['id']==359 || $box['id']==360 || $box['id']==361 || $box['id']==362 || $box['id']==363)
        {
            $url = $server . 'event/' . $event_url;
        ?>
        <ul class="actions">
            <li><button type="button" class="btn btn-outline btn-primary"><a href='<?php echo "https://www.facebook.com/sharer/sharer.php?u=".$url; ?>' target="_blank"><?php echo translate("Comparteix-ho a Facebook", $lang); ?></a></button></li>
            <li><button type="button" class="btn btn-outline btn-info"><a href='<?php echo "https://twitter.com/intent/tweet?url=".$url."&text=Jo%20ja%20he%20fet%20la%20meva%20aportaci%C3%B3%20a%20la%20TRANSÉQUIA%202021"; ?>' target="_blank"><?php echo translate("Comparteix-ho a Twitter", $lang); ?></a></button></li>
        </ul>
        <?php
        }?>
        
        
    </div>
</header>
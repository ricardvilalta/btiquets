<?php    
?>

<script type="text/javascript">

    $(document).ready(function()
    {   
        $('.item_reserva').click(function(){
            $("#room").val($(this).prev().attr("hid")+'_'+$(this).prev().attr("rid"));
            $("#preu_unit").val($(this).prev().attr("price"));
            $("#field1").html($(this).prev().attr("hname") + " (" + $(this).prev().attr("hmun") + ")");
            $("#field2").html($(this).prev().attr("rname") + " - " + $(this).prev().attr("price") + "€/nit");
            $("#field3").html($(this).prev().attr("hname") + " (" + $(this).prev().attr("hmun") + ")");
            $("#field4").html($(this).prev().attr("rname"));
            $("#hname").val($(this).prev().attr("hname"));
            $("#rname").val($(this).prev().attr("rname"));
            $('html, body').animate({
                scrollTop: $("#two").offset().top
            }, 2000);            
        });
        
    });

</script>

<div class="container">
    <?php
    if(count($imglist)==0)
    {?>
    <span class="image fit primary"></span>
    <?php
    }
    else
    {?>
    <span class="image fit primary"><img src="<?php echo $rootfolder . "boxes/box_" . $event . "/box_image_1.jpg"; ?>" alt="" /></span>
    <?php
    }?>
    <a href="#header" class="goto-prev scrolly">Prev</a>
    <div class="content">
        <header class="major">
            <h2><?php echo translate("Allotjaments", $lang); ?></h2>
        </header>
        <h3><?php echo $subtitle; ?></h3>
        <section>
<!--
        <div class="row uniform">
            <div class="12u" id="comlist">
                <div class="select-wrapper">
                    <select class="quant_input">
                        <?php
                        foreach($hotel_list as $hotel)
                        {?>
                        <option value="<?php echo $hotel['id']; ?>"><?php echo $hotel['name']; ?></option>
                        <?php
                        }?>
                    </select>
                </div>
            </div>
        </div>
-->
        <div class="row uniform">
        <?php
        foreach($hotel_list as $hotel)
        {?>
            <div class="12u all_image">
                <img src="<?php echo $rootfolder . "allotjaments/all_" . $hotel['id'] . "/all_image_0.jpg"; ?>" width="470px" height="auto">
            </div>        
            <div class="4u all_dades">
                <h4><?php echo $hotel['name']; ?></h4>
                <h5><?php echo $hotel['poblacio']; ?></h5>
                <p><?php echo $hotel['desc']; ?></p>
            </div>
            <div class="8u all_dades">
                <h5><?php if($hotel['type']==0) echo translate("LLOGUER CASA/ESPAIS", $lang); else if($hotel['type']==1) echo translate("LLOGUER PER HABITACIONS", $lang); ?></h5>
                <ul class="alt">
                    <li></li>
                    <?php
                    foreach($hotel['modalitat'] as $room)
                    {?>                    
                    <li class="item_line">
                        <div hname="<?php echo $hotel['name']; ?>" hmun="<?php echo $hotel['poblacio']; ?>" rname="<?php echo $room['nom']; ?>" price="<?php echo $room['preu']; ?>" hid="<?php echo $hotel['id']; ?>" rid="<?php echo $room['id']; ?>" class="6u">
                            <?php echo '<h6>' . $room['nom'] . '</h6><p>' . $room['desc'] . '</p><div class="preu">' . $room['preu'] . '€</div>'; ?>
                        </div>
                        <a class="button special small item_reserva">Tria</a>
                    </li>
                    <?php
                    }?>
                </ul>
            </div>
        <?php
        }?>
        </div>
        </section>
    </div>
    <a href="#two" class="goto-next scrolly">Next</a>
</div>
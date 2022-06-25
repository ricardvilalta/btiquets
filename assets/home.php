<?php    
?>

<script type="text/javascript">

    $(document).ready(function()
    {   
    });

</script>

<div class="container">
    <span class="image fit primary"><img src="<?php echo $rootfolder . "boxes/box_" . $event . "/box_image_1.jpg"; ?>" alt="" /></span>
    <a href="#header" class="goto-prev scrolly">Prev</a>
    <div class="content">
        <header class="major">
            <h2><?php echo translate("PROPOSTES", $lang); ?></h2>
        </header>
        <h3><?php echo $subtitle; ?></h3>
        <section>
        <div class="row uniform">
        <?php
        foreach($box_list as $box)
        {?>
            <div class="12u all_image">
                <img src="<?php echo $rootfolder . "boxes/box_" . $box['id'] . "/box_image_1.jpg"; ?>" width="470px" height="auto">
            </div>        
            <div class="4u all_dades">
                <h4><?php echo $box['name']; ?></h4>
<!--                <h5><?php echo $box['poblacio']; ?></h5>-->
                <p><?php echo $box['desc']; ?></p>
            </div>
            <div class="8u all_dades">
                <h5><?php echo translate("OPCIONS", $lang); ?></h5>
                <ul class="alt">
                    <li></li>
                    <?php
                    foreach($box['modalitat'] as $room)
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
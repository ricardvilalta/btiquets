<header class="major">
    <div style="background:rgba(150,150,150,.8);padding:20px 20px;" class="header_background">
        <h1><?php echo $box['name']; ?></h1>
        <?php if($subtitle!="")
        {?>
        <h3><?php echo $subtitle; ?></h3>
        <?php
        }?>
        <h4><?php echo $box['description']; ?></h4>
    </div>
</header>
<div class="container">    
    <ul class="actions">
        <li>
            <?php
            if($valid==1)
            {?>
            <a href="#one" class="button special scrolly"><?php if($box['etype']==2 || $box['etype']==3) echo translate("Comença la reserva", $lang); else if($box['etype']==4 || $box['etype']==5) echo translate("Comença la compra", $lang); else echo translate("Comença la inscripció", $lang); ?></a>
            <?php
            }
            else if($valid==-1)
            {?>
            <a href="" class="button special scrolly"><?php echo translate("Taquilla tancada", $lang); ?></a>
            <?php
            }
            else if($valid==-2)
            {?>
            <a href="" class="button special scrolly"><?php echo translate("Sense places", $lang); ?></a>
            <?php
            }?>
        </li>
    </ul>
</div>
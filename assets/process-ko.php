<header class="major">
    <div style="" class="header_background">
        <h1><?php echo translate("La compra ha fallat",$lang); ?></h1>        
        <h4><?php echo translate("El procés de pagament no ha pogut finalitzar",$lang); ?></h4>
        <ul class="actions">
            <li><a href='<?php echo $server . 'event/' . $event_url; ?>' class="button special scrolly"><?php echo translate("Reintenta", $lang); ?></a></li>
        </ul>
    </div>
</header>

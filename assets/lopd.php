<?php
    global $mysqli;
    if($compte>0)
    {
        $comptedata = GetAccountInfo($mysqli,$compte);
        $lopdtext = stripslashes($comptedata["lopd"]);
        if($lopdtext=="")
        {
            $lopdtext = stripslashes(translate(privacitat_1, $lang));
        }
    }
    else
    {
        $lopdtext = stripslashes(translate(privacitat_1, $lang));
    }
?>

<header>
    <div class="header_background">
        <h1><?php echo translate("Política de privacitat",$lang); ?></h1>
        <div class="legal_text"><?php echo $lopdtext; ?></div>
    </div>
</header>
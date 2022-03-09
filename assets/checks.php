<?php
if($box['id']==502 || $box['id']==510 || $box['id']==511) 
{?>
<div class="12u$(xsmall)">
    <input type="checkbox" name="lopd" id="lopd"/>
    <label for="lopd">Accepto complir amb el reglament de la <a href="https://transequia.cat/wp-content/uploads/2022/02/REGLAMENT-DE-LA-TRANSEQUIA_2022.pdf" target="_blank">Transéquia</a> i que se m´ha informat del seu contingut, així com dels meus drets en matèria de protecció de dades personals i dono el meu consentiment al tractament d´aquestes dades i la cessió dels drets d’imatge com a participant a l´activitat TRANSÉQUIA a la Fundació Aigües de Manresa – Junta de la Sèquia</label>
</div>
<?php
}
else
{?>
<div class="12u$(xsmall)">
    <input type="checkbox" name="lopd" id="lopd"/>
    <label for="lopd"><?php echo translate("Accepto la ", $lang) . '<a href="/lopd/' . $compte['id'] . '" target="_blank">' . translate("política de privacitat", $lang) . '</a>' . " " . translate("(obligatòria)", $lang); ?></label>
</div>
<?php
}?>

<?php
if($box['xaccept'])
{?>
<div style="text-align: left;" class="12u$(xsmall)">
    <input type="checkbox" name="xaccept" id="xaccept"/>
    <label for="xaccept"><?php echo $box['xaccept_description'] . " " . translate("(obligatòria)", $lang); ?></label>
</div>
<?php
}
else
{?>
<input style="display:none" type="checkbox" name="xaccept" id="xaccept"/>
<?php
}?>

<?php
if($box['id']==502 || $box['id']==510 || $box['id']==511) 
{?>
<div style="text-align: left;" class="12u$(xsmall)">
    <input type="checkbox" name="newsletter" id="newsletter"/>
    <label for="newsletter">Autoritzo expressament a la Fundació Aigües de Manresa – Junta de la Sèquia a facilitar les meves dades personals a les empreses patrocinadores de la Transéquia d’enguany, amb la finalitat que em puguin enviar, per mitjans telemàtics, informació únicament dels seus serveis i activitats</label>
</div>
<?php
}
else
{?>
<div style="text-align: left;" class="12u$(xsmall)">
    <input type="checkbox" name="newsletter" id="newsletter"/>
    <label for="newsletter"><?php echo translate("Accepto que les meves dades siguin incorporades en un fitxer de ", $lang) . $compte['nom'] . translate(" per a rebre informació de les seves activitats", $lang); ?></label>
</div>
<?php
}?>
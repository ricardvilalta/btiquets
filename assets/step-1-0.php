<?php    
// ESDEVENIMENT ÚNIC i PRODUCTES SIMPLES
// PAS 1

if($box['id']==502 || $box['id']==510 || $box['id']==511 || $box['id']==207) // TRANSÈQUIA 2022
{
    $dadesindividuals = 
    '<div class="row uniform dades_linia">
        <div class="3u">
            <label class="formulari">Gènere</label>
            <div class="select-wrapper">
                <select class="camp_1 required">
                    <option value="-1">-</option>
                    <option value="1">Home</option>
                    <option value="2">Dona</option>
                    <option value="3">No binari</option>
                </select>
            </div>
        </div>
        <div class="6u">
            <label class="formulari">Nom i Cognoms</label>
            <input class="required camp_2" type="text" />
        </div>
        <div class="3u$">
            <label class="formulari">DNI</label>
            <input class="required camp_3" type="text"/>
        </div>
        <div class="12u$(xsmall)">
            <input type="checkbox" class="camp_4">
            <label>Participant menor de 18 anys. Cal emplenar i portar signat el <a href="https://transequia.cat/wp-content/uploads/2022/02/AUTORITZACIO-DE-MENORS-2022.pdf" target="_blank">document d\'autorització</a> el dia de la Transéquia</label>
        </div>
    </div>';
}
else if($box['id']==548) // ROMÀNIC AL BAGES
{
    $dadesindividuals = '<div class="row uniform dades_linia">\
        <div class="3u">\
            <label class="formulari">Gènere</label>\
            <div class="select-wrapper">\
                <select class="camp_1 required">\
                    <option value="-1">-</option>\
                    <option value="1">Home</option>\
                    <option value="2">Dona</option>\
                    <option value="3">No binari</option>\
                </select>\
            </div>\
        </div>\
        <div class="6u">\
            <label class="formulari">Nom i Cognoms</label>\
            <input class="required camp_2" type="text"/>\
        </div>\
        <div class="3u$">\
            <label class="formulari">Telèfon</label>\
            <input class="required camp_3" type="text"/>\
        </div>\
        <div class="6u">\
            <label class="formulari">Email</label>\
            <input class="required camp_4" type="text" />\
        </div>\
        <div class="3u">\
            <label class="formulari">Municipi</label>\
            <input class="required camp_5" type="text"/>\
        </div>\
        <div class="3u$">\
            <label class="formulari">Edat</label>\
            <div class="select-wrapper">\
                <select class="camp_6 required">\
                    <option value="1">0-11 anys</option>\
                    <option value="2">12-17 anys</option>\
                    <option value="3">31-60 anys</option>\
                    <option value="4">+60 anys</option>\
                </select>\
            </div>\
        </div>\
    </div>';
}

?>

<script type="text/javascript">

    $(document).ready(function()
    {   
        $('.quant_input').change(function(){    
            
            <?php
            // Script pel cas de tarifes excloents
            if($price_type==1)
            {?>
            $('.quant_input').not(this).val("0");
            <?php
            }?>
            
            Recalcular();
            RegenerarCamps(); 
        });

        if($("#check_special").length) {
            $('#check_special').click(function(){ 
                Recalcular();
            });
        }
    
        $('.mod_list').show();
        Recalcular();
    });
    
    function Recalcular()
    {
        var total = 0;
        var total_elements = 0;
        var html = "";
        var quant_str = "";
        var no_solidari = false;

        if($("#check_special").length) {
            no_solidari = $('#check_special').is(":checked")?false:true;
        }
    
        $('.mod_list').each(function(){

            var n_elements=0;
            if(jQuery.isNumeric($(this).find('select').val()))
            {
                n_elements = parseInt($(this).find('select').val());
            }
            var subtotal = n_elements*parseFloat($(this).find('.price').html())

            total += subtotal;
            
            if(n_elements>0)
            {
                if(html!="")
                {
                    html += '</br>';
                }
                html = html + n_elements + ' x ' + $(this).find('.price_name').html();
            }
            
            quant_str += n_elements;
            total_elements += n_elements;
            quant_str += ";";
        });

        if(no_solidari){
            total-=total_elements;
            if(total < 0) total=0;
        }

        $('#preu-total').html(total.toFixed(2)  + '€');
        
        $("#tria_2").html("<?php echo $subtitle; ?>" + '</br>' + html + '</br><strong>' + total.toFixed(2)  + '€</strong>' ); 
        
        $('#quant').val(quant_str);
        
        
    }

    function RegenerarCamps()
    {
        if($("#dades_inscrits").length) {
            $('#dades_inscrits').empty();
        }
        $('.mod_list').each(function(){
            var n_elements=0;
            if(jQuery.isNumeric($(this).find('select').val()))
            {
                n_elements = parseInt($(this).find('select').val());
            }
            
            if(n_elements>0)
            {
                if($("#dades_inscrits").length) {
                    for(var i=0;i<n_elements;i++)
                    {
                        $('#dades_inscrits').append('<?php echo $dadesindividuals;?>');
                    }
                }
            }
        });   
    }

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
            <h2><?php echo translate("Tria els tiquets", $lang); ?></h2>
        </header>
        <h3><?php echo $subtitle; ?></h3>
        <section>
        <div class="table-wrapper">
            <table style="text-align:left">
                <thead>
                    <tr>
                        <?php
                        if($price_type==1)
                        {?>
                        <th><?php echo translate("Opció - tarifes excloents", $lang); ?></th>
                        <?php
                        }
                        else
                        {?>
                        <th><?php echo translate("Opció", $lang); ?></th>
                        <?php
                        }
                        ?>
                        <th><?php echo translate("Preu", $lang); ?></th>
                        <th><?php echo translate("Unitats", $lang); ?></th>
                    </tr>
                </thead>
                <tbody>
        <?php
        for($i=0;$i<count($price_modalities);$i++)
        {
            $price = $price_modalities[$i];
        ?>        
            <tr class="mod_list" mid='<?php echo $i; ?>'>
                <td class="6u price_name"><?php echo $price['name']; ?></td>
                <td class="2u price"><?php echo $price['price'] . '€'; ?></td>
                <td class="4u">
                    <div class="select-wrapper">
                        <select class="quant_input" autocomplete="off">                            
                            <?php
                            $min_val = 1;
                            if($box['etype']==0)
                            {
                                $max_val_sessio = $session['places']-$ocupacio>0 ? $session['places']-$ocupacio : 0;
                                if($price['stock']>0) {
                                    //$max_val_tiquet = $price['stock']-$ocupacio>0 ? $price['stock']-$ocupacio : 0;
                                    $max_val_tiquet = $price['stock']-$ocupacio_modality[$i]>0 ? $price['stock']-$ocupacio_modality[$i]: 0;
                                    
                                }
                                else $max_val_tiquet = 100;
                                $max_val = min($max_val_sessio,$max_val_tiquet);
                            }
                            else if($box['etype']==6)
                            {
                                $max_val = $price['stock'];
                            }
                            else
                            {
                                $max_val = $price['stock'] - $ocupacio_modality[$i];
                            }
            
                            // Hi poso un control per evitar que hi hagi massa elements i trigui a carregar
                            // MAX = 100
                            if($max_val>100) $max_val=100;
            
                            // Control de màxim nombre de tiquets per compra
                            if($price['max']>0)
                            {
                                $max_val = min($max_val,$price['max']);
                            }
            
                            if($max_val>0)
                            {
                            ?>
                            <option value="0">-</option>
                            <?php
                            }
                            else
                            {
                            ?>
                            <option value="0">ESGOTATS</option>
                            <?php
                            }
            
                            for($val=$min_val;$val<=$max_val;$val++)
                            {?>
                            <option value="<?php echo $val; ?>"><?php echo $val; ?></option>
                            <?php
                            }?>
                        </select>
                    </div>
                </td>
            </tr>        
        <?php
        }

        if($box['id']==502 || $box['id']==510 || $box['id']==511)
        {?>
            <tr class="" mid='-1'>
                <td class="12u" colspan="3">
                    <div class="12u$(xsmall)">
                        <input type="checkbox" name="check_special" id="check_special" checked/>
                        <label for="check_special">Donació d'1€ solidari per participant al projecte d'inserció laboral d'AMPANS</label>
                    </div>
                </td>
            </tr>
        <?php
        }?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2">TOTAL</td>
                        <td><h3 id="preu-total" style="text-align:center">0€</h3></td>
                    </tr>
                </tfoot>
            </table>
        </div> 
        </section>
    </div>
    <a href="#two" class="goto-next scrolly">Next</a>
</div>
<?php
// ESDEVENIMENT MÚLTIPLE
// PAS 2
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
            
            // Miro la suma de tiquets seleccionats
            var tiquets = 0;
            var max_places = -1;
            $('.quant_input').each(function(){
                tiquets += parseInt($(this).val());
                if($(this).attr("data-max")>max_places) max_places = $(this).attr("data-max");
            });
            
            if(max_places==-1)
            {
                max_places = 999;
            }
            
            if(tiquets > Math.min($('#eventsession input:checked').attr('places'),max_places))
            {
                alert("Compte, heu seleccionat un nombre de tiquets més gran que el màxim permès\nCom a màxim podeu escollir " + Math.min($('#eventsession input:checked').attr('places'),max_places) + " tiquets");
                $(this).val(0);
            }
            else
            {
                Recalcular(); 
            }
        });

        $('#aplicar_codi').click(function(){
            if($("#codi_descompte").val()!="") {
                $.ajax({  
                    type: "POST",  
                    url: "<?php echo $rootfolder; ?>" + "php/server_actions.php",  
                    data: {
                        op:"check_descompte",
                        id:$('#cd_id').val(),
                        codi:$("#codi_descompte").val()
                    },             
                    dataType: 'json'
                }).always(function(res)
                {
                    var descompte = 0;
                    var tdescompte = -1;
                    if(res!=null) {                        
                        descompte = parseFloat(res.descompte);
                        tdescompte = parseInt(res.type);
                        if(tdescompte==-1) {
                            $('#cd_missatge').html('Descompte no vàlid');
                            Recalcular();
                        }
                        else {
                            $('#cd_missatge').html('Descompte vàlid');
                            Recalcular(descompte,tdescompte);
                        }
                    }
                    else {
                        $('#cd_missatge').html('No s\'ha trobat el descompte');
                        Recalcular();   
                    }
                }); 
            }            
        });
        
        $('.mod_list').hide();
        
    });
    
    function Recalcular(descompte=0,tdescompte=-1)
    {
        var total = 0;
        var html = "";
        var quant_str = "";
        

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
            quant_str += ";";
        });

        if(tdescompte==0){
            if(total-descompte > 0) total-=descompte;
            else total=0;
        }
        if(tdescompte==1){
            total=total*(1-descompte/100);
        }

        $('#preu-total').html(total.toFixed(2)  + '€');
        
        $("#tria_2").html($('#eventsession input:checked').attr('data') + '</br>' + html + '</br><strong>' + total.toFixed(2)  + '€</strong>' ); 
        
        $('#quant').val(quant_str);
    }

</script>

<div class="container">
    <?php
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . $rootfolder . "boxes/box_" . $event . "/box_image_2.jpg"))
    {?>
    <span class="image fit primary"><img src="<?php echo $rootfolder . "boxes/box_" . $event . "/box_image_2.jpg"; ?>" alt="" /></span>
    <?php
    }?>
    
    <div class="content">
        <header class="major">
            <h2><?php echo translate("Tria els tiquets", $lang); ?></h2>
        </header>
        <h3 id="tria_1"></h3>
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
            $quant = 0;
//            if($quant_modalities[$i]!=undefined && $quant_modalities[$i]!=null)
//            {
//                $quant = intval($quant_modalities[$i]);
//            }
//            else
//            {
//                $quant = 0;
//            }
        ?>        
            <tr class="mod_list" mid='<?php echo $i; ?>'>
                <td class="7u price_name"><?php echo $price['name']; ?></td>
                <td class="2u price"><?php echo $price['price'] . '€'; ?></td>
                <td class="3u">
                    <div class="select-wrapper">
                        <select class="quant_input" data-max='<?php echo $price["max"]; ?>'>
                            <option value="0" <?php if($quant==0) echo "selected"; ?>>-</option>                            
                        </select>
                    </div>
                </td>
            </tr>        
        <?php
        }

        if($box['codi_descompte']>0) {?>
            <tr class="" mid='-1'>
                <td class="9u" colspan="2">
                    <div class="12u$(xsmall)">Tens un codi de descompte? <a style="cursor:pointer" id="aplicar_codi">Aplicar</a><br>
                    <div class="cd_notificacio" id="cd_missatge"></div>
                </div>
                </td>
                <td class="3u">
                    <div class="12u$(xsmall)">
                        <input type="text" name="codi_descompte" id="codi_descompte"/>
                    </div>
                </td>
            </tr>
        <?php
        }

        ?>
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
    <a href="#three" class="goto-next scrolly">Next</a>
</div>
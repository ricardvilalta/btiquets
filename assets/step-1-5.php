<?php    
?>

<script type="text/javascript">

    $(document).ready(function()
    {           
        $('.sense_items').click(function(){
            
            min = $(this).parent().find(".val_unitats").attr("min");
            max = $(this).parent().find(".val_unitats").attr("max");
            id = $(this).parent().attr("pid");
            sid = $(this).parent().attr("pkid");
            preu = $(this).parent().attr("preu");
            stock = parseInt($(this).parent().attr("pstock"))
            //unitats = parseInt($(this).parent().find(".val_unitats").val());
            unitats = 1;
            
            if(stock>0)
            {
                CanviarValor($(this).parent(),unitats);
            }
            
        });
        
        $('.menys').click(function(){
            
            min = $(this).parent().parent().find(".val_unitats").attr("min");
            max = $(this).parent().parent().find(".val_unitats").attr("max");
            id = $(this).parent().parent().attr("pid");
            sid = $(this).parent().parent().attr("pkid");
            preu = $(this).parent().parent().attr("preu");
            stock = parseInt($(this).parent().parent().attr("pstock"))
            unitats = -1;                        
            
            if(stock>0)
            {
                CanviarValor($(this).parent().parent(),unitats);
            }
            
        });
        
        $('.mes').click(function(){
            
            min = $(this).parent().parent().find(".val_unitats").attr("min");
            max = $(this).parent().parent().find(".val_unitats").attr("max");
            id = $(this).parent().parent().attr("pid");
            sid = $(this).parent().parent().attr("pkid");
            preu = $(this).parent().parent().attr("preu");
            stock = parseInt($(this).parent().parent().attr("pstock"))
            unitats = 1;                        
            
            if(stock>0)
            {
                CanviarValor($(this).parent().parent(),unitats);
            }
            
        });
        
        function CanviarValor(element,quantitat)
        {
            // actualitzo l'estoc
            newstock = parseInt($(element).attr("pstock"))-quantitat;
            $(element).attr("pstock",newstock);            

            // Actualitzar valors del producte            
            actual = parseInt($(element).find(".item_carret").val());
            actual += unitats;
            $(element).find(".item_carret").val(actual);

            // si ja hi ha algun element del producte, canviar el control, si no, tornar al valor inicial
            if(actual>0)
            {                
                $(element).find('.sense_items').hide();
                $(element).find('.items_comptador').show();
            }
            else
            {
                $(element).find('.items_comptador').hide();
                $(element).find('.sense_items').show();
            }

            // Afegir al carret i recalcular
            ActualitzarCarret();
        }
        
        function ActualitzarCarret()
        {
            // Actualitzar subtotal del carret
            $("#carret").empty();
            line_1 = '<div class="table-wrapper"><table class="special style1" style="text-align:left"><thead><tr><th>'+'<?php echo translate("Producte", $lang); ?>'+'</th><th>'+'<?php echo translate("Preu", $lang); ?>'+'</th><th>'+'<?php echo translate("Quantitat", $lang); ?>'+'</th><th>'+'<?php echo translate("Import", $lang); ?>'+'</th></tr></thead><tbody>';
            line_2 = "";
            subtotal = 0;
            total = 0;
            n_elements=0;
            res_str = "";
            $('.afegir_item').each(function()
            {   
                if(parseInt($(this).find(".item_carret").val())>0)
                {
                    subtotal = parseFloat($(this).attr("pval")) * parseInt($(this).find(".item_carret").val());
                    total += subtotal;
                    n_elements += parseInt($(this).find(".item_carret").val());
                    line_aux = '<tr class="mod_list"><td class="8u price_name">' + $(this).attr("pname") + " - " + $(this).attr("psname") + '</td><td class="2u price">' + $(this).attr("pval") + '€' + '</td><td class="2u price">' + $(this).find(".item_carret").val() + '</td><td class="2u price">' + subtotal.toFixed(2) + '€' + '</td></tr>';
                    line_2 += line_aux;
                }
                
                str_aux = $(this).attr("pid") + ':' + $(this).attr("pkid") + ':' + $(this).find(".item_carret").val() + ';';
                res_str += str_aux;
            });
            
            line_3 = '</tbody></table></div>';
            
//            line_3 = '</tbody><tfoot><tr><td colspan="3">SUBTOTAL</td><td><h3 id="preu-total" style="text-align:center">' + total.toFixed(2) + '€' + '</h3></td></tr><tr><td colspan="2"></td><td colspan="2" style="text-align:right"><a id="clear_carret" class="button small">Buidar cistella</a></td></tr></tfoot></table></div>';
            
            $("#carret").append(line_1+line_2+line_3);
            $("#preu-subtotal").html(total.toFixed(2) + '€');
            $('#res_data').val(res_str);
            
            // Calcular el total
            CalcularTotal(total);
            
            // Mostrar missatge
            Notificacio(n_elements);
            
            $('#clear_carret').off('click');
            $('#clear_carret').click(function(){
            
                $('.afegir_item').each(function()
                { 
                    stockini = $(this).attr("pstockini");
                    $(this).attr("pstock",stockini);
                    $(this).find(".item_carret").val(0);
                    $(this).find('.items_comptador').hide();
                    $(this).find('.sense_items').show();

                    ActualitzarCarret();
                });
            });

            $('#clear_carret_line').off('click');
            $('.clear_carret_line').click(function(){

                $('.afegir_item[pid='+$(this).attr('pid')+'][pkid='+$(this).attr('pkid')+']').each(function()
                { 
                    stockini = $(this).attr("pstockini");
                    $(this).attr("pstock",stockini);
                    $(this).find(".item_carret").val(0);
                    $(this).find('.items_comptador').hide();
                    $(this).find('.sense_items').show();

                    ActualitzarCarret();
                });
            });                            
            
            // Mostra botó de continuar al carret
            if(total>0)
            {
                $("#calnext").show();
            }
            else
            {
                $("#calnext").hide();
            }
        }
        
        function Notificacio(n_elements)
        {
            $('#notificacions').html(n_elements + " productes a la cistella");
            if(n_elements>0)
            {
                $('#alacistella').css('display','block');
            }
            else
            {
                $('#alacistella').css('display','none');
            }
//            $('#notificacions').fadeIn('fast', function(){
//               $('#notificacions').delay(2000).fadeOut(); 
//            });
        }
        
        function CalcularTotal(subtotal)
        {
            total = subtotal + parseFloat($('#env-value').val());   
            $('#preu-total').html(total.toFixed(2)+'€');
        }
        
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
<!--    <a href="#header" class="goto-prev scrolly">Prev</a>-->
    <div class="content">
        <div class="noti-container">
            <a href="#two" id="alacistella" class="button main special fit small">Vés a la cistella</a>
            <a id="notificacions" class="button main special fit small">0 productes a la cistella</a>            
        </div>
        <header class="major">
            <h2><?php echo translate("Productes", $lang); ?></h2>
        </header>
        <h3><?php echo $subtitle; ?></h3>
        <section>

        <div class="row">
        <?php
        foreach($producte_list as $producte)
        {?>
            <div class="producte">
                <div class="12u pr_dades">
                    <h4><?php echo $producte['name']; ?></h4>
                </div>
                <div class="8u pr_image">
                    <img src="<?php echo $rootfolder . "productes/p_" . $producte['id'] . "/p_image_0.jpg"; ?>">
                </div>                    
                <div class="12u pr_preu">
                    <ul class="alt">
                        <li></li>
                        <?php
                        foreach($producte['modalitat'] as $prod_item)
                        {?>                    
                        <li class="item_line">
                            <div class="row">
                                <div class="12u">
                                    <h4><?php echo $prod_item['nom']; ?></h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="4u">
                                    <p><?php echo $prod_item['preu'] . '€'; ?></p>
                                </div>
                                <div class="8u pricer afegir_item" pname="<?php echo $producte['name']; ?>" psname="<?php echo $prod_item['nom']; ?>" pid="<?php echo $producte['id']; ?>" pKid="<?php echo $prod_item['id']; ?>" pval="<?php echo str_replace(',','.',$prod_item['preu']); ?>" pstock="<?php echo $prod_item['stock']; ?>" pstockini="<?php echo $prod_item['stock']; ?>">
                                    <div class="items_comptador">
                                        <a class="mes button special small">+</a>
                                        <div class="counter">
                                            <input type="" disabled class="item_carret" value="0">
                                        </div>
                                        <a class="menys button special small">-</a>
                                    </div>
                                    <a class="sense_items button special small">Afegir al carret</a>                                                                      
<!--
                                    <div class="counter">
                                        <input type="number" class="val_unitats" value="1" min="1" max="<?php echo $prod_item['stock']; ?>">
                                    </div>                                    
-->
                                </div> 
                            </div>
                        </li>
                        <?php
                        }?>
                    </ul>
                </div>
                <div class="12u pr_dades">
                    <h5><?php echo translate("Descripció", $lang); ?></h5>
                    <p><?php echo $producte['desc']; ?></p>
                </div>
            </div>
        <?php
        }?>
        </div>
        </section>
    </div>
<!--    <a href="#two" class="goto-next scrolly">Next</a>-->
</div>
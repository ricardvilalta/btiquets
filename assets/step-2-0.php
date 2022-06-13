<script type="text/javascript">

    $(document).ready(function()
    {
        $('#action-1').click(function(){
            
            Recalcular();       
            var bval;

            // if($("#dades_inscrits").length) {
            //     bval = pre_validation2('required','missing');
            // }
            // else{
            //     bval = pre_validation(['name','email','tel'<?php if($box['com_obl']) echo ",'comment'"; ?>],'missing')
            // }
            bval = pre_validation2('required','missing');

            if(bval)
            {
                var ntiquets=0;
                $('.mod_list').each(function()
                {
                    if(jQuery.isNumeric($(this).find('select').val()))
                    {
                        ntiquets += parseInt($(this).find('select').val());
                    }                    
                });
                
                var dades_str = "";
                $('.dades_linia').each(function(){
                    // Actualitzat pel ROMÀNIC AL BAGES
                    dades_str+=$(this).find('.camp_1').val();
                    dades_str+='::';
                    dades_str+=$(this).find('.camp_2').val();
                    dades_str+='::';
                    dades_str+=$(this).find('.camp_3').val();
                    dades_str+='::';
                    dades_str+=$(this).find('.camp_4').val();
                    dades_str+='::';
                    dades_str+=$(this).find('.camp_5').val();
                    dades_str+='::';
                    dades_str+=$(this).find('.camp_6').val();
                    // dades_str+='::';
                    // dades_str+=($(this).find('.camp_4').is(":checked")?1:0);
                    dades_str+=';;';
                });

                var b_check_1=b_check_2=b_check_3=b_check_special=0;
                var b_check_special=1;
                var val_genere = -1;
                if ($("#check_1").length){
                    b_check_1 = $('#check_1').is(":checked")?1:0;
                }
                if ($("#check_2").length){
                    b_check_2 = $('#check_2').is(":checked")?1:0;
                }
                if ($("#check_3").length){
                    b_check_3 = $('#check_3').is(":checked")?1:0;
                }
                if ($("#check_special").length){
                    b_check_special = $('#check_special').is(":checked")?1:0;
                }
                if ($("#genere").length){
                    val_genere = $('#genere').val();
                }

                if(ntiquets>0)
                {
                    if($('#lopd').is(":checked"))
                    {
                        if($('#xaccept').is(":checked") || $('#xaccept').is(":hidden") )
                        {
                            $.ajax({  
                                type: "POST",  
                                url: "<?php echo $rootfolder; ?>" + "php/insert_reservation_1.php",
                                data: {
                                    box_id: $('#box_id').val(),
                                    data_res: $('#data_res').val(),
                                    quant_str: $('#quant').val(),
                                    nom: $('#name').val(),
                                    email: $('#email').val(),
                                    city: $('#city').val(),
                                    tel: $('#tel').val(),
                                    com: $('#comment').val(),
                                    dades: dades_str,
                                    newsletter: $('#newsletter').is(":checked")?1:0,
                                    lang: '<?php echo $lang; ?>',
                                    genere: val_genere,
                                    check_1: b_check_1,
                                    check_2: b_check_2,
                                    check_3: b_check_3,
                                    check_special: b_check_special
                                }
                            }).done(function(ret)
                            {                    
                                msg = ret.split('/')[0];
                                if(msg=="registration-ok")
                                {
                                    location.href = "<?php echo $server; ?>"+'process-ok/'+"<?php echo $box['url']; ?>"+'/'+ret.split('/')[1];
                                }
                                else if(ret!=-1 && ret!=-2)
                                {                        
                                    $('#final').html(ret);

                                    $('#pagar').click(function(){                            
                                        $.ajax({  
                                            type: "POST",  
                                            url: "<?php echo $rootfolder; ?>" + "/php/server_actions.php",  
                                            data: $('#tpv').serialize(),                
                                            dataType: 'json'
                                        }).always(function()
                                        {            
                                            //$('#pagantis').submit();
                                            $('#tpv').submit();
                                        });            
                                    });
                                    
                                    $('#pagar_bizum').click(function(){                            
                                        $.ajax({  
                                            type: "POST",  
                                            url: "<?php echo $rootfolder; ?>" + "/php/server_actions.php",  
                                            data: $('#tpv_bizum').serialize(),                
                                            dataType: 'json'
                                        }).always(function()
                                        {            
                                            //$('#pagantis').submit();
                                            $('#tpv_bizum').submit();
                                        });            
                                    });

                                    location.href = "#final";
                                }
                                else
                                {
                                    if(ret==-2)
                                    {
                                        if(confirm('<?php echo translate("Ja no queden les places sol·licitades. Sisplau, accepta per actualitzar la pàgina", $lang); ?>'))
                                        {
                                            location.reload(); 
                                        }
                                    }
                                    //alert(ret);
                                }
                            });
                        }
                        else
                        {
                            alert('<?php echo translate("Sisplau, llegeix i accepta la política específica del producte", $lang); ?>');
                        }
                    }
                    else
                    {
                        alert('<?php echo translate("Sisplau, llegeix i accepta la política de privacitat", $lang); ?>');
                    }
                }
                else
                {
                    alert('<?php echo translate("Selecciona com a mínim un tiquet", $lang); ?>');
                }
            }
            else
            {
                alert('<?php echo translate("Falta alguna de les dades necessàries", $lang); ?>');
            }
        });                

        <?php
        if($box['id']==502 || $box['id']==510 || $box['id']==511 || $box['id']==548) // TRANSÈQUIA 2022 / ROMÀNIC AL BAGES
        {?>
            $('#name').change(function(){
                if($("#name").length) {
                    $(".dades_linia").first().find('.camp_2').val($(this).val());
                }
            });
        <?php
        }?>
    });

</script>


<div class="container">    
    <?php
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . $rootfolder . "boxes/box_" . $event . "/box_image_2.jpg"))
    {?>
    <span class="image fit primary"><img src="<?php echo $rootfolder . "boxes/box_" . $event . "/box_image_2.jpg"; ?>" alt="" /></span>
    <?php
    }?>
    
    <a href="#one" class="goto-prev scrolly">Prev</a>
    <div class="content">
        <header class="major">
            <h2><?php echo translate("Entra les teves dades", $lang); ?></h2>
        </header>
        <h3 id="tria_2"></h3>
        <div>
            <div class="row uniform">
                <input type=hidden id="box_id" value="<?php echo $event; ?>"/>
                <input type=hidden id="data_res" value="<?php echo $box["sessio_unica"]; ?>"/>                
                <input type=hidden id="quant" value=""/>
                <div class="3u">
                    <label class="formulari">Gènere</label>
                    <div class="select-wrapper">
                        <select class="" name="genere" id="genere">
                            <option value="-1">-</option>
                            <option value="1">Home</option>
                            <option value="2">Dona</option>
                            <option value="3">No binari</option>
                        </select>
                    </div>
                </div>
                <div class="9u$">
                    <label class="formulari"><?php echo translate("Nom i Cognoms", $lang); ?></label>
                    <input class="required" type="text" name="name" id="name" />
                </div>
                <div class="12u$">
                    <label class="formulari"><?php echo translate("Email", $lang); ?></label>
                    <input class="required" type="email" name="email" id="email"/>
                </div>
                <div class="6u 12u$(xsmall)">
                    <label class="formulari"><?php echo translate("Municipi", $lang); ?></label>
                    <input type="text" name="city" id="city"/>
                </div>
                <div class="6u$ 12u$(xsmall)">
                    <label class="formulari"><?php echo translate("Telèfon", $lang); ?></label>
                    <input class="required" type="text" name="tel" id="tel"/>
                </div>
                <div class="12u$">
                    <label class="formulari"><?php if($box['com_aux']!="") echo $box['com_aux']; else echo translate("Comentaris", $lang); ?></label>
                    <textarea class="<?php if($box['com_obl']) echo 'required'; ?>" name="comment" id="comment"></textarea>
                </div>

                <?php
                if($box['id']==502 || $box['id']==510 || $box['id']==511 || $box['id']==207) // TRANSÈQUIA 2022
                {?>
                <div class="12u$(xsmall)">
                    <input type="checkbox" name="check_1" id="check_1"/>
                    <label for="check_1">AUTOCAR: Vull agafar un autocar de Transèquia a l'estació d'autobusos de Manresa per arribar al punt d'inici i començar el recorregut (caldrà ser a l'estació d'autobusos 30 minuts abans de l'hora d'inici seleccionada) *</label>
                </div>
                <div class="12u$(xsmall)">
                    <input type="checkbox" name="check_2" id="check_2"/>
                    <label for="check_2">CORRENT: Vull fer la Transéquia corrent i recollir la bossa del participant al final del recorregut *</label>
                </div>
                <div class="12u$(xsmall)">
                    <input type="checkbox" name="check_3" id="check_3"/>
                    <label for="check_3">CELIAQUIA: Vull una bossa del participant amb aliments sense gluten *</label>
                </div>
                <label class="formulari">*Si no s'aplica a tots els participants de la reserva, indiqueu-ho als comentaris</label>
                <label class="formulari">Cal emplenar les dades de cadascun dels participants</label>
                <div id="dades_inscrits"></div>
                <?php
                }?>

                <?php
                if($box['id']==548) // ROMÀNIC AL BAGES
                {?>
                <label class="formulari">Cal emplenar les dades de cadascun dels participants</label>
                <div id="dades_inscrits"></div>
                <?php
                }?>

                <?php include('assets/checks.php'); ?>
                                
                <div class="12u$">
                    <ul class="actions">
                        <li><a id="action-1" class="button special icon fa-check-square-o "><?php echo translate("Confirmar", $lang); ?></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>    
</div>
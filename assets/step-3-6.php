<script type="text/javascript">

    $(document).ready(function()
    {
        $('#action-1').click(function(){
            
            Recalcular();       
            var bval = pre_validation2('required','missing');
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
                                    check_special: b_check_special,
                                    codi_descompte: $('#codi_descompte').val()
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
                                    else {
                                        if(confirm('<?php echo translate("Hi ha hagut un error en la creació de la reserva. Sisplau, accepta per actualitzar la pàgina", $lang); ?>'))
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
    });

</script>


<div class="container">    
    <?php
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . $rootfolder . "boxes/box_" . $event . "/box_image_2.jpg"))
    {?>
    <span class="image fit primary"><img src="<?php echo $rootfolder . "boxes/box_" . $event . "/box_image_2.jpg"; ?>" alt="" /></span>
    <?php
    }?>
    
    <a href="#two" class="goto-prev scrolly">Prev</a>
    <?php include "registre.php";?>
</div>
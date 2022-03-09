<script type="text/javascript">

    $(document).ready(function()
    {
        $('#action-1').click(function(){
            
            Recalcular();
            if(pre_validation(['name','email','tel'<?php if($box['com_obl']) echo ",'comment'"; ?>],'missing'))
            {
                var ntiquets=0;
                $('.mod_list').each(function()
                {
                    if(jQuery.isNumeric($(this).find('select').val()))
                    {
                        ntiquets += parseInt($(this).find('select').val());
                    }                    
                });
                
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
                                    newsletter: $('#newsletter').is(":checked")?1:0,
                                    lang: '<?php echo $lang; ?>'
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
                <div class="12u$">
                    <label class="formulari"><?php echo translate("Nom", $lang); ?></label>
                    <input type="text" name="name" id="name" />
                </div>
                <div class="12u$">
                    <label class="formulari"><?php echo translate("Email", $lang); ?></label>
                    <input type="email" name="email" id="email"/>
                </div>
                <div class="6u 12u$(xsmall)">
                    <label class="formulari"><?php echo translate("Municipi", $lang); ?></label>
                    <input type="text" name="city" id="city"/>
                </div>
                <div class="6u$ 12u$(xsmall)">
                    <label class="formulari"><?php echo translate("Telèfon", $lang); ?></label>
                    <input type="text" name="tel" id="tel"/>
                </div>
                <div class="12u$">
                    <label><?php if($box['com_aux']!="") echo $box['com_aux']; else echo translate("Comentaris", $lang); ?></label>
                    <textarea name="comment" id="comment"></textarea>
                </div>
                
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
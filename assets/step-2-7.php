<script type="text/javascript">

    $(document).ready(function()
    {
        $('#action-1').click(function(){
            
            Recalcular();
            if(pre_validation(['name','email','tel'<?php if($box['com_obl']) echo ",'comment'"; ?>],'missing'))
            {
                var valor = parseFloat($('#quant').val());

                if(valor>=1 && valor<10000)
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
                    alert('<?php echo translate("El valor de l\'aportació ha de ser d\'entre 1€ i 10.000€", $lang); ?>');
                }
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
                <input type=hidden id="data_res" value="-1"/>                
                <input type=hidden id="quant" value=""/>
                <div class="12u$"><input type="text" name="name" id="name" placeholder="<?php echo translate("Nom", $lang); ?>" /></div>
                <div class="12u$"><input type="email" name="email" id="email" placeholder="<?php echo translate("Email", $lang); ?>" /></div>
                <div class="6u 12u$(xsmall)"><input type="text" name="city" id="city" placeholder="<?php echo translate("Municipi", $lang); ?>" /></div>
                <div class="6u$ 12u$(xsmall)"><input type="text" name="tel" id="tel" placeholder="<?php echo translate("Telèfon", $lang); ?>" /></div>
                <div class="12u$"><textarea name="comment" id="comment" placeholder="<?php if($box['com_aux']!="") echo $box['com_aux']; else echo translate("Comentaris", $lang); ?>"></textarea></div>
                
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
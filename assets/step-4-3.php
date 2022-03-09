<script type="text/javascript">

    $(document).ready(function()
    {
        $('#action-1').click(function(){
            
            var data_res;
            var tot_ok = false;
            if(pre_validation(['name','email','tel' <?php if($box['com_obl']) echo ",'comment'"; ?>],'missing'))
            {                
                if($("#idata_res").val()==-999 && $("#odata_res").val()==-999)
                {
                    // Data obert
                    data_res = -999;
                    tot_ok = true;
                }
                else if($("#idata_res").val()!="" && $("#odata_res").val()!="")
                {
                    // Comprovo si la selecció de dates és correcte
                    idata = $("#idata_res").val().split('/');
                    var i_d = new Date(idata[2],idata[1],idata[0]);
                    odata = $("#idata_res").val().split('/');
                    var o_d = new Date(odata[2],odata[1],odata[0]);
                    if(i_d>o_d)
                    {
                        alert('<?php echo translate("La data d\'entrada no pot ser posterior a la data de sortida", $lang); ?>');
                    }
                    else
                    {
                        data_res = $("#idata_res").val() + ":" + $("#odata_res").val();
                        tot_ok = true;
                    }
                }
                else
                {
                    alert('<?php echo translate("Falta definir alguna de les dates de la reserva", $lang); ?>');
                }
                
                if(tot_ok)
                {
                    if($('#lopd').is(":checked"))
                    {
                        $.ajax({  
                            type: "POST",  
                            url: "<?php echo $rootfolder; ?>" + "php/insert_reservation_3.php",
                            data: {
                                box_id: $('#box_id').val(),
                                data_res: data_res,
                                quant_str: $('#room').val(),
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
                                location.href = "<?php echo $urlOK; ?>" + "/" + ret.split('/')[1];                                
                            }
                            else if(ret!=-1)
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
                                        //$('#pagantis').submit();
                                        $('#tpv_bizum').submit();
                                    });            
                                });


                                location.href = "#final";
                            }
                            else
                            {
                                //alert(ret);
                            }
                        });
                    }
                    else
                    {
                        alert('<?php echo translate("Sisplau, llegeix i accepta la política de privacitat", $lang); ?>');
                    }
                }
                else
                {
                    alert('<?php echo translate("Error en la selecció de dates", $lang); ?>');
                }
            }
        });

    });

</script>


<div class="container">
    <?php
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . $rootfolder . "boxes/box_" . $event . "/box_image_3.jpg"))
    {?>
    <span class="image fit primary"><img src="<?php echo $rootfolder . "boxes/box_" . $event . "/box_image_3.jpg"; ?>" alt="" /></span>
    <?php
    }?>
    
    <a href="#one" class="goto-prev scrolly">Prev</a>
    <div class="content">
        <header class="major">
            <h2><?php echo translate("Entra les teves dades", $lang); ?></h2>
        </header>
<!--        <h3 id="tria_2"></h3>-->
        <div class="row uniform">
            <div class="3u all_dades">
            </div>    
            <div style="text-align: center;" class="6u all_dades"> 
                <h5 id="field3"></h5>
                <h5 id="field4"></h5>
                <h5 id="field5"></h5>
                <h5 class="cal_info"><?php echo translate("ENTRADA", $lang); ?>: <span id="startdate"></span></h5>
                <h5 class="cal_info"><?php echo translate("SORTIDA", $lang); ?>: <span id="enddate"></span></h5>
                <h5 class="cal_info2"><?php echo translate("Data oberta", $lang); ?></h5>
            </div>
            <div class="3u all_dades">                
            </div>
        </div>
        <div>
            <div class="row uniform">
                <input type=hidden id="box_id" value="<?php echo $event; ?>"/>
                <input type=hidden id="idata_res" value=""/>
                <input type=hidden id="odata_res" value=""/>
                <input type=hidden id="preu_unit" value="0"/>
                <input type=hidden id="hname" value=""/>
                <input type=hidden id="rname" value=""/>
                <input type=hidden id="room" value=""/>
                <input type=hidden id="room" value=""/>
                <div class="12u$"><input type="text" name="name" id="name" placeholder="<?php echo translate("Nom", $lang); ?>" /></div>
                <div class="12u$"><input type="email" name="email" id="email" placeholder="<?php echo translate("Email", $lang); ?>" /></div>
                <div class="6u 12u$(xsmall)"><input type="text" name="city" id="city" placeholder="<?php echo translate("Municipi", $lang); ?>" /></div>
                <div class="6u$ 12u$(xsmall)"><input type="text" name="tel" id="tel" placeholder="<?php echo translate("Telèfon", $lang); ?>" /></div>
                <div class="12u$"><textarea name="comment" id="comment" placeholder="<?php if($box['com_aux']!="") echo $box['com_aux']; else echo translate("Comentaris", $lang); ?>"></textarea></div>
                
                <?php include('assets/checks.php'); ?>
                
                <div class="12u$">
                    <ul class="actions">
                        <li><a id="action-1" class="button special icon fa-hand-pointer-o"><?php echo translate("Confirmar", $lang); ?></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
<!--    <a href="#footer" class="goto-next scrolly">Next</a>-->
</div>
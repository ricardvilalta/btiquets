<script type="text/javascript">

    $(document).ready(function()
    {
        $('#action-1').click(function(){
            
            var data_res;
            var tot_ok = false;
            
            if($('#email').val()==$('#email-2').val())
            {
                tot_ok = true;
            }
            
            if(pre_validation(['name','email','addr1','cp','city','tel' <?php if($box['com_obl']) echo ",'comment'"; ?>],'missing'))
            {                
                if(tot_ok)
                {
                    var comentari="";
                    <?php
                    if($enviament['type']==-2 && $enviament['list']!=null)
                    {?>                    
                    comentari += $('#comment').val()
                    if($('#enviaments').find('input:checked'))
                    {
                        comentari += "\n";
                        comentari += $('#enviaments input:checked').attr('data');
                    }
                    <?php
                    }
                    else
                    {?>
                    comentari += $('#comment').val()
                    <?php
                    }?>   
                    
                    if($('#lopd').is(":checked"))
                    {
                        $.ajax({  
                            type: "POST",  
                            url: "<?php echo $rootfolder; ?>" + "php/insert_reservation_4.php",
                            data: {
                                box_id: $('#box_id').val(),
                                quant_str: $('#res_data').val(),
                                nom: $('#name').val(),
                                email: $('#email').val(),
                                addr1: $('#addr1').val(),
                                addr2: "",
                                cp: $('#cp').val(),
                                city: $('#city').val(),
                                tel: $('#tel').val(),
                                com: comentari,
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
                    alert('<?php echo translate("comprova el correu electrònic", $lang); ?>');
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
    
<!--    <a href="#three" class="goto-prev scrolly">Prev</a>-->
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
                <input type=hidden id="res_data" value=""/>
                <div class="12u$"><input type="text" name="name" id="name" placeholder="<?php echo translate("Nom complet", $lang); ?>" /></div>
                <div class="12u$"><input type="email" name="email" id="email" placeholder="<?php echo translate("Correu electrònic", $lang); ?>" /></div>
                <div class="12u$"><input type="email" id="email-2" placeholder="<?php echo translate("Repeteix correu electrònic", $lang); ?>" /></div>
                <div class="12u"><input type="text" name="addr1" id="addr1" placeholder="<?php echo translate("Adreça", $lang); ?>" /></div>
                <div class="6u 12u$(xsmall)"><input type="text" name="city" id="city" placeholder="<?php echo translate("Municipi", $lang); ?>" /></div>
                <div class="6u 12u$(xsmall)"><input type="text" name="cp" id="cp" placeholder="<?php echo translate("Codi Postal", $lang); ?>" /></div>
                <div class="12u$"><input type="text" name="tel" id="tel" placeholder="<?php echo translate("Telèfon", $lang); ?>" /></div>
                <div class="12u$"><textarea name="comment" id="comment" placeholder="<?php if($box['com_aux']!="") echo $box['com_aux']; else echo translate("Comentaris", $lang); ?>"></textarea></div>
                
                <?php include('assets/checks.php'); ?>
                
                
                <?php
                if($box["pagament"]>0)
                {?>                    
                <div style="text-align: center;" class="12u"> 
                    <h2 class=""><?php echo translate("Pagament", $lang); ?></h2>
                </div>
                    <?php
                    if(($box["pagament"]&1)==1)
                    {?>
                <div class="12u$">
                    <input type="radio" id="pagament-1" name="pagament" <?php if($box["pagament"]==1 || $box["pagament"]==3) echo 'checked'?>>
                    <label for="pagament-1">TPV Virtual</label>
                </div>
                    <?php
                    }?>
                
                    <?php
                    if(($box["pagament"]&2)==2)
                    {?>
                <div class="12u$">
                    <input type="radio" id="pagament-2" name="pagament" <?php if($box["pagament"]==2) echo 'checked'?>>
                    <label for="pagament-2">Transferència</label>
                </div>
                    <?php
                    }
                }?>
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
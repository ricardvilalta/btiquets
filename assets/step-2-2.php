<script type="text/javascript">

    $(document).ready(function()
    {
        $('#action-2').click(function(){
            
            if(pre_validation(['name','email','tel'],'missing'))
            {
                if($('#lopd').is(":checked"))
                {
                    $.ajax({  
                        type: "POST",  
                        url: "<?php echo $rootfolder; ?>" + "php/insert_reservation_2.php",
                        data: {
                            box_id: $('#box_id').val(),
                            data_res: $('#data_res').val(),
                            quant_str: $('#quant').val(),
                            nom: $('#name').val(),
                            email: $('#email').val(),                    
                            tel: $('#tel').val(),
                            com: $('#comment').val(),
                            newsletter: $('#newsletter').is(":checked")?1:0,
                        }
                    }).done(function(ret)
                    {
                        if(ret!="")
                        {
                            location.href = "<?php echo $urlOK; ?>" + "/" + ret;
                            //alert(ret);
                        }
                        else
                        {
                            alert(ret);
                        }                    
                    });
                }
                else
                {
                    alert('<?php echo translate("Sisplau, llegeix i accepta la política de privacitat", $lang); ?>');
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
    
    <div class="content">
        <header class="major">
            <h2><?php echo translate("Entra les teves dades", $lang); ?></h2>
        </header>
        <h3 id="tria_1"></h3>
        <div>
            <div class="row uniform">
                <input type=hidden id="box_id" value="<?php echo $event; ?>"/>
                <input type=hidden id="data_res" value=""/>                
                <input type=hidden id="quant" value=""/>
                <div class="12u$"><input type="text" name="name" id="name" placeholder="<?php echo translate("Nom", $lang); ?>" /></div>
                <div class="12u$"><input type="email" name="email" id="email" placeholder="<?php echo translate("Email", $lang); ?>" /></div>                
                <div class="12u$"><input type="text" name="tel" id="tel" placeholder="<?php echo translate("Telèfon", $lang); ?>" /></div>
                <div class="12u$"><textarea name="comment" id="comment" placeholder="<?php echo translate("Comentaris", $lang); ?>"></textarea></div>
                
                <?php include('assets/checks.php'); ?>
                
                <div class="12u$">
                    <header>                        
                        <h6>Un cop feta la sol·licitud de reserva, el sistema us enviarà automàticament un correu informatiu de la comanda a l'adreça electrònica que heu proporcionat.</h6>
                        <h6>La reserva no es considera vàlida sense l'acceptació per part de l'establiment, que es farà a través d'un segon correu electrònic.</h6>
                        <h6>Si no rebeu la primera notificació, reviseu el correu brossa, o considereu la possibilitat d'haver escrit malament la vostra adreça.</h6>
                        <h6>Si no rebeu la confirmació de la reserva passades 2 hores, heu de considerar la reserva com a no atesa i, per tant, no vàlida.</h6>
                    </header>
                    <ul class="actions">
                        <li><a id="action-2" class="button special icon fa-hand-pointer-o">Reservar</a></li>
                    </ul>     
                    <h6>L'enviament de la sol·licitud implica l'acceptació d'aquestes condicions d'ús del sistema.</h6>
                </div>
            </div>
        </div>
    </div>    
</div>
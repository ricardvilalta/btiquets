<script type="text/javascript">

    $(document).ready(function()
    {
        
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
            <h2><?php echo translate("Entra les dades del beneficiari", $lang); ?></h2>
        </header>
        <div>
            <div class="row uniform">
                <div class="12u$">
                    <label class="formulari"><?php echo translate("Nom i Cognoms", $lang); ?></label>
                    <input class="required" type="text" name="xname" id="xname" />
                </div>
                <div class="12u$">
                    <label class="formulari"><?php echo translate("Telèfon", $lang); ?></label>
                    <input class="required" type="text" name="xtel" id="xtel" />
                </div>
                <div class="12u$">
                    <label class="formulari"><?php echo translate("Email (per si vols que rebi el xec regal per correu electrònic)", $lang); ?></label>
                    <input class="" type="email" name="xemail" id="xemail" />
                </div>
                <div class="12u$">
                    <label class="formulari"><?php echo translate("Dedicatòria", $lang); ?></label>
                    <textarea class="" name="dedicatoria" id="dedicatoria"></textarea>
                </div>
            </div>
        </div>
        <a href="#three" class="goto-next scrolly">Next</a>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function()
    {   
        $('#triadates').click(function(){
            $(".caltype_2").hide();
            $(".caltype_1").show();        
        });
        
        $('#regal').click(function(){
            $(".caltype_1").hide();
            $(".caltype_2").show();
            $(".cal_info2").show();
            $(".cal_info").hide();
            $("#idate").val("");
            $("#odate").val("");
            $("#idata_res").val(-999);
            $("#odata_res").val(-999);
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
            <h2><?php echo translate("Què vols fer?", $lang); ?></h2>
        </header>
        <h3 id="tria_1"></h3>
        <div>
            <div class="row uniform">
                <div class="12u$">
                    <ul class="icons-grid">
                        <li>
                            <a href="#three" id="triadates" class="scrolly"><span class="icon major fa-calendar"></span>
                            <h5><?php echo translate("Escollir dates", $lang); ?></h5></a>
                        </li>
                        <li>
                            <a href="#three" id="regal" class="scrolly"><span class="icon major fa-birthday-cake "></span>
                            <h5><?php echo translate("És un regal", $lang); ?></br><?php echo translate("(data oberta)", $lang); ?></h5></a>
                        </li>
                        <li>
                            <a href="#four" class="scrolly"><span class="icon major fa-pencil"></span>
                            <h5><?php echo translate("Sol·licitar informació", $lang); ?></h5></a>
                        </li>
                        <li>
                            <a href="#one"  class="scrolly"><span class="icon major fa-level-up"></span>
                            <h5><?php echo translate("Tornar a començar", $lang); ?></h5></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <a href="#three" class="goto-next scrolly">Next</a>
</div>
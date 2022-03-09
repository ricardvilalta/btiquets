<?php    
// APORTACIÓ VOLUNTÀRIA
// PAS 1
?>

<script type="text/javascript">

    $(document).ready(function()
    {   

        $('#quant_input').on('input',function(){
            Recalcular(); 
        });
    });
    
    function Recalcular()
    {
        var total = 0;
        
        total = $('#quant_input').val();
        $("#tria_2").html('<strong>' + total  + '€</strong>' ); 
        $('#quant').val(total);
    }

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
    <a href="#header" class="goto-prev scrolly">Prev</a>
    <div class="content">
        <header class="major">
            <h2><?php echo translate("Decideix la teva aportació", $lang); ?></h2>
        </header>
        <section>
            <div class="row uniform">
                <div class="12u$">
                    <label style="display: initial;" for="quant_input"><?php echo translate("Import", $lang); ?></label>
                    <input style="width: 100px;" type="number" min="1" max="1000" name="quant_input" id="quant_input" placeholder="<?php echo translate("Import", $lang); ?>" /> €
                </div>
            </div>
        </section>
    </div>
    <a href="#two" class="goto-next scrolly">Next</a>
</div>
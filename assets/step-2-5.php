<?php    
    switch($enviament['id'])
    {
        case -2:
            $env_value = 0;
            $env_text = $enviament['name'];
            break;
        case -1:
            $env_value = 0;
            $env_text = $enviament['name'];
            break;
        case 0:
            $env_value = 0;
            $env_text = $enviament['name'];
            break;
        default:
            $env_value = 0;
            $env_text = "Segons la zona";
            break;
    }
?>

<script type="text/javascript">

    $(document).ready(function()
    {
    });

</script>


<div class="container">
    <?php
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . $rootfolder . 'boxes/box_' . $event . '/box_image_1.jpg'))
    {?>
    <span class="image fit primary"><img src="<?php echo $rootfolder . "boxes/box_" . $event . "/box_image_1.jpg"; ?>" alt="" /></span>
    <?php
    }?>

<!--    <a href="#two" class="goto-prev scrolly">Prev</a>-->
    <div class="content">
        <header class="">
            <h2><?php echo translate("Cistella", $lang); ?></h2>
        </header> 
        <div class="row uniform">
            <div class="12u">
                <div id="carret">La cistella és buida</div>
            </div>
            <div class="12u">
                <div class="table-wrapper">
                    <table class="special carret_total" style="text-align:left">
                        <tbody>
                            <tr>
                                <td colspan="3">SUBTOTAL</td>
                                <td><h4 id="preu-subtotal" style="text-align:right">0€</h4></td>
                            </tr>
                            <?php
                            if($enviament['type']==-2 && $enviament['list']!=null)
                            {?>
                            <tr>
                                <td colspan="3" style="vertical-align: top;">LLIURAMENT</td>
                                <input type=hidden id="env-value" value="<?php echo $env_value; ?>"/>
                            </tr>
                            <tr id="enviaments">
                                <td colspan="4">
                                    <?php
                                    foreach($enviament['list'] as $uenv)
                                    {
                                        if($uenv['name']!="")
                                        {?>
                                    <div class="12u$">
                                        <input type="radio" data="<?php echo $uenv['name'];?>" id="enviament-<?php echo $uenv['id'];?>" name="enviament" <?php if($box["pagament"]==2) echo 'checked'?>>
                                        <label for="enviament-<?php echo $uenv['id'];?>"><?php echo $uenv['name'];?></label>
                                    </div>
                                    <?php
                                        }
                                    }?>
                                </td>
                            </tr>
                            <?php
                            }
                            else
                            {?>
                            <tr>
                                <td colspan="3" style="vertical-align: top;">LLIURAMENT</td>
                                <input type=hidden id="env-value" value="<?php echo $env_value; ?>"/>
                                <td>
                                    <h4 id="enviament-total" style="text-align:right"><?php echo $env_text; ?></h4>
                                </td>                                
                            </tr>
                            <?php
                            }?>
                            <tr>
                                <td colspan="3">TOTAL</td>
                                <td><h3 id="preu-total" style="text-align:right">0€</h3></td>
                            </tr>
                            <tr>
                                <td colspan="2"></td>
                                <td colspan="2" style="text-align:right"><a id="clear_carret" class="button small">Buidar cistella</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="row uniform">
            <div class="12u$">
                <ul class="actions">
                    <li><a style="display:none" href="#three" id="calnext" class="scrolly button special icon fa-hand-pointer-o"><?php echo translate("Següent", $lang); ?></a></li>
                </ul>
            </div>
        </div>
    </div>
<!--    <a href="#three" class="goto-next scrolly">Next</a>-->
</div>
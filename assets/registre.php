<div class="content">
    <header class="major">
        <h2><?php echo translate("Entra les teves dades", $lang); ?></h2>
    </header>
    <h3 id="tria_2"></h3>
    <div>
        <div class="row uniform">
            <input type=hidden id="box_id" value="<?php echo $event; ?>" />
            <input type=hidden id="data_res" value="<?php echo $box["sessio_unica"]; ?>" />
            <input type=hidden id="cd_id" value="<?php echo $box["codi_descompte"]; ?>" />
            <input type=hidden id="quant" value="" />
            <div class="3u">
                <label class="formulari">Gènere</label>
                <div class="select-wrapper">
                    <select class="" name="genere" id="genere">
                        <option value="-1">-</option>
                        <option value="1">Home</option>
                        <option value="2">Dona</option>
                        <option value="3">No binari</option>
                    </select>
                </div>
            </div>
            <div class="9u$">
                <label class="formulari"><?php echo translate("Nom i Cognoms", $lang); ?></label>
                <input class="required" type="text" name="name" id="name" />
            </div>
            <div class="12u$">
                <label class="formulari"><?php echo translate("Email", $lang); ?></label>
                <input class="required" type="email" name="email" id="email" />
            </div>
            <div class="6u 12u$(xsmall)">
                <label class="formulari"><?php echo translate("Municipi", $lang); ?></label>
                <input type="text" name="city" id="city" />
            </div>
            <div class="6u$ 12u$(xsmall)">
                <label class="formulari"><?php echo translate("Telèfon", $lang); ?></label>
                <input class="required" type="text" name="tel" id="tel" />
            </div>
            <div class="12u$">
                <label class="formulari"><?php if ($box['com_aux'] != "") echo $box['com_aux'];
                                            else echo translate("Comentaris", $lang); ?></label>
                <textarea class="<?php if ($box['com_obl']) echo 'required'; ?>" name="comment" id="comment"></textarea>
            </div>

            <?php
            if ($box['id'] == 502 || $box['id'] == 510 || $box['id'] == 511 || $box['id'] == 207) // TRANSÈQUIA 2022
            { ?>
                <div class="12u$(xsmall)">
                    <input type="checkbox" name="check_1" id="check_1" />
                    <label for="check_1">AUTOCAR: Vull agafar un autocar de Transèquia a l'estació d'autobusos de Manresa per arribar al punt d'inici i començar el recorregut (caldrà ser a l'estació d'autobusos 30 minuts abans de l'hora d'inici seleccionada) *</label>
                </div>
                <div class="12u$(xsmall)">
                    <input type="checkbox" name="check_2" id="check_2" />
                    <label for="check_2">CORRENT: Vull fer la Transéquia corrent i recollir la bossa del participant al final del recorregut *</label>
                </div>
                <div class="12u$(xsmall)">
                    <input type="checkbox" name="check_3" id="check_3" />
                    <label for="check_3">CELIAQUIA: Vull una bossa del participant amb aliments sense gluten *</label>
                </div>
                <label class="formulari">*Si no s'aplica a tots els participants de la reserva, indiqueu-ho als comentaris</label>
                <label class="formulari">Cal emplenar les dades de cadascun dels participants</label>
                <div id="dades_inscrits"></div>
            <?php
            } ?>

            <?php
            if ($box['id'] == 548) // ROMÀNIC AL BAGES
            { ?>
                <label class="formulari">Cal emplenar les dades de cadascun dels participants</label>
                <div id="dades_inscrits"></div>
            <?php
            } ?>

            <?php include('assets/checks.php'); ?>

            <div class="12u$">
                <ul class="actions">
                    <li><a id="action-1" class="button special icon fa-check-square-o "><?php echo translate("Confirmar", $lang); ?></a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
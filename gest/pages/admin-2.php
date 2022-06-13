<?php

if ($_SESSION['user_id'] == $SUPERUSER) {
    if ($accountuid > 0) {
        $compte = GetAccountInfo($mysqli, $accountuid);
    } else {
        $compte = GetAccountfromUserInfo($mysqli, $_SESSION['user_id']);
    }
} else {
    $compte = GetAccountfromUserInfo($mysqli, $_SESSION['user_id']);
}


if ($_SESSION['user_id'] == $SUPERUSER && $accountuid < 0) {    
    //$total=GetReservationListInfo($mysqli);
    //$reserves = GetReservationList($mysqli,-1,100,$pagination);
    $total=GetReservationListFromBoxInfo($mysqli,$xid,$tid,-1,$did1,$did2);
    $reserves = GetReservationListFromBox($mysqli,$xid,$tid,-1,$did1,$did2,100,$pagination);

} else {    
    //$reserves = GetReservationList($mysqli, $compte['id'],100,$pagination);
    $total=GetReservationListFromBoxInfo($mysqli,$xid,$tid,$compte['id'],$did1,$did2);
    $reserves = GetReservationListFromBox($mysqli,$xid,$tid,$compte['id'],$did1,$did2,100,$pagination);
}
$npagines=ceil($total/100);

if ($_SESSION['user_id'] == $SUPERUSER && $accountuid < 0) {
    $boxlist = GetBoxListAdmin($mysqli, -1);
} else {
    $boxlist = GetBoxListAdmin($mysqli, -1, $compte['id']);
}

$activitats = GetBoxes($mysqli);

$estat_reserva_1 = array(-2 => translate("Pagament en curs", $lang), -1 => translate("Pagament denegat", $lang), 0 => translate("Pendent de pagament", $lang), 1 => translate("Reserva correcta", $lang), 2 => translate("Activitat realitzada", $lang), 3 => translate("Pre-reserva", $lang));

$estat_reserva_2 = array(-2 => translate("Reserva en curs", $lang), -1 => translate("Reserva denegada", $lang), 0 => translate("Reserva enviada", $lang), 1 => translate("Reserva acceptada", $lang), 2 => translate("Reserva realitzada", $lang), 3 => translate("Pre-reserva", $lang));

$estat_reserva_3 = array(-2 => translate("Pagament en curs", $lang), -1 => translate("Pagament denegat", $lang), 0 => translate("Pendent de pagament", $lang), 1 => translate("Compra correcta", $lang), 2 => translate("Compra correcta", $lang), 3 => translate("Pre-reserva", $lang));
?>

<script type="text/javascript">
    $(document).ready(function() {

        $("#experiencies_sel").val($('#xid').val());
        $("#type_reserves").val($('#tid').val());
        $("#sessions").val($('#sid').val());
        $("#data_type_1").val($('#did1').val());
        $("#data_type_2").val($('#did2').val());

        TableSelectionEvent();
        $("#reserves").tablesorter();

        $('#edit_res').click(function() {
            var id = $('#reserves .success').attr('id');
            if (id != undefined) {
                window.open('/admin/edit-reservation/' + id, '_blank');
            }
        });

        $('tr').dblclick(function() {
            var id = $(this).attr('id');
            if (id != undefined) {
                window.open('/admin/edit-reservation/' + id, '_blank');
            }
        });

        $('#delete_res').click(function() {
            if ($('#reserves .success').length == 1) {
                var id = $('#reserves .success').attr('id');
                if (id != undefined) {
                    if (confirm('<?php echo translate("N\'estàs segur?", $lang); ?>')) {
                        $.ajax({
                            type: "POST",
                            url: "/php/server_actions.php",
                            data: {
                                op: "delete_reservation",
                                id: id
                            },
                            dataType: 'json'
                        }).always(function() {
                            location.reload();
                        });
                    }
                }
            } else {

                if (confirm('<?php echo translate("N\'estàs segur?", $lang); ?> (' + $('#reserves .success').length + ' seleccionades)')) {
                    $(".loading").show();
                    var id = "";
                    $('#reserves .success').each(function() {
                        if ($(this).attr('id') != undefined) {
                            id += $(this).attr('id');
                            id += ';';
                        }
                    });
                    $.ajax({
                        type: "POST",
                        url: "/php/server_actions.php",
                        data: {
                            op: "delete_reservation_array",
                            id: id
                        },
                        dataType: 'json'
                    }).always(function() {
                        location.reload();
                    });
                }
            }
        });

        $('#export_res').click(function() {

            $('#tid').val($('#type_reserves').val());
            $('#xid').val($('#experiencies_sel').val());
            $('#sid').val($('#sessions').val());
            $('#did1').val($('#data_type_1').val());
            $('#did2').val($('#data_type_2').val());

            $('#uid').val("<?php echo $compte['id']; ?>");
            $('#export_form').submit();
        });

        $('#send_res_1').click(function() {

            if ($('#reserves .success').length == 1) {
                var id = $('#reserves .success').attr('id');
                if (id != undefined) {
                    $(".loading").show();
                    $.ajax({
                        type: "POST",
                        url: "/php/server_actions.php",
                        data: {
                            op: "send_reservation",
                            id: id
                        },
                        dataType: 'json'
                    }).always(function(data) {
                        $(".loading").hide();
                        alert("Correu enviat");
                    });
                }
            } else {

                if (confirm('<?php echo translate("N\'estàs segur?", $lang); ?> (' + $('#reserves .success').length + ' seleccionades)')) {
                    $(".loading").show();
                    var id = "";
                    $('#reserves .success').each(function() {
                        if ($(this).attr('id') != undefined) {
                            id += $(this).attr('id');
                            id += ';';
                        }
                    });
                    $.ajax({
                        type: "POST",
                        url: "/php/server_actions.php",
                        data: {
                            op: "send_reservation_array",
                            id: id
                        },
                        dataType: 'json'
                    }).always(function(data) {
                        $(".loading").hide();
                        alert("Correu enviat");
                    });
                }
            }
        });

        $('#send_res_2').click(function() {
            var id = $('#reserves .success').attr('id');
            if (id != undefined) {
                $(".loading").show();
                $.ajax({
                    type: "POST",
                    url: "/php/server_actions.php",
                    data: {
                        op: "send_notification",
                        id: id
                    },
                    dataType: 'json'
                }).always(function(data) {
                    $(".loading").hide();
                    alert("Correu enviat");
                });
            }
        });

        $('#send_res_3').click(function() {
            var id = $('#reserves .success').attr('id');
            if (id != undefined) {
                $(".loading").show();
                $.ajax({
                    type: "POST",
                    url: "/php/server_actions.php",
                    data: {
                        op: "send_reservation_admin",
                        id: id
                    },
                    dataType: 'json'
                }).always(function(data) {
                    $(".loading").hide();
                    alert("Correu enviat");
                });
            }
        });

        $('#aplicarfiltres').click(function() {
            var aux1 = $("#data_type_1").val();
            var aux2 = $("#data_type_2").val();
            if(aux1=="") aux1="-"; 
            if(aux2=="") aux2="-";
            window.location.href='/admin/2/1/' + $("#experiencies_sel").val() + '/' + $("#type_reserves").val() + '/' + $('#sessions').val() + '/' + aux1 + '/' + aux2;
        });
        
        $('#resetfiltres').click(function() {
            window.open('/admin/2/');
        });

        $('#type_reserves').change(function() {
            // AplicarFiltres($("#experiencies_sel").val(), $("#type_reserves").val(), $('#sessions').val(), $("#data_type_1").val(), $("#data_type_2").val(), $("#data_type_3").val(), $("#data_type_4").val());            
        });

        $('#experiencies_sel').change(function() {
            UpdateSessionList(parseInt($(this).val()));
            //AplicarFiltres($("#experiencies_sel").val(), $("#type_reserves").val(), $('#sessions').val(), $("#data_type_1").val(), $("#data_type_2").val(), $("#data_type_3").val(), $("#data_type_4").val());
        });

        $('#sessions').change(function() {
            //AplicarFiltres($("#experiencies_sel").val(), $("#type_reserves").val(), $('#sessions').val(), $("#data_type_1").val(), $("#data_type_2").val(), $("#data_type_3").val(), $("#data_type_4").val());
        });

        $('.filtre-data-1').change(function() {
            //AplicarFiltres($("#experiencies_sel").val(), $("#type_reserves").val(), $('#sessions').val(), $("#data_type_1").val(), $("#data_type_2").val(), $("#data_type_3").val(), $("#data_type_4").val());
        });

        $('.filtre-data-2').change(function() {
            //AplicarFiltres($("#experiencies_sel").val(), $("#type_reserves").val(), $('#sessions').val(), $("#data_type_1").val(), $("#data_type_2").val(), $("#data_type_3").val(), $("#data_type_4").val());
        });

        $(function() {
            //            jQuery.datepicker.setLocale('ca');
            $(".datetime_input").datepicker({
                dateFormat: 'dd-mm-yy',
                firstDay: 1,
                dayNames: ["Diumenge", "Dilluns", "Dimarts", "Dimecres", "Dijous", "Divendres", "Dissabte"],
                dayNamesMin: ["Dg", "Dl", "Dm", "Dx", "Dj", "Dv", "Ds"],
                monthNames: ["Gener", "Febrer", "Març", "Abril", "Maig", "Juny", "Juliol", "Agost", "Setembre", "Octubre", "Novembre", "Desembre"]
            });
            $(".datetime_input").removeClass("datetime_input");
        });
    });

    function AplicarFiltres(exp_id, estat_id, sessio_id, cdata_ini, cdata_fin, rdata_ini, rdata_fin) {
        $(".loading").show();
        if (sessio_id == -10) {
            $('#reserves tr.table_content').show();
            if (exp_id != -10 || estat_id != -10) {
                $('#reserves tr.table_content').hide();
                str = '#reserves tr';

                if (exp_id != -10) {
                    str += '[bid=';
                    str += $("#experiencies_sel").val();
                    str += ']';
                }
                if (estat_id != -10) {
                    str += '[tid=';
                    str += $("#type_reserves").val();
                    str += ']';
                }

                $(str).show();
            }
        } else {
            $("#any").val(0);
            $("#mes").val(0);
            $('#reserves tr.table_content').hide();
            str = '#reserves tr[sid=' + sessio_id + ']';
            if (exp_id != -10) {
                str += '[bid=';
                str += $("#experiencies_sel").val();
                str += ']';
            }
            if (estat_id != -10) {
                str += '[tid=';
                str += $("#type_reserves").val();
                str += ']';
            }
            $(str).show();
        }

        if (cdata_ini != "" || cdata_fin != "") {
            var dini = new Date(0);
            var dfin = new Date();

            if (cdata_ini != "") {
                var dateini = cdata_ini.split("-");
                dini = new Date(dateini[2], dateini[1] - 1, dateini[0]);
            }
            if (cdata_fin != "") {
                var datefin = cdata_fin.split("-");
                dfin = new Date(datefin[2], datefin[1] - 1, datefin[0]);
            }

            // Comprovacions
            var dates_ok = true;
            if (dini > dfin) {
                dates_ok = false;
                alert("La data de finalització ha de ser posterior a la d'inici del filtre");
            }

            // Filtre
            if (dates_ok) {
                $('#reserves tr.table_content:visible').each(function() {
                    var dline = new Date($(this).attr("cdata"));
                    dline.setHours(0);
                    if (dline < dini || dline > dfin) {
                        $(this).hide();
                    }
                });
            }
        }

        $(".loading").hide();
    }

    function UpdateSessionList(box_id) {
        $(".loading").show();
        $('#sessions').empty();
        if (box_id != -10) {
            $.ajax({
                type: "POST",
                url: "/php/server_actions.php",
                data: {
                    op: "get_session_list",
                    id: box_id,
                    old: true
                },
                dataType: 'json',
                async: false
            }).always(function(data) {
                $('#sessions').append("<option value='-10'>-</option>");
                $('#sessions').append("<option value='-1'>Sessió oberta</option>");
                for (var i = 0; i < data.length; i++) {
                    var str;
                    str = "<option value=" + data[i].id + " bid=" + data[i].box_id + ">" + data[i].data + " " + data[i].hora + "</option>";
                    $('#sessions').append(str);
                    $('#sessions option[value="-10"]').attr("selected", true);
                }
                $(".loading").hide();
            });
        } else {
            $('#sessions').append("<option value='-10'>-</option>");
            $('#sessions option[value="-10"]').attr("selected", true);
            $(".loading").hide();
        }
    }
</script>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Reserves</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <!-- /.panel -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-tasks fa-fw"></i> Llista de reserves
                <div class="pull-right">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                            Accions
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu pull-right" role="menu">
                            <li><a href="/admin/edit-reservation/-1" target="_blank">Nova reserva</a>
                            </li>
                            <li><a id="edit_res">Edita reserva</a>
                            </li>
                            <li><a id="delete_res">Elimina reserva</a>
                            </li>
                            <li><a id="export_res">Exporta .csv</a>
                            </li>
                            <li><a id="send_res_1">Envia la confirmació de la reserva</a>
                            </li>
                            <?php
                            if ($_SESSION['user_id'] == $SUPERUSER) {
                            ?>
                                <li><a id="send_res_3">Envia la confirmació de la reserva - admin</a>
                                </li>
                                <li><a id="send_res_2">Envia la notificació</a>
                                </li>
                            <?php
                            } ?>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">

                <form id="export_form" action="<?php echo $rootfolder . 'php/export_dataset.php'; ?>" method="post" target="_blank">
                    <input id="tid" name="tid" type="hidden" value="<?php echo $tid;?>">
                    <input id="xid" name="xid" type="hidden" value="<?php echo $xid;?>">
                    <input id="sid" name="sid" type="hidden" value="<?php echo $sid;?>">
                    <input id="uid" name="uid" type="hidden" value="">
                    <input id="did1" name="did1" type="hidden" value="<?php echo $did1;?>">
                    <input id="did2" name="did2" type="hidden" value="<?php echo $did2;?>">
                </form>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label><?php echo translate("Experiències", $lang); ?></label>
                            <select class="form-control" id="experiencies_sel">
                                <option value="-10"><?php echo '-'; ?></option>
                                <?php
                                for ($i = 0; $i < count($boxlist); $i++) {
                                    $box = $boxlist[$i];
                                ?>
                                    <option value="<?php echo $box['id']; ?>"><?php echo $box['name']; ?></option>
                                <?php
                                } ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label><?php echo translate("Estat de la reserva", $lang); ?></label>
                            <select class="form-control" id="type_reserves">
                                <option value="-10"><?php echo '-'; ?></option>
                                <option value="-2"><?php echo translate("Pagament en curs", $lang); ?></option>
                                <option value="-1"><?php echo translate("Pagament denegat", $lang); ?></option>
                                <option value="0"><?php echo translate("Pendent de pagament", $lang); ?></option>
                                <option value="1"><?php echo translate("Reserva correcta", $lang); ?></option>
                                <option value="2"><?php echo translate("Activitat realitzada", $lang); ?></option>
                                <option value="3"><?php echo translate("Pre-reserva", $lang); ?></option>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label><?php echo translate("Sessions", $lang); ?></label>
                            <select class="form-control" id="sessions">
                                <option value='-10' selected>-</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group input-group">
                            <label>Data de compra - inici</label><input id="data_type_1" class="filtre-data-1 form-control datetime_input" placeholder="<?php echo translate("Data de compra - inici", $lang); ?>">
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group input-group">
                            <label>Data de compra - final</label><input id="data_type_2" class="filtre-data-1 form-control datetime_input" placeholder="<?php echo translate("Data de compra - final", $lang); ?>">
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>Filtres</label><br>
                            <button id="aplicarfiltres" class="btn btn-primary">Filtrar</button>
                            <button id="resetfiltres" class="btn btn-warning">Reinicialitzar</button>
                        </div>
                    </div>

                    <!--
                    <div class="col-lg-3">
                        <div class="form-group input-group">
                            <label>Data de la reserva - inic</label><input id="data_type_3" class="filtre-data-2 form-control datetime_input" placeholder="<?php echo translate("Data de la reserva - inici", $lang); ?>">
                        </div>
                    </div>
                    
                    <div class="col-lg-3">
                        <div class="form-group input-group">
                            <label>Data de la reserva - final</label><input id="data_type_4" class="filtre-data-2 form-control datetime_input" placeholder="<?php echo translate("Data de la reserva - final", $lang); ?>">
                        </div>
                    </div>
    -->
                </div>
                    
                <div class="row">
                    <div class="col-lg-12">
                        <ul class="pagination">
                            <?php
                            for($i=1;$i<=$npagines;$i++){?>
                            <li class="page-item <?php if($pagination==$i) echo 'active';?>"><a class="page-link" href="<?php echo '/admin/2/'.$i.'/'.$xid.'/'.$tid.'/'.$sid.'/'.$did1.'/'.$did2;?>"><?php echo $i;?></a></li>
                            <?php
                            }?>
                        </ul>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsive">
                            <table style="font-size: 0.9em" id="reserves" class="table table-bordered table-hover noselect tablesorter">
                                <thead>
                                    <tr class="head_row header">
                                        <th width="10%">Compra</th>
                                        <th width="10%">Reserva</th>
                                        <!--                                        <th>Realitzada</th>-->
                                        <th width="8%">Codi</th>
                                        <th width="17%">Activitat</th>
                                        <th width="10%">Quantitat</th>
                                        <th width="5%">Total</th>
                                        <th width="10%">Nom</th>
                                        <th width="10%">Estat</th>
                                        <?php
                                        if ($_SESSION['user_id'] == $SUPERUSER) {
                                        ?>
                                            <th width="10%">Propietari</th>
                                        <?php
                                        }
                                        ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    for ($i = 0; $i < min(count($reserves), 3000); $i++) {
                                        $reserva = $reserves[$i];
                                        $quant_modalities = explode(';', $reserva['quantitat']);
                                        $box = GetBox($mysqli, $reserva['box_id']);
                                        if ($box == null) {
                                            continue;
                                        }
                                        $compte = GetAccountInfo($mysqli, $box['propietari']);
                                        $price_modalities = decode_price($box['price'], false);
                                        $dexe = explode('-', $reserva['data_executada']);

                                        if ($reserva["session_id"] > 0) {
                                            $sessio = GetSession($mysqli, $reserva["session_id"]);
                                            if ($sessio != null) {
                                                $data_2 = $sessio['data'] . " " . $sessio['hora'];
                                                $sdata = date_create_from_format('d-m-Y', $sessio['data']);
                                                $data_2_xp = date_format($sdata, 'Y-m-d');
                                            } else {
                                                $data_2 = '-';
                                                $data_2_xp = "";
                                            }
                                        } else {
                                            if ($reserva['data_reservada'] == "0000-00-00 00:00:00") {
                                                $data_2 = '-';
                                                $data_2_xp = "";
                                            } else {
                                                $data_2 = date_format($sdata, 'd-m-Y H:i');
                                                $data_2_xp = date_format($sdata, 'Y-m-d');
                                                //                                                if($box['etype']==2)                                                
                                                //                                                {
                                                //                                                    $sdata = date_create_from_format('Y-m-d H:i:s',$reserva['data_reservada']);
                                                //                                                    $date_session = date_format($sdata,'d-m-Y');
                                                //                                                    $time_session = date_format($sdata,'H:i');
                                                //                                                    if($time_session=="00:00")
                                                //                                                    {
                                                //                                                        $data_2 = $date_session . " MIGDIA";
                                                //                                                    }
                                                //                                                    else
                                                //                                                    {
                                                //                                                        $data_2 = $date_session . " NIT";
                                                //                                                    }
                                                //                                                }
                                                //                                                else
                                                //                                                {                                                    
                                                //                                                    $sdata = date_create_from_format('Y-m-d H:i:s',$reserva['data_reservada']);
                                                //                                                    $data_2 = date_format($sdata,'d-m-Y H:i');                                                    
                                                //                                                }

                                            }
                                        }

                                        $sdata = date_create_from_format('Y-m-d', $reserva['data']);
                                        $data_1 = date_format($sdata, 'd-m-Y');
                                        $data_1_xp = $reserva['data'];

                                        if ($reserva['data_executada'] == 0000 - 00 - 00) {
                                            $data_3 = '-';
                                        } else {
                                            $sdata = date_create_from_format('Y-m-d', $reserva['data_executada']);
                                            $data_3 = date_format($sdata, 'd-m-Y');
                                        }

                                    ?>
                                        <tr class="table_content" id='<?php echo $reserva["id"]; ?>' tid='<?php echo $reserva["confirmat"]; ?>' bid='<?php echo $reserva["box_id"]; ?>' sid='<?php echo $reserva["session_id"]; ?>' any='<?php echo intval($dexe[0]); ?>' mes='<?php echo intval($dexe[1]); ?>' cdata="<?php echo $data_1_xp; ?>" rdata="<?php echo $data_2_xp; ?>">
                                            <td style="white-space: nowrap;"><?php echo $data_1; ?></td>
                                            <td style="white-space: nowrap;"><?php echo $data_2; ?></td>
                                            <!--                                        <td><?php echo $data_3; ?></td>-->
                                            <td><?php echo strtoupper($reserva['ref']); ?></td>
                                            <td><?php if ($reserva['box_id'] == -1) echo $reserva['nom_exp'];
                                                else echo $activitats[$reserva['box_id']]; ?></td>
                                            <td>
                                                <?php
                                                if ($box['etype'] == 5) {
                                                    $producte_list = GetProductefromList($mysqli, $box["productes"]);
                                                    echo '<select style="max-width:100px">';
                                                    foreach ($producte_list as $producte) {
                                                        foreach ($producte['modalitat'] as $prod_item) {
                                                            $carret = decode_carret($reserva['quantitat'], $producte['id'], $prod_item['id']);
                                                            if (count($carret) > 0) {
                                                                $quant = intval($carret[0]['quant']);
                                                                echo '<option>';
                                                                echo $quant . ' x ' . $producte['name'] . ' - ' . $prod_item['nom'];
                                                                echo '</option>';
                                                            }
                                                        }
                                                    }
                                                    echo '</select>';
                                                } else if ($box['etype'] == 7) {
                                                } else {
                                                    if (count($quant_modalities) == 0 || $reserva['quantitat'] == "") {
                                                        echo $reserva['quant_total'];
                                                    } else {
                                                        echo '<select style="max-width:100px">';
                                                        for ($j = 0; $j < min(count($quant_modalities), count($price_modalities)); $j++) {
                                                            if ($quant_modalities[$j] != "") {
                                                                $price = $price_modalities[$j];
                                                                echo '<option>';
                                                                echo $quant_modalities[$j] . ' x ' . $price['name'];
                                                                echo '</option>';
                                                            }
                                                        }
                                                        echo '</select>';
                                                    }
                                                }
                                                ?>
                                            </td>
                                            <td><?php echo $reserva['total']; ?></td>
                                            <td><?php echo $reserva['rnom']; ?></td>
                                            <td style="white-space: nowrap;"><?php if ($box['etype'] <= 1) echo $estat_reserva_1[$reserva['confirmat']];
                                                                                else if ($box['etype'] == 4 || $box['etype'] == 5 || $box['etype'] == 7) echo $estat_reserva_3[$reserva['confirmat']];
                                                                                else echo $estat_reserva_2[$reserva['confirmat']]; ?></td>
                                            <?php
                                            if ($_SESSION['user_id'] == $SUPERUSER) {
                                            ?>
                                                <td><?php echo $compte['nom']; ?></td>
                                            <?php
                                            }
                                            ?>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.table-responsive -->
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
</div>
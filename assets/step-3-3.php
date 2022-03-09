<?php    
?>

<script type="text/javascript">

    $(document).ready(function()
    {   
        Calendar();
        
        function Calendar()
        {
            $(".stdcal").datepicker({                        
                minDate: 0,
                firstDay: '<?php echo $firstday; ?>',
                dayNamesMin: [<?php echo $dayNamesMin; ?>],
                monthNamesShort: [<?php echo $monthNamesShort; ?>],
                monthNames: [<?php echo $monthNames; ?>],
                onSelect: function(selectedDate,inst) {

                    var result = selectedDate.split('/');
                    var day = result[1];
                    var month = result[0];
                    var year = result[2];
                    $(this).attr("d",day);
                    $(this).attr("m",month);
                    $(this).attr("y",year);
                    var mydate = day + '/' + month + '/' + year;
                    var ref = $(this).attr('ref');
                    $(ref).val(mydate);
                    var oref = $(this).attr('oref');
                    $(oref).html(mydate);
                    $(this).attr('ref')=="#idate" ? $("#idata_res").val(mydate) : $("#odata_res").val(mydate);
                    $(".cal_info2").hide();
                    $(".cal_info").show();
                    $('.stdcal').hide();
                    
                    if($("#eventcalendar-1").attr("d")!="" && $("#eventcalendar-1").attr("m")!="" && $("#eventcalendar-1").attr("y")!="" && $("#eventcalendar-2").attr("d")!="" && $("#eventcalendar-2").attr("m")!="" && $("#eventcalendar-2").attr("y")!="")
                    {
                        var idate = new Date($("#eventcalendar-1").attr("y"),$("#eventcalendar-1").attr("m"),$("#eventcalendar-1").attr("d"),0,0,0).getTime();
                        var odate = new Date($("#eventcalendar-2").attr("y"),$("#eventcalendar-2").attr("m"),$("#eventcalendar-2").attr("d"),0,0,0).getTime();
                        var dif =(odate-idate)/(1000*60*60*24);
                        CalcularPreu(dif);
                        $("#calnext").show();
                    }
                },                
                afterShow: function() { 
                },
            });
        }
        
        function CalcularPreu(days)
        {
            var preu = days * $("#preu_unit").val();
            $("#field22").html(days+'<?php echo translate(" nit/s", $lang); ?>');
            $("#field4").html($("#rname").val() + " - " + days +'<?php echo translate(" nit/s", $lang); ?>');
            $("#field5").html('<?php echo translate("Preu total: ", $lang); ?>' + preu + "€");
        }
        
        $(function() {
            $.datepicker._updateDatepicker_original = $.datepicker._updateDatepicker;
            $.datepicker._updateDatepicker = function(inst) {
                $.datepicker._updateDatepicker_original(inst);
                var afterShow = this._get(inst, 'afterShow');
                if (afterShow)
                    afterShow.apply((inst.input ? inst.input[0] : null));  // trigger custom callback
            }
        });                
        
        $('#idate').click(function(){
            $('#eventcalendar-2').hide();
            //$('#eventcalendar').attr('ref','#idate');
            $('#eventcalendar-1').is(":visible") ? $('#eventcalendar-1').hide() : $('#eventcalendar-1').show();
        });
        
        $('#odate').click(function(){
            $('#eventcalendar-1').hide();
            //$('#eventcalendar').attr('ref','#odate');
            $('#eventcalendar-2').is(":visible") ? $('#eventcalendar-2').hide() : $('#eventcalendar-2').show();
        });
        
//        $('#idate').focusout(function() {
//            $('#eventcalendar-1').hide().delay(800);
//        });
//        
//        $('#odate').focusout(function() {
//            $('#eventcalendar-2').hide().delay(800);
//        });
        
        $( "#hdays" ).on('change',function() {
            CalcularPreu($(this).val());
            $("#calnext").show();
        });
    });

</script>


<div class="container">
    <?php
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . $rootfolder . 'boxes/box_' . $event . '/box_image_1.jpg'))
    {?>
    <span class="image fit primary"><img src="<?php echo $rootfolder . "boxes/box_" . $event . "/box_image_1.jpg"; ?>" alt="" /></span>
    <?php
    }?>

    <a href="#two" class="goto-prev scrolly">Prev</a>
    <div class="content">
        <header class="major">
            <h2><?php echo translate("Tria la data/durada", $lang); ?></h2>
        </header> 
        <div class="row uniform">
            <div class="3u">
            </div>
            <div style="text-align: center;" class="6u all_dades"> 
                <h5 id="field1"></h5>
                <h5 id="field2"></h5>
                <h5 id="field22"></h5>
            </div>
            <div class="3u">
            </div>
        </div>
        <div class="caltype_1">
            <div class="row uniform">
                <div class="6u">
                    <h4><?php echo translate("Data d'entrada", $lang); ?></h4>
                    <input id="idate" type="text" placeholder="-">
                    <div class="stdcal hidingcal" id="eventcalendar-1" d="" m="" y="" ref="#idate" oref="#startdate"></div>   

                </div>
                <div class="6u">
                    <h4><?php echo translate("Data de sortida", $lang); ?></h4>
                    <input id="odate" type="text" placeholder="-">
                    <div class="stdcal hidingcal" id="eventcalendar-2" d="" m="" y="" ref="#odate" oref="#enddate"></div>   
                </div> 
            </div>
        </div>
        <div class="caltype_2">
            <div class="row uniform">
                <div class="12u">
                    <h4><?php echo translate("Nombre de nits", $lang); ?></h4>
                    <div class="select-wrapper">
                        <select id="hdays">
                            <option value="1">1 nit</option>
                        <?php
                        for($i=2;$i<=15;$i++)
                        {
                            echo "<option value=".$i.">".$i." nits</option>";
                        }
                        ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row uniform">
            <div class="12u$">
                <ul class="actions">
                    <li><a style="display:none" href="#four" id="calnext" class="scrolly button special icon fa-hand-pointer-o"><?php echo translate("Següent", $lang); ?></a></li>
                </ul>
            </div>
        </div>
    </div>
    <a href="#four" class="goto-next scrolly">Next</a>
</div>
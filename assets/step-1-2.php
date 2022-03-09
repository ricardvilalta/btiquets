<?php
?>

<script type="text/javascript">

    $(document).ready(function()
    {   
        var res_day=[];
        res_day.push({act:"<?php echo $res_days[7]['act']; ?>",places:"<?php echo $res_days[7]['places']; ?>"});
        res_day.push({act:"<?php echo $res_days[17]['act']; ?>",places:"<?php echo $res_days[17]['places']; ?>"});
        res_day.push({act:"<?php echo $res_days[1]['act']; ?>",places:"<?php echo $res_days[1]['places']; ?>"});
        res_day.push({act:"<?php echo $res_days[11]['act']; ?>",places:"<?php echo $res_days[11]['places']; ?>"});
        res_day.push({act:"<?php echo $res_days[2]['act']; ?>",places:"<?php echo $res_days[2]['places']; ?>"});
        res_day.push({act:"<?php echo $res_days[12]['act']; ?>",places:"<?php echo $res_days[12]['places']; ?>"});
        res_day.push({act:"<?php echo $res_days[3]['act']; ?>",places:"<?php echo $res_days[3]['places']; ?>"});
        res_day.push({act:"<?php echo $res_days[13]['act']; ?>",places:"<?php echo $res_days[13]['places']; ?>"});
        res_day.push({act:"<?php echo $res_days[4]['act']; ?>",places:"<?php echo $res_days[4]['places']; ?>"});
        res_day.push({act:"<?php echo $res_days[14]['act']; ?>",places:"<?php echo $res_days[14]['places']; ?>"});
        res_day.push({act:"<?php echo $res_days[5]['act']; ?>",places:"<?php echo $res_days[5]['places']; ?>"});
        res_day.push({act:"<?php echo $res_days[15]['act']; ?>",places:"<?php echo $res_days[15]['places']; ?>"});
        res_day.push({act:"<?php echo $res_days[6]['act']; ?>",places:"<?php echo $res_days[6]['places']; ?>"});
        res_day.push({act:"<?php echo $res_days[16]['act']; ?>",places:"<?php echo $res_days[16]['places']; ?>"});
        
        Calendar();
        
//        $('.quant_input').change(function(){
//            
//            $("#tria_1").html($('#eventsession input:checked').attr('data') + ' ' + $('#eventsession input:checked').attr('sessio'));
//            $("#tria_1").append('<br>');
//            $("#tria_1").append($('.quant_input').val()+($('.quant_input').val()==1?' persona':' persones'));
//            
//            if($('#eventsession input:checked').attr('sessio')=="migdia")
//            {
//                $('#data_res').val($('#eventsession input:checked').attr('data') + " " + "00:00"); 
//            }
//            else
//            {
//                $('#data_res').val($('#eventsession input:checked').attr('data') + " " + "11:11");
//            }
//            $('#quant').val($('.quant_input').val());
//        });
        
        $('.horari_input').change(function(){
            
            $("#tria_1").html($('#eventsession input:checked').attr('data') + ' ' + $('#eventsession input:checked').attr('sessio') + ' (' + $(".horari_input option:selected").text() + ')');
            $("#tria_1").append('<br>');
            $("#tria_1").append($('.quant_input').val()+($('.quant_input').val()==1?' persona':' persones'));
            
            $('#data_res').val($('#eventsession input:checked').attr('data') + " " + $(".horari_input option:selected").text()); 
            
//            if($('#eventsession input:checked').attr('sessio')=="migdia")
//            {
//                $('#data_res').val($('#eventsession input:checked').attr('data') + " " + "00:00"); 
//            }
//            else
//            {
//                $('#data_res').val($('#eventsession input:checked').attr('data') + " " + "11:11");
//            }
            $('#quant').val($('.quant_input').val());
        });
        

        function Calendar()
        {
            $("#eventcalendar").datepicker({                        
                minDate: 0,
                firstDay: '<?php echo $firstday; ?>',
                dayNamesMin: [<?php echo $dayNamesMin; ?>],
                monthNamesShort: [<?php echo $monthNamesShort; ?>],
                monthNames: [<?php echo $monthNames; ?>],              
                onSelect: function(selectedDate,inst) {
                    
                    var date = $(this).datepicker('getDate');
                    var wday = (parseInt(date.getUTCDay())+1)%7;                    

                    var result = selectedDate.split('/');
                    var day = result[1];
                    var month = result[0];
                    var year = result[2];
        
                    $('.quant_input').empty();
                    $('.horari_input').empty();
                    $("#eventsession").empty();
                    
                    var str = "";
                    if(res_day[2*wday].act==1)
                    {
                        str = str + '<input data="' + day + '/' + month + '/' + year + '" sessio="migdia"';
                        str += ' id="servei_0" type="radio" name="sess" value="0">';
                        str += '<label for="servei_0">Migdia</label>';
                    }
                    if(res_day[2*wday+1].act==1)
                    {
                        str = str + '<input data="' + day + '/' + month + '/' + year + '" sessio="nit"';
                        str += ' id="servei_1" type="radio" name="sess" value="1">';
                        str += '<label for="servei_1">Nit</label>';
                    }
                            
        
                    $("#eventsession").html(str);
                    
                    $("#eventsession input").click(function(){
                        
                        $('.quant_input').empty();
                        if($(this).val()==0)
                        {
                            amount = res_day[2*wday].places;
                        }
                        else
                        {
                            amount = res_day[2*wday+1].places;
                        }
                        
                        
                        $('.quant_input').append('<option value="-1">' + "<?php echo translate("Selecciona", $lang); ?>" + '</option>');
                        for(var i=1;i<=amount;i++)
                        {
                            var str = '<option value="' + i + '">' + i + (i==1?' persona':' persones') + '</option>';
                            $('.quant_input').append(str);
                        }
                        
                        $('.horari_input').empty();
                        if($(this).val()==0)
                        {
                            amount = res_day[2*wday].places;
                        }
                        else
                        {
                            amount = res_day[2*wday+1].places;
                        }
                        
                        
                        $('.horari_input').append('<option value="-1">' + "<?php echo translate("Selecciona", $lang); ?>" + '</option>');
                        if($(this).val()==0)
                        {
                            $('.horari_input').append('<option value="1">13:00</option>');
                            $('.horari_input').append('<option value="1">13:30</option>');
                            $('.horari_input').append('<option value="1">14:00</option>');
                            $('.horari_input').append('<option value="1">14:30</option>');
                            $('.horari_input').append('<option value="1">15:00</option>');
                        }
                        else 
                        {
                            $('.horari_input').append('<option value="1">21:00</option>');
                            $('.horari_input').append('<option value="1">21:30</option>');
                            $('.horari_input').append('<option value="1">22:00</option>');
                            $('.horari_input').append('<option value="1">22:30</option>');
                            $('.horari_input').append('<option value="1">23:00</option>');                        
                        }
                        
                    });
                }, 
                beforeShowDay: function(date){ 
                    var day = parseInt(date.getDay());                    
                    if(res_day[2*day].act==1 || res_day[2*day+1].act==1)
                    {
                        return [true,"available_date"];
                    }
                    else
                    {
                        return [false,""];
                    }
                },
                afterShow: function() {
                },
            });
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
        
    });

</script>


<div class="container">
    <?php
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . $rootfolder . 'boxes/box_' . $event . '/box_image_1.jpg'))
    {?>
    <span class="image fit primary"><img src="<?php echo $rootfolder . "boxes/box_" . $event . "/box_image_1.jpg"; ?>" alt="" /></span>
    <?php
    }?>
        
    <div class="content">
        <header class="major">
            <h2><?php echo translate("Tria la data", $lang); ?></h2>
        </header>
        <p></p>
        <div class="row uniform">
            <div class="8u stdcal" id="eventcalendar"></div>        
            <div class="4u" id="sessionlist">
                <h4><?php echo translate("Servei", $lang); ?></h4>
                <div style="text-align:left;height:80px;" id="eventsession"></div>            
            </div>
            <div class="4u" id="comlist">
                <h4><?php echo translate("Comensals", $lang); ?></h4>
                <div class="select-wrapper">
                    <select class="quant_input">
                        <option value="-1"><?php echo translate("Selecciona", $lang); ?></option>
                    </select>
                </div>
            </div>
            <div class="4u" id="comlist">
                <h4><?php echo translate("Horari", $lang); ?></h4>
                <div class="select-wrapper">
                    <select class="horari_input">
                        <option value="-1"><?php echo translate("Selecciona", $lang); ?></option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <a href="#two" class="goto-next scrolly">Next</a>
</div>
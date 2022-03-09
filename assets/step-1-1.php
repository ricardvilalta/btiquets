<?php
// ESDEVENIMENT MÚLTIPLE
// PAS 1
?>

<script type="text/javascript">

    $(document).ready(function()
    {               
        var no_sessions = "<?php echo translate("(sense sessions)", $lang); ?>";
        var sessions=[];
        <?php
        foreach($sessions as $session)
        {
            $sdata = date_create_from_format('d-m-Y',$session['data']);
            $syear = date_format($sdata,'Y');
            $smonth = date_format($sdata,'m');
            $sday = date_format($sdata,'d');
            $inscrits = GetReservationFromSession($mysqli,$session['id']);
        ?>            
            $(".ui-datepicker-calendar td[data-month='<?php echo $smonth-1; ?>'][data-year='<?php echo $syear; ?>'] > a").filter(function(index) { return parseInt($(this).text()) == "<?php echo intval($sday); ?>"; }).css("background", "#8cd1a8");
            sessions.push(["<?php echo $sday; ?>","<?php echo $smonth; ?>","<?php echo $syear; ?>","<?php echo $session['hora']; ?>","<?php echo $session['id']; ?>","<?php echo $session['session_name']; ?>","<?php echo $inscrits; ?>","<?php echo $session['places']; ?>","<?php echo $session['tarifes']; ?>"]);
            
        <?php
        }?> 
        
        Calendar();
        $("#eventcalendar").datepicker("setDate", new Date(sessions[0][2], sessions[0][1] - 1, sessions[0][0]));
        PaintCalendarSessions();
        DisplaySessions(sessions[0][1]+"/"+sessions[0][0]+"/"+sessions[0][2]);
        
        function Calendar()
        {
            $("#eventcalendar").datepicker({                        
                firstDay: '<?php echo $firstday; ?>',
                dayNamesMin: [<?php echo $dayNamesMin; ?>],
                monthNamesShort: [<?php echo $monthNamesShort; ?>],
                monthNames: [<?php echo $monthNames; ?>],
                onSelect: function(selectedDate,inst) {
                    DisplaySessions(selectedDate);
                },                
                afterShow: function() {   
                    PaintCalendarSessions();
                },
            });            
        }
        
        function DisplaySessions(selectedDate)
        {
            var result = selectedDate.split('/');
            var day = result[1];
            var month = result[0];
            var year = result[2];

            $("#eventsession").empty();

            var b_session=false;
            var str = "";
            for (var i = 0; i < sessions.length; i++)
            {  
                var hora = sessions[i][5]=="" ? sessions[i][3] : sessions[i][5]
                if(sessions[i][2]==year)
                {
                    if(sessions[i][1]==month)
                    {                         
                        if(sessions[i][0]==day)
                        {       
                            freeplaces = 0;
                            if(sessions[i][7]-sessions[i][6]>0) freeplaces = sessions[i][7]-sessions[i][6];

                            str = str + '<input data="' + sessions[i][0] + '/' + sessions[i][1] + '/' + sessions[i][2] + ' ' + hora + '" id="';
                            str += sessions[i][4];
                            str += '" places=';
                            str += freeplaces;
                            str += ' type="radio" name="sess" value="';
                            str += sessions[i][3];
                            str += '" tid="'
                            str += sessions[i][8];
                            str += '" ';
                            if(freeplaces==0) str += 'disabled';
                            str += '>';
                            str += '<label style="line-height:1.2;font-size:0.9em;" for="';
                            str += sessions[i][4];
                            str += '">';
                            str += hora;
                            str += '<br> (';
                            str += freeplaces;
                            str += ' <?php if($box['id']==337 || $box['id']==342  || $box['id']==343 || $box['id']==354  || $box['id']==369  || $box['id']==375 || $box['id']==376) echo "grup/s disponible/s"; else echo translate("places", $lang); ?>)';
                            str += '</label>';
                        }
                    }
                }
            }       
            str += "</ul>";

            $("#eventsession").html(str);
            $("#eventdate").html(day + '/' + month + '/' + year);

            $("#eventsession input").click(function(){                        
                $("#tria_1").html($('#eventsession input:checked').attr('data'));
                $('#data_res').val($('#eventsession input:checked').attr('id'));                        

                $('.mod_list').show();
                if($('#eventsession input:checked').attr('tid')!="")
                {
                    var resstr = $('#eventsession input:checked').attr('tid');
                    var res = resstr.split(":");
//                    if(!res.includes("-1"))
                    if(res.indexOf('-1')==-1)
                    {
                        $('.mod_list').each(function(){
//                            if(!res.includes($(this).attr("mid")))
                            if(res.indexOf($(this).attr("mid"))==-1)
                            {
                                $(this).hide();
                            }
                        });
                    }
                }

                $('.quant_input').empty();
                $('.quant_input').each(function(){
                    if($(this).attr('data-max')>0)
                    {
                        max_value = Math.min($('#eventsession input:checked').attr('places'),$(this).attr('data-max')); 
                    }
                    else
                    {
                        max_value = $('#eventsession input:checked').attr('places');
                    }
                    $(this).append('<option value="0" selected>-</option>');
                    for(var i=1;i<=max_value;i++)
                    {
                        $(this).append('<option value="' + i +'">' + i + '</option>');
                    }
                });
            });
        }
        
        function PaintCalendarSessions()
        {
            for (var i = 0; i < sessions.length; i++)
            {
                var year = sessions[i][1]- 1;
                var sel = '.ui-datepicker-calendar td[data-month="'+year+'"][data-year="'+sessions[i][2]+'"] > a';
                $(sel).filter(function(index) { return parseInt($(this).text()) == parseInt(sessions[i][0]); }).css("background", "#8cd1a8");
            }
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
            <div class="12u stdcal" id="eventcalendar"></div>
        </div>
        <div class="row uniform">
            <div class="12u" id="sessionlist">
                <h4><?php echo translate("Sessions", $lang); ?><div id="eventdate"></div></h4>                
                <div id="eventsession"></div>
            </div>
        </div>
    </div>
    <a href="#two" class="goto-next scrolly">Next</a>
</div>
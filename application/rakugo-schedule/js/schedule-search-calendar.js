$(document).ready(function(){
    //clear checkbox and textbox
    $("input:checkbox").removeAttr("checked");
    $("#s_group").val("");

    // init calendar view
    $('#calendar').fullCalendar({
    	//theme: true,
    	header: {
    		left: 'prev,next today',
    		center: 'title',
    		right: 'month,agendaWeek,agendaDay'
    	},
    	//editable: true,
        header:{
              left:   '',
              center: 'title',
              right:  'today prev,next'
          },
    	events: base_url + "application/rakugo-schedule/schedule.php?action=json_calendar_events",
        region: fullCalendarLanguage
    });

    //fake month view
    check_today_disabled();
    $("#prev_month").click(function(){$(".fc-button-prev").trigger("click");check_today_disabled();});
    $("#today_month").click(function(){$(".fc-button-today").trigger("click");check_today_disabled();});
    $("#next_month").click(function(){$(".fc-button-next").trigger("click");check_today_disabled();});

    /* make it easier for filtering via checkbox by trigger from label */
    $(".group_filter_trigger").click(function(){
        $(this).closest("tr").find("td:nth-child(1) input[type=checkbox]").trigger("click");
    });

    /* filter by date: event key change hidden textbox */
    if(rLanguage == "ja"){
        $("#s_date_min").datepicker({ dateFormat: 'yy年mm月dd日' });
        $("#s_date_max").datepicker({ dateFormat: 'yy年mm月dd日' });
    }
    else{
        $("#s_date_min").datepicker({ dateFormat: 'yy/mm/dd' });
        $("#s_date_max").datepicker({ dateFormat: 'yy/mm/dd' });
    }


    /* filter group via checkbox */
    $(".group_filter").bind($.browser.msie? 'propertychange': 'change', function(e){
        val = $("#s_group").val();
        //val = val.substr(2, val.length-4);
        new_val = $(this).attr("id") + ";";
        if($(this).attr("checked")){
            val = val + "" + new_val;
            val = val.replace("  ", " ");
            $("#s_group").val(val);
        }
        else{
            if(val.indexOf(new_val, 0) >= 0){
                val = val.replace(new_val, "");
                if($.trim(val) == ""){
                    $("#s_group").val(val);
                }
                else{
                    val = val.replace("  ", " ");
                    $("#s_group").val(val);
                }
            }
        }
        /* make change of #s_group */
        //$("#s_group").trigger("keyup");
    });

    //filtering
    $("#schedule_search").click(function(){
        var hall_name = ($("#s_hall").val());
        var s_keyword = ($("#s_all").val());
        var performer = ($("#s_performer").val());
        var group     = ($("#s_group").val());
        var date_min  = ($("#s_date_min").val());
        var date_max  = ($('#s_date_max').val());

        /*$.post(
            base_url + "application/rakugo-schedule/schedule.php?action=json_calendar_events&filter=true",
            $("form#filter_calendar").serialize(),
            function(data){
                alert(data);
            }
        );*/

        $('#calendar').html("");
        $('#calendar').fullCalendar({
        	//theme: true,
        	header: {
        		left: 'prev,next today',
        		center: 'title',
        		right: 'month,agendaWeek,agendaDay'
        	},
        	//editable: true,
            header:{
                  left:   '',
                  center: 'title',
                  right:  'today prev,next'
              },
              region: fullCalendarLanguage,
        	//events: "application/rakugo-schedule/schedule.php?action=json_calendar_events&filter=true&s_hall=" + hall_name + "&s_all=" + s_keyword + "&s_performer=" + performer + "&s_group=" + group + "&s_date_min=" + date_min + "&s_date_max=" + date_max
            eventSources: [
                  // your event source
                  {
                      url: base_url + "application/rakugo-schedule/schedule.php?action=json_calendar_events&filter=true",
                      type: 'POST',
                      data: {
                          s_hall : hall_name ,
                          s_all  : s_keyword ,
                          s_performer : performer,
                          s_group : group,
                          s_date_min : date_min,
                          s_date_max : date_max
                      },
                      error: function() {
                          alert('there was an error while fetching events!');
                      }                    
                  }

                  // any other sources...

              ]
        });
        return false;

    });
     
});

function check_today_disabled(){
    if($("span.fc-button-today").hasClass("fc-state-disabled")){
        $("#today_month").addClass("disabled");
    }
    else{
        $("#today_month").removeClass("disabled");
    }
}
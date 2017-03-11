$(document).ready(function(){	
	/* filter by date: event key change hidden textbox */
    if(rLanguage == "ja"){
        $("#s_date_min").datepicker({dateFormat: 'yy年mm月dd日'});
        $("#s_date_max").datepicker({dateFormat: 'yy年mm月dd日'});
    }
    else{
        $("#s_date_min").datepicker({dateFormat: 'yy/mm/dd'});
        $("#s_date_max").datepicker({dateFormat: 'yy/mm/dd'});
    }
	
	$("#form_schedule_search").find("input").keypress(function(event){
		if(event.which == 13){
			$("#form_schedule_search").submit();	
		}
	});
	
	$("#schedule_search").click(function(){
		$("#form_schedule_search").submit();
	});
});
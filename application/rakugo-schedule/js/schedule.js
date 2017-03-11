var selected_theater = Array();
selected_theater['address'] = "";
selected_theater['reference'] = "";
selected_theater['theater_name'] = "";
selected_theater['neighborhood'] = "";
$(document).ready(function(){
    
    $("#txt_description").cleditor({
        width: 400
    });
    
    if(rLanguage == "ja"){
        $("#schedule_registration_date").datepicker({dateFormat: 'yy年mm月dd日'});
    }
    else{
        $("#schedule_registration_date").datepicker({dateFormat: 'yy/mm/dd'});
    }
    $("#schedule_registration_open_time").timeEntry($.timeEntry.regional['ja']);
    $("#schedule_registration_open_time").timeEntry('change', {show24Hours: true});
    $("#schedule_registration_finish_time").timeEntry($.timeEntry.regional['ja']);
    $("#schedule_registration_finish_time").timeEntry('change', {show24Hours: true});

    var ui_per;
    var per_selected;
    $("#schedule_registration_performers").autocomplete({
    	source: base_url + "application/rakugo-schedule/schedule.php?action=json_performers",
    	minLength: 0,        
    	select: function(event, ui ) {
            //$("ul.schedule-register-performer-list").append("<li id='" + ui.item.id + "'>" + ui.item.value + "</li>");
            per_selected = "<li onclick='select_performer(" + ui.item.id + ")' id='" + ui.item.id + "'>" + ui.item.value + "</li>";
            ui_per = ui.item.id;
    	}        
    });
        
    $("#show_all_performers").click(function(){
        //alert($("#schedule_registration_performers").autocomplete("close"));
        $("#schedule_registration_performers").autocomplete("search", " ").focus();
    });
   
    
    /*$("#schedule_registration_performers").bind($.browser.msie? 'propertychange': 'change', function(e) {
        var id = $(this).find("option:selected").attr("id");

        per_selected = "<li onclick='select_performer(" + id + ")' id='" + id + "'>" + $(this).val() + "</li>";
        ui_per = id;
    });*/

    /* Add performer to list */
    $("#add_performer").click(function(){
        if(ui_per == "error")return;
        if(per_selected){
            $("ul.schedule-register-performer-list").append(per_selected);
            per_selected = null;
            $("#schedule_registration_performers").val("");
            // Also add a hidden value to form submit for registration
            $("form#register-event").append("<input name='performers[]' type=hidden id='" + ui_per + "' value='" + ui_per + "' />");
        }
        else{
            $("#schedule_registration_performers").focus();
        }
    });

    /* delete selected performer*/
    $("#delete_performer").click(function(){
        li = $("ul.schedule-register-performer-list").find("li.current");
        li.remove();
        // Also delete a hidden value form the form submit for registration
        $("form#register-event").find("input[type=hidden]#" + li.attr("id")).remove();
    });



    /* autocomplete theatres */
    $("#schedule-registration-theaters").autocomplete({
    	source: base_url + "application/rakugo-schedule/schedule.php?action=json_theaters",
    	minLength: 1,
    	select: function( event, ui ) {
            //add reference, address,  and neighborhood station
            $("#reference").val(ui.item.ref);
            $("#address").val(ui.item.adr);
            $("#neighborhood").val(ui.item.near);
            //Add a hidden value refer to theater id
            $("form#register-event").find("input[type=hidden]#theaterid").val(ui.item.id);
            
            $("#update_theater").removeClass('focus'); 
            $("#register_theater").removeClass('focus');
            
            selected_theater['theater_name'] = ui.item.value;
            $("input.theater_items").each(function(){
                selected_theater[$(this).attr("id")] = $(this).val();
            });
    	}
    });
    
    $("#show_all_theaters").click(function(){
        //alert($("#schedule_registration_performers").autocomplete("close"));
        $("#schedule-registration-theaters").autocomplete("search", " ").focus();
    });
    
    $("#register_theater").click(function(){
        if($("#schedule-registration-theaters").val() == "") return false;
        else{
            $.jqDialog.confirm($("#confirm_sure").html(),
            /* yes */function(){
                
            //var address = document.getElementById("address").value;
            var address = document.getElementById("address").value;// + " " + document.getElementById("schedule-registration-theaters").value;
            var geocoder = new google.maps.Geocoder();
            var xx, yy;
            geocoder.geocode( {'address': address}, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    //marker = (results[0].geometry.location);
                    xx = results[0].geometry.location.lat();
                    yy = results[0].geometry.location.lng();
                } else {
                    xx = 35.68949252516748;
                    yy = 139.69170222955336;
                }
                $.post(
                    base_url + "application/rakugo-schedule/schedule.php?action=register_theater",
                    {
                        reference: $("#reference").val(),
                        name: $("#schedule-registration-theaters").val(),
                        address : $("#address").val(),
                        nearest : $("#neighborhood").val(),
                        id : $("input[type=hidden]#theaterid").val(),
                        theater_lat: xx, 
                        theater_lng: yy,
                        action: "register"
                    },
                    function(data){
                        data = data.toString().split(";");
                        alert(data[0]);
                        if(data[1] != "0"){
                            $("input[type=hidden]#theaterid").val(data[1]);
                            
                            selected_theater['address'] = $("#address").val();
                            selected_theater['reference'] = $("#reference").val();
                            selected_theater['theater_name'] = $("#schedule-registration-theaters").val();
                            selected_theater['neighborhood'] = $("#neighborhood").val();
                        }
                    }
                );
            });
                
            },
            /* no */function(){});
        }
    });
    
    $("#update_theater").click(function(){
        if($("#schedule-registration-theaters").val() == "") return false;
        else{
            $.jqDialog.confirm($("#confirm_sure").html(),
            /* yes */function(){
                $.post(
                    base_url + "application/rakugo-schedule/schedule.php?action=register_theater",
                    {
                        reference: $("#reference").val(),
                        name: $("#schedule-registration-theaters").val(),
                        address : $("#address").val(),
                        nearest : $("#neighborhood").val(),
                        id : $("input[type=hidden]#theaterid").val(),
                        action: "update"
                    },
                    function(data){
                        alert(data.toString().split(";")[0]);
                    }
                );
            },
            /* no */function(){});
        }
    });
    
    /*$("#schedule-registration-theaters").bind($.browser.msie? 'propertychange': 'change', function(e) {
        var id = $(this).find("option:selected").attr("id");
        if(id=="error"){
            $("#reference").val("");
            $("#address").val("");
            $("#neighborhood").val("");
            $("input[type=hidden]#theaterid").val("");
        }
        else{
            $("#reference").val($(this).find("option:selected").attr("ref"));
            $("#address").val($(this).find("option:selected").attr("adr"));
            $("#neighborhood").val($(this).find("option:selected").attr("near"));
            // Add a hidden value refer to theater id
            $("form#register-event").find("input[type=hidden]#theaterid").val(id);
        }
    });*/

    /* submiting the form */
    $("#register").click(function(){
        if($("input[type=text]#title").val() == ""){
            alert($("#error_title").html());
            return;
        }
        if($("ul.schedule-register-performer-list").has("li").length == 0){
            alert($("#error_performer").html());
            return;
        }
        
        var theater_changed = false;
        for(a in selected_theater){
            var input_id = a;
            if(a == 'theater_name') input_id = 'schedule-registration-theaters';
            var txt = $("#" + input_id).val();
            if(txt != selected_theater[a]){
                theater_changed = true;
            }
        }
        if(theater_changed){
            $("#update_theater").addClass('focus'); 
            $("#register_theater").addClass('focus'); 
            return;
        }
       
        
        if($("input[type=hidden]#theaterid").val() == ""){
            alert($("#error_theater").html());
            return;
        }
        
        $("form#register-event").submit();
    });

});

/* activate the clicked performer */
function select_performer(id){
    li = $("ul.schedule-register-performer-list").find("li#" + id);
    li.siblings("li").removeClass("current");
    li.addClass("current");
}
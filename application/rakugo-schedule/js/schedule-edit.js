var selected_theater = Array();
selected_theater['address'] = "";
selected_theater['reference'] = "";
selected_theater['theater_name'] = "";
selected_theater['neighborhood'] = "";
$(document).ready(function(){
        selected_theater['theater_name'] = $("#schedule-edit-theaters").val();
        $("input.theater_items").each(function(){
            selected_theater[$(this).attr("id")] = $(this).val();
        }); 
    /*
     * Make editor for description
     */
    $("#txt_description").cleditor({
        width:400
    });
    
    var language_redirect = "";
    if(rLanguage == "ja"){
        $("#schedule_edit_date").datepicker({dateFormat: 'yy年mm月dd日'});
    }
    else{
        $("#schedule_edit_date").datepicker({dateFormat: 'yy/mm/dd'});
        language_redirect = rLangage;
    }
    
     /* Delete events */
    $("#delete_schedule").click(function(){
        var id = $(this).attr("schedule");
        $.jqDialog.confirm($("#confirm_delete").val(),
        /* yes */function(){
            $.ajax({
                url: base_url + "application/rakugo-schedule/schedule.php?action=" + MD5("delete") + "&id=" + fake_url(id),
                success: function(){
                    //alert(data);
                    window.location = base_url + language_redirect;
                }
            });
        },
        /* no */function(){});
    });


    $("#schedule_edit_open_time").timeEntry($.timeEntry.regional['ja']);
    $("#schedule_edit_open_time").timeEntry('change', {show24Hours: true});
    $("#schedule_edit_finish_time").timeEntry($.timeEntry.regional['ja']);
    $("#schedule_edit_finish_time").timeEntry('change', {show24Hours: true});

    var ui_per;
    var per_selected;

    $("#schedule_edit_performers").autocomplete({
    	source: base_url + "application/rakugo-schedule/schedule.php?action=json_performers",
    	minLength: 1,
    	select: function( event, ui ) {
            per_selected = "<li onclick='select_performer(" + ui.item.id + ")' id='" + ui.item.id + "'>" + ui.item.value + "</li>";
            ui_per = ui.item.id;
    	}
    });
    
    $("#show_all_performers").click(function(){
        //alert($("#schedule_registration_performers").autocomplete("close"));
        $("#schedule_edit_performers").autocomplete("search", " ").focus();
    });

   /*$("#schedule_edit_performers").bind($.browser.msie? 'propertychange': 'change', function(e) {
        var id = $(this).find("option:selected").attr("id");

        per_selected = "<li onclick='select_performer(" + id + ")' id='" + id + "'>" + $(this).val() + "</li>";
        ui_per = id;
    });*/


    /* Add performer to list */
    $("#add_performer").click(function(){
        if(ui_per == "error")return;
        if(per_selected){
            $("ul.schedule-edit-performer-list").append(per_selected);
            per_selected = null;
            $("#schedule_edit_performers").val("");
            // Also add a hidden value to form submit for edit
            $("form#edit-event").append("<input name='performers[]' type=hidden id='" + ui_per + "' value='" + ui_per + "' />");
        }
        else{
            $("#schedule_edit_performers").focus();
        }
    });

    /* delete selected performer*/
    $("#delete_performer").click(function(){
        li = $("ul.schedule-edit-performer-list").find("li.current");
        li.remove();
        // Also delete a hidden value form the form submit for edit
        $("form#edit-event").find("input[type=hidden]#" + li.attr("id")).remove();
    });



    /* autocomplete theatres */
    $("#schedule-edit-theaters").autocomplete({
    	source: base_url + "application/rakugo-schedule/schedule.php?action=json_theaters",
    	minLength: 1,
    	select: function( event, ui ) {
            //add reference, address,  and neighborhood station
            $("#reference").val(ui.item.ref);
            $("#address").val(ui.item.adr);
            $("#neighborhood").val(ui.item.near);
            // Add a hidden value refer to theater id
            $("form#edit-event").find("input[type=hidden]#theaterid").val(ui.item.id);
            
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
        $("#schedule-edit-theaters").autocomplete("search", " ").focus();
    });
    
    $("#register_theater").click(function(){
        if($("#schedule-edit-theaters").val() == "")return;
        $.jqDialog.confirm($("#confirm_sure").html(),
        /* yes */function(){            
            var address = document.getElementById("address").value;//+ " " + document.getElementById("schedule-edit-theaters").value;
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
                        name: $("#schedule-edit-theaters").val(),
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
                        
                        $("#update_theater").removeClass('focus'); 
                        $("#register_theater").removeClass('focus');
                        
                        if(data[1] != "0"){
                            $("input[type=hidden]#theaterid").val(data[1]);
                        }
                        selected_theater['address'] = $("#address").val();
                        selected_theater['reference'] = $("#reference").val();
                        selected_theater['theater_name'] = $("#schedule-edit-theaters").val();
                        selected_theater['neighborhood'] = $("#neighborhood").val();
                    }
                );
            });
            
        },
        /* no */function(){});
    });
    $("#update_theater").click(function(){
        if($("#schedule-edit-theaters").val() == "")return;
        $.jqDialog.confirm($("#confirm_sure").html(),
        /* yes */function(){
            $.post(
                base_url + "application/rakugo-schedule/schedule.php?action=register_theater",
                {
                    reference: $("#reference").val(),
                    name: $("#schedule-edit-theaters").val(),
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
    });

    /*$("#schedule-edit-theaters").bind($.browser.msie? 'propertychange': 'change', function(e) {
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
            $("form#edit-event").find("input[type=hidden]#theaterid").val($(this).find("option:selected").attr("id"));
        }
    });*/


    /* submiting the form */
    $("#edit").click(function(){
        if($("input[type=text]#title").val() == ""){
            alert($("#error_title").html());
            return;
        }
        if($("ul.schedule-edit-performer-list").has("li").length == 0){
            alert($("#error_performer").html());
            return;
        }
        if($("input[type=hidden]#theaterid").val() == ""){
            alert($("#error_theater").html());
            return;
        }
        
        var theater_changed = false;
        for(a in selected_theater){
            var input_id = a;
            if(a == 'theater_name') input_id = 'schedule-edit-theaters';
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

        /*$.post("application/rakugo-schedule/schedule.php?action=update", $("form#edit-event").serialize(), function(data){
            //data = data.toString();
            window.location = $("#back").attr("href");
            //alert(data);
        });*/
        
        $("form#edit-event").submit();

    });

});

/* activate the clicked performer */
function select_performer(id){
    li = $("ul.schedule-edit-performer-list").find("li#" + id);
    li.siblings("li").removeClass("current");
    li.addClass("current");
}
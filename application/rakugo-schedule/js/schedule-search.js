var eList;
$(document).ready(function(){

    //clear checkbox and textbox
    $("input:checkbox").removeAttr("checked");
    $("#s_group").val("");


    show_list_data($("#event_list_content").html());


    /* search by hall: event key change */
    $("#s_hall").keyup(function(){
        //eList.fnFilter($(this).val(), 5);
    });

    /* search by performer: event key change */
    $("#s_performer").keyup(function(){
        //eList.fnFilter($(this).val(), 3);
    });

    /* search by keyword event title: event key change */
    $("#s_all").keyup(function(){
        //eList.fnFilter($(this).val(), 2);
    });

    /* filter by group: event key change hidden textbox */
    $("#s_group").keyup(function(){
        //eList.fnFilter($(this).val(), 4, true);
        //$('#s_date_min').trigger("change");
        //$('#s_date_max').trigger("change");
    });


    /* filter by date: event key change hidden textbox */
    if(rLanguage == "ja"){
        $("#s_date_min").datepicker({dateFormat: 'yy年mm月dd日'});
        $("#s_date_max").datepicker({dateFormat: 'yy年mm月dd日'});
    }
    else{
        $("#s_date_min").datepicker({dateFormat: 'yy/mm/dd'});
        $("#s_date_max").datepicker({dateFormat: 'yy/mm/dd'});
    }
    //$('#s_date_min').change( function() { eList.fnDateFilterRange($(this).val(), $('#s_date_max').val(), 0, true); } );
	//$('#s_date_max').change( function() { eList.fnDateFilterRange($('#s_date_min').val(), $(this).val(), 0, true); } );


    /* filter group via checkbox : sample regex: ^.*\b(13|24)\b.*$ */

    $(".group_filter").bind($.browser.msie? 'propertychange': 'change', function(e){

        var arr_check = [];
        var check;
        var id = $(this).attr("id");

        $(".group_filter").each(function(){
            var t_id = $(this).attr("id");
            //if(id == t_id) return;
            if($(this).attr("checked"))
                arr_check.push($(this).attr("id"));
        });

        var group_regex = ""
        var l = arr_check.length;
        for(i = 0; i < l; i++){
            if(i > 0) group_regex += "|";
            group_regex +=  arr_check[i];
        }

        /*if(i > 0) group_regex += "|";
        if($(this).attr("checked")) group_regex += $(this).attr("id");
        else group_regex = group_regex.replace($(this).attr("id"), "");*/
        group_regex = group_regex.replace("||", "|");
        l = group_regex.length;
        if(group_regex.substr(l -1) == "|"){
            group_regex = group_regex.substr(0, l-1);
        }
        l = group_regex.length;
        if(group_regex.substr(0, 1) == "|"){
            group_regex = group_regex.substr(1, l);
        }

        $("#s_group").val("^.*\\b(" + group_regex + ")\\b.*$");

        /* make change of #s_group */
        //$("#s_group").trigger("keyup");
    });

    /* make it easier for filtering via checkbox by trigger from label */
    $(".group_filter_trigger").click(function(){
        $(this).closest("tr").find("td:nth-child(1) input[type=checkbox]").trigger("click");
    });

    /* change to search when click on btn search */
    $("#schedule_search").click(function(){
        eList.fnFilter($("#s_all").val());  //start filter by all
        eList.fnFilter($("#s_hall").val(), 5);  //start filter by theater
        eList.fnFilter($("#s_performer").val(), 3);  //start filter by performer
        eList.fnFilter($("#s_group").val(), 4, true);  //start filter by group
        eList.fnDateFilterRange($("#s_date_min").val(), $('#s_date_max').val(), 0, true);   //start filter by date
    });
	
	/* imidiate search after loading page if search trigger is true which means it is being search from top page */
	if($("#search_trigger").val() == "true"){
		$("#schedule_search").trigger("click");
	}

});

function show_list_data(data){
    $("#event_list_content").html(data);
    $(".delete_schedule").click(function(){
        var id = $(this).attr("schedule");
        $.jqDialog.confirm($("#confirm_delete").html(),
        /* yes */function(){
            $.ajax({
                url: base_url + "application/rakugo-schedule/schedule.php?action=" + MD5("delete_list_row") + "&id=" + fake_url(id),
                success: function(data){
                    $("#event_list_content").html("").css("clear", "both");
                    show_list_data(data);
                }
            });
        },
        /* no */function(){}
        );
    });

    eList = $("table.rakugo").dataTable({
        "bJQueryUI": false,
        "sPaginationType": "full_numbers",
        //"bProcessing": true,
        //"sAjaxSource": "application/rakugo-schedule/schedule.php?action=json_list_events",
        "aoColumns": [
			{"bSortable": false,  "sType": "date"},
			{"bSortable": false},
			{"bSortable": false},
			{"bSortable": false},
			{"bSortable": false},
			{"bSortable": false},
			{"bSortable": false},
                        {"bSortable": true},
			{"bSortable": true,  "sType": "date"}
		],
        //"oPaginate": dataTableLanaguage,
        "oLanguage" : dataTableLanguage,
        "fnInitComplete" : function(){
            //$(".dataTables_processing").parent().hide();
        }
    });
    //eList.fnSetColumnVis( 4, false );
    
    //sorting by date
    var date_sort_type = "asc";
    $("th.sort.date").click(function(){
        eList.fnSort([[8, date_sort_type]]);
        if(date_sort_type == "asc") date_sort_type = "desc";
        else date_sort_type = "asc";
    });
    
    //sort by perform time: db curtain time
    var time_sort_type = "asc";
    $("th.sort.time").click(function(){
        eList.fnSort([[8, time_sort_type], [7, time_sort_type]]);
        if(time_sort_type == "asc") time_sort_type = "desc";
        else time_sort_type = "asc";
    });
}



$.fn.dataTableExt.oApi.fnDateFilterRange = function ( oSettings, dMinValue, dMaxValue, iColumn, iForce )
{
    if(dMinValue == null || typeof(dMinValue) == "undefined") return;
    if(dMaxValue == null || typeof(dMaxValue) == "undefined") return;
    var _dMinDate = toDate(dMinValue, rLanguage);
    var _dMaxDate = toDate(dMaxValue, rLanguage);
    this.fnDraw();

    if(_dMaxDate < _dMinDate) return;

    bSmart = false;
    bRegex = false;

	/* Now do the individual column filter */
	var iIndexCorrector = 0;

	for ( var i=oSettings.aiDisplay.length-1 ; i>=0 ; i-- )
	{
		var sData = oSettings.oApi._fnDataToSearch( oSettings.oApi._fnGetCellData( oSettings, oSettings.aiDisplay[i], iColumn, 'filter' ), oSettings.aoColumns[iColumn].sType );
        //sData = typeof sData.replace == 'function' ? sData.replace( /<.*?>/g, "" ) : sData;
        sData = typeof sData.replace == 'function' ? sData.replace(/[^-\d\.]/g, '/') : sData;
        //alert(sData);
        sData = toDate($.trim(sData), rLanguage);

        //alert(sData + ";" + _dMaxDate);
        //alert(sData > _dMaxDate || sData < _dMinDate);

		if (sData > _dMaxDate || sData < _dMinDate)
		{
			oSettings.aiDisplay.splice( i, 1 );

			iIndexCorrector++;
		}
	}


	/* Tell the draw function we have been filtering */
	oSettings.bFiltered = true;

	/* Redraw the table */
	oSettings._iDisplayStart = 0;
	oSettings.oApi._fnCalculateEnd( oSettings );
	oSettings.oApi._fnDraw( oSettings );

	/* Rebuild search array 'offline' */
	oSettings.oApi._fnBuildSearchArray( oSettings, 0 );
}

$(document).ready(function(){
    $("table.rakugo.schedule-list").dataTable({
        "bJQueryUI": false,
        "sPaginationType": "full_numbers",
        //"bProcessing": true,
        //"sAjaxSource": "application/rakugo-schedule/schedule.php?action=json_list_events",
        "aoColumns": [
			{ "bSortable": false },
			{ "bSortable": false },
			{ "bSortable": false },
			{ "bSortable": false },
			{ "bSortable": false },
			{ "bSortable": false }
		],
        //"oPaginate": dataTableLanaguage,
        "oLanguage" : dataTableLanguage,
        "fnInitComplete" : function(){
            //$(".dataTables_processing").parent().hide();
        }
    });
    $("td.tdPickup").live('click', function(event) {
    	if (event.target.type !== 'radio') {
        	$(':radio', this).trigger('click');
        }
    });


});
// For Performer List
$(document).ready(function() {
				oTable = $('#ipickupperformerlist').dataTable({
					//"bJQueryUI": true,
					"sPaginationType": "full_numbers",
					//RUN
					//"aLengthMenu": [[1, 5, 10, 20, 50, -1], [1, 5, 10, 20, 50, "All"]],
					"iDisplayLength": 10,
					//"sDom": 'ftip',
					"oLanguage": dataTableLanguage
					//end RUN
				});

				//$('div#txt_search').html($('.dataTables_filter'));

                /* datatable function use to search for all field */
                $("div.btn_search").click(function(){
                    oTable.fnFilter($("#search_performer").val());
                });
				/*
				$("#ipickupperformerlist tbody tr").live('click', function(event) {
					per_id = $(this).attr('id');
					//alert(per_id);
					window.location.href = "?page=perprofile&perid="+ per_id;
				});
				*/
				
				/* filter by group: event key change */
				$("#sGroupSearch").keyup(function(){
					oTable.fnFilter($(this).val(), 4, true);
				});
			
				/* filter group via checkbox */
				$(".group_filter").change(function(){
					val = $("#sGroupSearch").val();
					val = val.substr(2, val.length-4);
					new_val = $(this).attr("id");
					if($(this).attr("checked")){
						val = val + " " + new_val;
						val = "^[" + val.replace("  ", " ") + "]$";
						$("#sGroupSearch").val(val);
					}
					else{
						if(val.indexOf(new_val, 0) > 0){
							val = val.replace(new_val, "");
							if(val.trim() == ""){
								$("#sGroupSearch").val(val);
							}
							else{
								val = "^[" + val.replace("  ", " ") + "]$";
								$("#sGroupSearch").val(val);
							}
						}
					}
					/* make change of #sGroupSearch */
					$("#sGroupSearch").trigger("keyup");
				});
				
				//Postion Search******************************
				/* filter by group: event key change */
				$("#sPositionSearch").keyup(function(){
					oTable.fnFilter($(this).val(), 5, true);
				});
			
				/* filter group via checkbox */
				$(".position_filter").change(function(){
					val = $("#sPositionSearch").val();
					val = val.substr(2, val.length-4);
					new_val = $(this).attr("id");
					if($(this).attr("checked")){
						val = val + " " + new_val;
						val = "^[" + val.replace("  ", " ") + "]$";
						$("#sPositionSearch").val(val);
					}
					else{
						if(val.indexOf(new_val, 0) > 0){
							val = val.replace(new_val, "");
							if(val.trim() == ""){
								$("#sPositionSearch").val(val);
							}
							else{
								val = "^[" + val.replace("  ", " ") + "]$";
								$("#sPositionSearch").val(val);
							}
						}
					}
					/* make change of #sPositionSearch */
					$("#sPositionSearch").trigger("keyup");
				});
				//end Postion Search******************************
				/* make it easier for filtering via checkbox by trigger from label */
				/*
    			$('td.radio_action').click(function(event) {
    				if (event.target.type !== 'radio') {
      					$(':radio', this).trigger('click');
    				}
  				});
				*/
				
				$("td.radio_action").live('click', function(event) {
					if (event.target.type !== 'radio') {
      					$(':radio', this).trigger('click');
    				}
				});
} );//end doc ready
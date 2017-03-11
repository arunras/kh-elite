// For Performer List
$(document).ready(function() {
				oTable = $('#ilistperformer').dataTable({
					//"bJQueryUI": true,
					"sPaginationType": "full_numbers",
					//RUN
					//"aLengthMenu": [[1, 5, 10, 20, 50, -1], [1, 5, 10, 20, 50, "All"]],
					"iDisplayLength": 10,
					//"sDom": 'ftip',
					"oLanguage": dataTableLanguage
					//"oPaginate": dataTableLanaguage,
					//end RUN
				});

				$('div#txt_search').html($('.dataTables_filter'));

                /* datatable function use to search for all field */
                $("div.btn_search").click(function(){
                    oTable.fnFilter($("#search_performer").val());
					oTable.fnFilter($("#isGroupSearch").val(), 4, true);  //start filter by group
					oTable.fnFilter($("#isPositionSearch").val(), 5, true);
					//isGroupSearch
                });

				$("#ilistperformer tbody tr").live('click', function(event) {
					per_id = $(this).attr('id');
					//alert(per_id);
					if(per_id){
					window.location.href = "?page=perprofile&perid="+ per_id;
					}
				});
				
				
				/* filter by group: event key change */
				/*
				$("#sGroupSearch").keyup(function(){
					oTable.fnFilter($(this).val(), 4, true);
				});
				*/
				// filter Group
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
					if(!$(this).attr("checked")) group_regex += $(this).attr("id");
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
			
					$("#isGroupSearch").val("^.*\\b(" + group_regex + ")\\b.*$");
			
					/* make change of #s_group */
					//$("#s_group").trigger("keyup");
				});
				
				
				//Postion Search******************************
				$(".position_filter").bind($.browser.msie? 'propertychange': 'change', function(e){
					var arr_check = [];
					var check;
					var id = $(this).attr("id");
			
					$(".position_filter").each(function(){
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

					group_regex = group_regex.replace("||", "|");
					l = group_regex.length;
					if(group_regex.substr(l -1) == "|"){
						group_regex = group_regex.substr(0, l-1);
					}
					l = group_regex.length;
					if(group_regex.substr(0, 1) == "|"){
						group_regex = group_regex.substr(1, l);
					}
			
					$("#isPositionSearch").val("^.*\\b(" + group_regex + ")\\b.*$");
			
					/* make change of #s_group */
					//$("#s_group").trigger("keyup");
				});
				//end Postion Search******************************
				/* make it easier for filtering via checkbox by trigger from label */
    			$('td div.narrow').click(function(event) {
    				if (event.target.type !== 'checkbox') {
      					$(':checkbox', this).trigger('click');
    				}
  				});
				
} );//end doc ready
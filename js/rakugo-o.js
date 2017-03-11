
var id_checkbox ="";

/* add item */
function add_item(type_view) {
	
	 var val_item= new Array();
	
	if(type_view =='theater') {
	    	$('.o_text_input').each(function() {	
			val_item.push($(this).val());
		});
                
		if(val_item[0]!="" && (val_item[1]!=""||val_item[2]!=""||val_item[3]!=""|| val_item[4]!="")){
                        var address = val_item[1];// + " " + val_item[0];
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
                                //alert("Geocode was not successful for the following reason: " + status);
                            }
                            val_item.push(xx);
                            val_item.push(yy);
                            
                            $.ajax({
						url:base_url + "application/master_table/master_table.php?action=insert&type="+type_view,
						type: "POST",
						data: {
								val_item1: val_item[0],
								val_item2: val_item[1],
								val_item3: val_item[2],
								val_item4: val_item[3],
								val_item5: val_item[4],
                                                                val_item6: val_item[5],
                                                                val_item7: val_item[6]
								},
						 success: function(data){
                                                        if(data=='error') {
                                                            alert($('#data_exist').html());
                                                            return;
                                                        }
							 $('table#insert').append(data);
							 $('#t_g_id').val($('table#insert').find('tr:last td input[type=checkbox]').attr('id'));
							 $('form#upload_pic').submit();
						 }
				});
                            
                            });

			
			}
                       
	}
        
	else if(type_view=='group') {
		$('.o_text_input').each(function() {val_item.push($(this).val());});
		
		if(val_item[0]!=""){
		$.ajax({
						url:base_url + "application/master_table/master_table.php?action=insert&type="+type_view,
						type: "POST",
						data: {
								val_item1: val_item[0],
								val_item2: val_item[1]
								},
						 success: function(data){
                                                       if(data=='error') {
                                                            alert($('#data_exist').html());
                                                            return;
                                                        }
							 $('table#insert').append(data);
						
							 $('#t_g_id').val($('table#insert').find('tr:last td input[type=checkbox]').attr('id'));
							 $('form#upload_pic').submit();
						 }
						});
		 	}
	}
	 else {
		var val_name = $('.o_text_input').val();
	  	if(val_name!='') {
		  
		  $.ajax({
			  
						url:base_url + "application/master_table/master_table.php?action=insert&type="+type_view,
						type: "POST",
						data: {
							val_name: val_name
								},
						 success: function(data){
                                                        if(data=='error') {
                                                            alert($('#data_exist').html());
                                                            return;
                                                        }
							 $('table#insert').append(data);
						
							 $('#t_g_id').val($('table#insert').find('tr:last td input[type=checkbox]').attr('id'));
							 $('form#upload_pic').submit();
						 }				
	  	}); 
	   }	
	 }
}

/* delete item */
function delete_item(type) {
        if($("table#insert").find("td.checkbox_choice input[type=checkbox]:checked").length == 0) {
            return;
        }
       $.jqDialog.confirm($("#message_confirm").html(),
            /* yes */function(){ 
            $("table#insert").find("td.checkbox_choice input[type=checkbox]:checked").each(function(){		
		
		$(this).closest("tr").remove();
		  $.ajax({
	  			url:base_url +"application/master_table/master_table.php?val_id=" + $(this).attr("id")+"&action=delete&type="+type,
	  			success: function(data) {
                                    clear_input();
	  				}
	  	  });
                });
            },
            /* no */function(){})
}

/* load data to edit when click on checkbox */
$(document).ready(function(){
		
	var browser = $.browser;
  	var ielt9 = (browser.msie && (parseInt(browser.version) <9));
        
	$("td.checkbox_choice input[type=checkbox]").bind(ielt9 ? 'propertychange': 'change', function(e){
	
		if($(this).is(':checked')==false) {		
			id_checkbox = "";
			clear_input();
			return;
			}
			
		var i = 0;		
		id_checkbox = $(this).attr('id');
          
                if($(this).closest("tr").find("td.show_top_checkbox input").attr('checked')){
                    $('.input_show_top').find('input').attr('checked','checked');
                }
                else { $('.input_show_top').find('input').removeAttr('checked'); }
		$(this).closest("tr").find("td").each(function(){
			i++;
			
			var val = $(this).html().replace(/<\/?[^>]+>/gi,'');	
				
				if(i>=3 && i<($(this).siblings('td').length + 1)) {
				   val = $(this).next().html().replace(/<\/?[^>]+>/gi,'');	
				 }
			$("table#input_value tr td:nth-child(" + (i-1) + ")").find("table tr:nth-child(2) td input").val(val);				
		});
                 
            } 
	);
            
        /* sort */
        eList = $("table#insert").dataTable({
        "bJQueryUI": false,
        "sPaginationType": "full_numbers",
        "aoColumnDefs": [
            { "bSortable": true, "aTargets" : [1] },           
        ],
        //"bProcessing": true,
        //"sAjaxSource": "application/rakugo-schedule/schedule.php?action=json_list_events",
        
        //"oPaginate": dataTableLanaguage,
        "oLanguage" : dataTableLanguage,
        "fnInitComplete" : function(){
            //$(".dataTables_processing").parent().hide();
        }
    });
	/* end sort */
});

/* edit item */
 function edit_item(type) {

	var edit_val = new Array();
	$('.o_text_input').each(function() {edit_val.push($(this).val());});
	edit_val.push(id_checkbox);

	if(type=='theater') {	
                
		if(edit_val[0]!="" && edit_val[5]!="" && (edit_val[1]!=""||edit_val[2]!=""||edit_val[3]!=""|| edit_val[4]!="" )){
                    var address = edit_val[1];// + " " + edit_val[0] ;
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
                                    //alert("Geocode was not successful for the following reason: " + status);
                                }
                    edit_val.push(xx);
                    edit_val.push(yy);
                   
 
                                $.ajax({
						url:base_url + "application/master_table/master_table.php?action=edit&type="+type,
						type: "POST",
						data: {
								edit_name: edit_val[0],
								edit_address: edit_val[1],
								edit_phone: edit_val[2],
								edit_nearest: edit_val[3],
								edit_url: edit_val[4],
								edit_id: edit_val[5],
                                                                edit_latitude: edit_val[6],
                                                                edit_longitude: edit_val[7]
                                                             
								},
						 success: function(data){
                                                    
							if(data=='error') {
                                                            alert($('#data_exist').html());
                                                            return;
                                                        }
							$('#t_g_id').val(edit_val[5]);
							$('form#upload_pic').submit();
						 }
				});
                            });
			
			}
	}
	else if(type=='group') {
		
		if(edit_val[0]!="" && edit_val[2]!=""){
			
			$.ajax({
						url:base_url + "application/master_table/master_table.php?action=edit&type="+type,
						type: "POST",
						data: {
								edit_name: edit_val[0],
								edit_url: edit_val[1],
								edit_id: edit_val[2]
								
								},
						 success: function(data){
                                                        if(data=='error') {
                                                            alert($('#data_exist').html());
                                                            return;
                                                        }
							 $('#t_g_id').val(edit_val[2]);
							 $('form#upload_pic').submit();
						 }
				});
			}
	}
	else {
		if(edit_val[0]!="" ){
			$.ajax({
						url:base_url + "application/master_table/master_table.php?action=edit&type="+type,
						type: "POST",
						data: {
								edit_name: edit_val[0],
								edit_id: edit_val[1]
								},
						 success: function(data){
                                                     
                                                        if(data=='error') {
                                                            alert($('#data_exist').html());
                                                            return;
                                                        }
							 window.location.reload();
						 }
				});
			}
	}
	
} 
function clear_input(){
    $("table#input_value tr td table tr:nth-child(2) td" ).find("input").val('');	
    $('.input_show_top').find('input').removeAttr('checked');
}

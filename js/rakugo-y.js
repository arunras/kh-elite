function deletePickup(pickup_id){
	$.jqDialog.confirm($("#confirm_delete").val(),
     	/* yes */
		function(){
        	$.ajax({
				url: base_url +  'application/rakugo-pickup/php_sub/r_pickupdelete.php?pickupid=' + pickup_id,
				success: function(data){
					$('label#reg1.pickup_title' + pickup_id).remove();
					$('label#comment1.commentdel' + pickup_id).remove();
				}	
			});
        },
        /* no */
		function(){});
}

function pickup_choice(){
$.post('',function(result){
				   
				   
				   
});	
}


$(document).ready(function(){
    $("table.rakugo.schedule-list input[type=radio]").click(function(){
//declear var "title" to get value from class "this" that point to "tr" that radion stay in and find "td" in "tr" use "td:nth-child(index of td)" and find "a" in "td" and to find "text" in "a" use method "html()".
		var title = $(this).closest("tr").find("td:nth-child(4) a").html();
		var per_title = $(this).closest("tr").find("td:nth-child(2)").html();
		var per_id = $(this).closest("tr").find("td input[type=radio]").attr('id');
		var ssource_id = $(this).closest("tr").find("td:nth-child(1) input[type=radio]").attr('id');
		
		//var sper_id = $(this).closest("tr").find("td:nth-child(5) a.iperformerid").attr('id');
		
		//Schedule
		 $('td label#reg').html(title);	
		 $('td input[type=hidden]#ipickup_title').val(title);	
		 $('td label#ilbl_performername').html(per_title);
		 $('td input[type=hidden]#isperid').val(ssource_id);
		 
		 //Performer
		 $('td input[type=hidden]#ipickup_pername').val(per_title);
		 $('td input[type=hidden]#iperid').val(per_id);
	
	});	
});

function load_hash_change_y(hash){
    result = false;
    /*
    * use this hash variable to determine what to do like which page to load or sth
    * e.g.
    * switch(hash){
    *   case "a": do_sth(); resutl = true; break;
    *   case "b": do_other_thing(); result = true; break;
    *   default: result = false; break;
    * }
    * ref: rakugo-k.js
    */
    hash = hash.split("/");
    switch(hash[0]){
        case "pickup" :
            if(!hash[1]){
                load_pickup_home();
            }
            else{
                switch(hash[1]){
                    case "performer" : load_pickup_performer(hash[2]); break; // url call: http://(domain)/#pickup/performer/1
                    case "schedule" : load_pickup_schedule(hash[2]); break; // url call: http://(domain)/#pickup/schedule/2
                    default: break;
                    /*
                     * Notes: the last value in the url is the value of pick up order.
                     * It can be 1, 2, or 3 which refere to pickup row in page pickup home(WF-201).
                     */
                }
            }
            break;
        case "inquiry" :
            //Put your code here
            break;
    }

    return result;
}
/*
 * Load pick up home (WF-201) via ajax
 */
function load_pickup_performer(pickup_index){
    $.ajax({
        url: base_url +  "application/rakugo-pickup/pickup_home.php",
        success: function(data){
            
        }
    });
}
/*
 * Load pick up home (WF-201) via ajax
 */
function load_pickup_schedule(pickup_index){
}/*
 * Load pick up home (WF-201) via ajax
 */
function load_pickup_home(){
}
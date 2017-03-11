/*==Performer Management===============================================================================================================*/
//Performer Management Occupation Update
function update_occupation(per_id, id){
	//alert(id);	
	$.ajax({
		url: base_url + 'application/performer/php_sub/r_occupationedit.php?action=occupationedit&perid=' + per_id + '&occupationid=' + id,
		success: function(data){}	
	});
}
//Performer Management TeiSuffix Update
function update_teisuffix(per_id, id){
	//alert(id);	
	$.ajax({
		url: base_url + 'application/performer/php_sub/r_teisuffixedit.php?action=teisuffixedit&perid=' + per_id + '&teisuffixid=' + id,
		success: function(data){}	
	});
}

//Performer Management Occupation Update
function update_position(per_id, id){
	//alert(id);	
	$.ajax({
		url: base_url + 'application/performer/php_sub/r_positionedit.php?action=positionedit&perid=' + per_id + '&positionid=' + id,
		success: function(data){}	
	});
}

function delete_performer(per_id){
	 $.jqDialog.confirm($("#confirm_delete").val(),
        /* yes */function(){
            $.ajax({
                url: base_url + 'application/performer/php_sub/r_deleteperformer.php?action=performerdelete&perid=' + per_id,
				success: function(data){
					window.location.reload();
				}
            });
        },
        /* no */function(){});
}
/*==Performer Management===============================================================================================================*/

function load_hash_change_r(hash){
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
	hash = hash.split("/"); //try adding #shedule_detail/1 to the url
    switch(hash[0]){
        case "perregistration" : load_formPerRegistration(); break;//load_schedule_detail(hash[1]);
		case "userprofile" : load_userprofile(); break;
		case "listperformer" : load_listperformer(); break;
    }
    return result;
}

//Registration
function load_formPerRegistration(){
	$.ajax({
		url: base_url + 'application/performer/performer.php?action=perregistration',
		success: function(data){
			$("div#rakugo-content").html(data);	
			$('#iname').focus();	
		}	
	});
}

//User Profile
function load_userprofile(){
	$.ajax({
		url: base_url +  'application/performer/performer.php?action=userprofile',
		success: function(data){
			$("div#rakugo-content").html(data);		
		}	
	});
}

//User List Performers
function load_listperformer(){
	$.ajax({
		url: base_url +  'application/performer/run_listperformer.php?action=listperformer',
		success: function(data){
			$("div#rakugo-content").html(data);
		}	
	});
}

//Add new performer
function add_newperformer(){
	//$('span#topic_adding').html('<img  src="images/progress.gif" height="20px"/>');
    $.post(
		base_url + 'application/performer/performer.php?action=newperformer', 
		$("form#form_newperformer").serialize(), 
		function(data) {}
	);
	alert('New Performer is not done!');
}

/*
function ab(){
	sethash('PerRegistration');	
}
*/


    /* filter by group: event key change */
    $("#sGroupSearch").keyup(function(){
        eList.fnFilter($(this).val(), 4);
    });

    /* filter group via checkbox */
    $(".group_filter").change(function(){
        val = $("#sGroupSearch").val();
        new_val = $(this).attr("id");
        if($(this).attr("checked")){
            val = val + " " + new_val;
            val = val.replace("  ", " ");
            $("#sGroupSearch").val(val);
        }
        else{
            if(val.indexOf(new_val, 0) > 0){
                val = val.replace(new_val, "");
                val = val.replace("  ", " ");
                $("#sGroupSearch").val(val);
            }
        }
        /* make change of #sGroupSearch */
        $("#sGroupSearch").trigger("keyup");
    });
function formPerEditCancel(per_id)
{
	window.location.href= "?page=perprofile&perid=" + per_id;
}
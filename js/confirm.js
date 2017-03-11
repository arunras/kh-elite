function confirm(){
	
$.post("application/rakugo-pickup/form_send.php", $("form#formid").serialize(), function(result){
	if(result="ture"){		
	alert($('span#show_sucess').html('Success'));		
		}
return false;
																
});

}
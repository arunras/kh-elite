
  $(document).ready(function(){
	//New Registration
    $("#iform_newperformer").validate({
		rules:{
			pername: 'required',
			perurl: 'url',
			peremail: 'required email',
			perpassword: 'required',
			perconfirm:{ equalTo: '#ipassword'}
			/*
			yyyy: 'required',
			mm: 'required',
			dd: 'required',
			*/
			//perpicture: 'required',
			//perhometown: 'required',
			//pergroup: 'required',
			//perteacher: 'required',
			//persong: 'required',
			//perstory: 'required',
		}
	});
	
	jQuery.extend(jQuery.validator.messages,{
		required: $('div.Lmessages span#ismsrequired').html(),
		email: $('div.Lmessages span#ismsemail').html(),
		url: $('div.Lmessages span#ismsurl').html(),
		equalTo: $('div.Lmessages span#ismsequalTo').html()
		//minlength: "*"
	});
	
	//Edit Profile
	$("#iform_editperformer").validate({
		rules:{
			pername: 'required',
			perurl: 'url',
			peremail: 'required email',
			//perpassword: 'required',
			perconfirm:{ equalTo: '#ipassword'}
			/*
			yyyy: 'required',
			mm: 'required',
			dd: 'required',
			*/
			//perpicture: 'required',
			//perhometown: 'required',
			//pergroup: 'required',
			//perteacher: 'required',
			//persong: 'required',
			//perstory: 'required',
		}	
	});
	
	
	
	$("#iform_passwordedit").validate({
		rules:{
			//percurrentpassword: 'required',
			
			pernewpassword: 'required',
			pernewconfirm:{ equalTo: '#inewpassword'}
		}	
	});	
  });
	//File Upload  
	function file_validation(){
		filename = $('#perpicture').val();
		filelength = parseInt(filename.length)-3;
		fileext = filename.substring(filelength, filelength+3);
		fileext = fileext.toLowerCase(fileext);
		
		if(fileext=='jpg' || fileext=='jpeg' || fileext=='png' || fileext=='gif' || fileext==''){
			return true;	
		}
		else{
			alert($('div.Lmessages span#iuploadfilevalidate').html());
			return false;
		}
		//allowtype=array("jpg","jpeg","gif","png");  
	}

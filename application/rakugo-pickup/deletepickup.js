// JavaScript Document
function delpickup1(){	
    //for pickup 1
	var reg1=document.getElementById('reg1');
	var comment1=document.getElementById('comment1');	
	var str=$('td label#reg1').val();
	if(str==""){
		alert("No data for delete!");		
	}
		else{
	var remElement = (reg1.parentNode).removeChild(reg1);
	var remElement = (comment1.parentNode).removeChild(comment1);	
		}
	}
	function delpickup2(){		
	 //for pickup 2
	var reg2=document.getElementById('reg2');
	var comment2=document.getElementById('comment2');
	var remElement = (reg2.parentNode).removeChild(reg2);
	var remElement = (comment2.parentNode).removeChild(comment2);
	
	}
	
	function delpickup3(){	
	
	 //for pickup 3
	var reg3=document.getElementById('reg3');
	var comment3=document.getElementById('comment3');
	var remElement = (reg3.parentNode).removeChild(reg3);
	var remElement = (comment3.parentNode).removeChild(comment3);
	
	}
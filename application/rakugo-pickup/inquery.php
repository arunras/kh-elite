<?php
/*
require_once($_SERVER['DOCUMENT_ROOT']."/rakugo/module/module.php");
if(getCurrentUser()==0){exit();	}	
*/
//Imports
echo '<script src="'.HTTP_DOMAIN.'application/_formvalidation/js/jquery-latest.js"></script>';
echo '<script type="text/javascript" src="'.HTTP_DOMAIN.'application/_formvalidation/js/jquery.validate.js"></script>';
echo '<link type="text/css" rel="stylesheet" href="'.HTTP_DOMAIN.'application/_formvalidation/css/s_formvalidation.css">';
echo '<link type="text/css" rel="stylesheet" href="'.HTTP_DOMAIN.'application/rakugo-pickup/css/confirm.css">';
//End Imports
?>
<script>
  $(document).ready(function(){
    $("#iform_inquery").validate({
		rules:{
			first_name: 'required',
			last_name: 'required',
			say: 'required',
			may: 'required',
			comment: 'required',
			email: 'required email'
		}	
	});
	
	jQuery.extend(jQuery.validator.messages,{
		required: $('div.Lmessages span#ismsrequired').html(),
	});
  });
function sendInquery()
	{
		$('form#iform_inquery').submit();
		//window.location.href="http://camitss.com/rakugo/";
	}
function endMailSuccess(){
		<?php if($_SESSION['language_selected']=='ja'){$_SESSION['language_selected']='';}?>
		window.location.href="?page=index";
		//header('Location:../../../'.$_SESSION['language_selected'].'?page=perprofile&perid='.$per_id);
	}
</script>

<div id="confirm_wrapper">
	<img src="<?php echo HTTP_DOMAIN; ?>images/button_rakugo/title_inq.png"  />
      		<form action="?page=send" method="post" name="formid" id="iform_inquery" target="sendmailsuccess">                  
      			  <table cellpadding="6px" align="center">
        			 <tr>
            			  <td style="width:30px;">
                	          <label for="txtname"><?php echo $rLanguage->text("Name");?></label>
                          </td>                          
               			  <td style="width:40px; border-right: none; ">
                        	  <div class="label-text"><?php echo $rLanguage->text("firt name(chinese)");?></div>
                           </td>
                           <td style="border-left: none;">
                		      <input type="text" style="width:100%;"  class="text" id="first_name" name="first_name" />
                           </td>
                          
                		   <td style="width:40px; border-right: none;">
                             <div class="label-text"><?php echo $rLanguage->text("last name(chinese)");?></div>
                           </td>
                           <td style="border-left: none;">
                             <input type="text" style="width:100%;" class="text" id="last_name" name="last_name" />
                           </td>
            		     </tr>
            
            		    <tr>
            			 <td style="width:30px;">
                			<label for="txtname"><?php echo $rLanguage->text("name(furigana)");?></label>
                         </td>
                		 <td style="width:40px;  border-right: none;">
                           <div class="label-text"><?php echo $rLanguage->text("first name(japanese)");?></div>
                            </td>
                            <td style="border-left: none;">
                			<input type="text" style="width:100%;"  class="text" id="txtsay" name="say" />
                         </td>
                		<td style="width:40px; border-right: none;">
                            <div class="label-text"><?php echo $rLanguage->text("last name(japanese)");?></div>
                            </td>
                            <td  style="border-left: none;">
                			<input type="text" style="width:100%;"  class="text" id="txtmay" name="may"/>
                        </td>
            		 </tr>
            
            		 <tr >
            			<td style="width:30px;">
                			<label for="txtname"><?php echo $rLanguage->text("e-mail address");?></label>
                        </td>
                		<td colspan="4" >
                		   <input type="text" class="text" id="email" name="email" style="width:100%">
               			</td>
           		    </tr>
            
            	   <tr>
            			<td style="vertical-align:top">
                		    <label for="txtname"><?php echo $rLanguage->text("inquiry contents");?></label>
                        </td>
               		    <td  colspan="4" style="padding-right:24px;">
                		    <textarea  name="comment" id="comment" rows="8" cols="80"  style="resize:none;"> </textarea>
                 	    </td>
          	       </tr>                	     
       		 </table>
			<table border="0px" align="center" style="border: none;">           
           <tr>
             <td align="center" style="padding-left: 220px; border: none;">
             	<!--
               	<input type="submit" value="Submit"/>
                -->
                <!--
                <div class="btn_send pink" style="float: left; margin-top: 5px; width: 110px;" onclick="saveInquery()"><label style="width: 80px;"></label><span></span></div>
                -->
                <div class="btn_send pink" style="float: left; margin-bottom: 20px;" onclick="sendInquery()"></div>
                <span id='show_sucess' style="margin-left:0px;"></span>
             </td>
           </tr>          
           </table>
     </form> 
     <iframe id="sendmailsuccess" name="sendmailsuccess" style="display:none;"></iframe>
<?php
	echo '<div class="Lmessages">';
			echo '<span id="ismsrequired">'.$rLanguage->text("This field is required").'</span>';
	echo '</div>';
?>	 
	     
</div>

   
      
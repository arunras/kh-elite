<?php
if(!defined(per_sub_path))define("per_sub_path",dirname(dirname(dirname(__FILE__))));
require_once(per_sub_path . "/module/module.php");
//require_once($_SERVER['DOCUMENT_ROOT']."/". ROOT. "/module/module.php");
if(getCurrentUser()==0 || getUserType()!=ADMINISTRATOR){	
	echo '<script type="text/javascript">';
		echo 'window.location.href="?page=index"';
	echo '</script>';
	exit();
	//require_once($_SERVER['DOCUMENT_ROOT'] . "/rakugo/include/hacker.php");
}
?>

    <link rel="stylesheet" type="text/css" href="application/_editor/jquery.cleditor.css" />
    <script type="text/javascript" src="application/_editor/jquery.cleditor.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function() {
        $("#ipickup_comment").cleditor({width:390, height:150,});
		
		$('td.radio_action').click(function(event) {
    				if (event.target.type !== 'radio') {
      					$(':radio', this).trigger('click');
    				}
  				});
      });
	  function backToPickup()
	  {
			window.location.href='?page=pickup';
	  }
	  
	  function saveEvent()
	  {
			
			var title = $('#reg').html();
	  		if(title!=''){
				$('form#myForm').submit();  
			}
			else{
				alert('Please select item!');	
			}	
	  }
    </script>
<style type="text/css">
td.radio_action:hover
{
	background-color: #CCC;
	cursor: pointer;
}
</style>
<h2 style="margin-left:90px"><?php echo $rLanguage->text("Pickup Schedule");?></h2>
<?php
	$pickup_id = $_GET['pickupid'];
	$event_id = getValue("SELECT source_id FROM tbl_pickup WHERE pickup_id=".$pickup_id." AND source_type='event'");
	$pickup_comment = getValue("SELECT pickup_comment FROM tbl_pickup WHERE pickup_id=".$pickup_id);
	$pickup_title = getValue("SELECT pickup_title FROM tbl_pickup WHERE pickup_id=".$pickup_id);
	require_once($_SERVER['DOCUMENT_ROOT'] . "/". ROOT. "/application/rakugo-schedule/class/schedule.class.php");
	$event = new schedule($event_id);
?>
<table border="0" width="1080px" bgcolor="white" style="vertical-align:top">
	<tr>
	<td>
		<form name="myForm" id="myForm" action="<?php echo HTTP_DOMAIN;?>application/rakugo-pickup/php_sub/r_pickupedit.php" method="post">
			<table border="0" style="margin-left:90px"  width="850px" cellpadding="5">
					<tr bgcolor="#A1A012">
    					<th class="border-right-doth border-bottom-doth" width="15%" align="center" bgcolor="white"></th>
        				<th style="border-right:solid white "  width="30%" align="center"><?php echo $rLanguage->text("Registration Name");?></th>
        				<th style="border-right:solid white" width="35%" align="center"><?php echo $rLanguage->text("Pickup comment");?></th>
        				<th class="border-right-doth border-bottom-doth" width="35%" align="center"><?php echo $rLanguage->text("Operation");?></th>
    				</tr>
    				<tr bgcolor="#E6E6FA">
    					<td class="border-right-doth border-bottom-doth" width="20%" align="center" bgcolor="#A1A012"><?php echo $rLanguage->text("Pickup").$pickup_id;?></td>
        			    <td class="border-right-doth border-bottom-doth" width="30%"><label for="reg" id="reg" name="reg"><?php echo $pickup_title; ?></label></td>
        				<td class="border-right-doth border-bottom-doth" width="35%">
                        	<input type="hidden" name="pickupid" value="<?php echo $pickup_id;?>"/>
                        	<input type="hidden" name="pickup_title" id="ipickup_title" value="<?php echo $event->getValue("event_title"); ?>"/>
                            <input type="hidden" name="sourceid" id="isperid" value="<?php echo $event->getValue("event_id");?>"/>
                            <input type="hidden" name="sourcetype" id="isourcetype" value="event"/>
                        	<textarea name="pickup_comment" id="ipickup_comment"><?php echo $pickup_comment;?></textarea>                      
                       	</td>
        				<td class="border-right-doth border-bottom-doth" width="25%" bgcolor="#A1A012">
                        	<!--
                        	<input type="submit" name="btn_submit" value="Save"/>
                            <a href="?page=pickup">Back</a>
                            -->
                        <div class="button pink" style="float: left; margin-top: 5px; width: 110px;border-radius: 5px; -moz-border-radius: 5px; -webkit-border-radius: 5px;  border: 2px #FFF solid;" onclick="saveEvent()"><label style="width: 80px;"><?php echo $rLanguage->text("Save");?></label><span></span></div>
                        <div class="button pink" style="float: left; margin-top: 5px; width: 110px;border-radius: 5px; -moz-border-radius: 5px; -webkit-border-radius: 5px;  border: 2px #FFF solid;" onclick="backToPickup()"><label style="width: 80px;"><?php echo $rLanguage->text("Back");?></label><span></span></div>
								 
                       	</td>
    				</tr>
    
			</table>
		</form>
      </td>
   </tr>
	<tr>
		<td height="45px">
		
		</td>
    </tr>
</table>
<?php
	include($_SERVER['DOCUMENT_ROOT'] . ROOT . "/application/rakugo-schedule/schedule.php");
?>
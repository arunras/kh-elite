<?php
	ob_start();
    if(!isset($_SESSION))session_start();
	
	if(!defined("per_sub_path"))define("per_sub_path",dirname(dirname(dirname(__FILE__))));
	require_once(per_sub_path . "/module/module.php");
	//require_once($_SERVER['DOCUMENT_ROOT']."/". ROOT. "/module/module.php");
	
	if(getCurrentUser()==0 || (getCurrentUser()!=$_GET['perid'] && getUserType()!=ADMINISTRATOR)){ //getCurrentUser()!=$_GET['perid'] ||	
		//require_once($_SERVER['DOCUMENT_ROOT'] . "/rakugo/include/hacker.php");
		echo '<script type="text/javascript">';
			echo 'window.location.href="?page=index"';
		echo '</script>';
		exit();
	}
?>
<script src="<?php echo HTTP_DOMAIN;?>application/_formvalidation/js/jquery-latest.js"></script>
<script type="text/javascript" src="<?php echo HTTP_DOMAIN;?>application/_formvalidation/js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo HTTP_DOMAIN;?>application/_formvalidation/js/run_formvalidation.js"></script>

<script type="text/javascript" src="<?php echo HTTP_DOMAIN;?>application/performer/js/birthdate_edit.js"></script>
<link type="text/css" rel="stylesheet" href="<?php echo HTTP_DOMAIN;?>application/_formvalidation/css/s_formvalidation.css">
<link rel="stylesheet" href="<?php echo HTTP_DOMAIN;?>application/performer/css/s_performer.css" type="text/css" />
<script type="text/javascript">
	function submitProfileEdit(){
    		$('form#iform_editperformer').submit();		
	}
</script><?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/". ROOT. "/application/performer/class/performer.class.php");
$user_id = getCurrentUser();

if($user_id!=0){
	form_PerProfileEdit();
}

function form_PerProfileEdit(){
$page = $_GET['page'];
$per_id = $_GET['perid'];
$per = new performer($per_id);


$year = '';
$month = '';
$day = '';

if($per->getPerDob()!=''){
$dob = explode('-', $per->getPerDob());
$year = $dob[0];
$month = $dob[1];
$day = $dob[2];
}



$rLanguage =  CheckLanguageChange();
//echo $year.'_'.$month.'_'.$day;

		echo '<h2>'.$rLanguage->text("Edit Profile").'</h2>';
		echo '<form action="'.HTTP_DOMAIN.'application/performer/php_sub/r_performeredit.php" id="iform_editperformer" method="post" enctype="multipart/form-data" onsubmit="return file_validation()">';
		echo '<div class="form_perregistration">';
			echo '<table border="0" width="100%">';
				echo '<tr>';
					//get Per_id
					echo '<input type="hidden" id="iperid" name="perid" value="'.$per_id.'">';
					echo '<td class="label">';
						echo ''.$rLanguage->text("Name*").' :';
					echo '</td>';
					echo '<td>';
						echo '<input type="text" id="iname" name="pername" class="textbox" value="'.$per->getPerName().'" autofocus="autofocus"/>';
					echo '</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td class="label">';
						echo ''.$rLanguage->text("Date of Birth").' :';
					echo '</td>';
					echo '<td>';
						//echo '<input type="text" id="idob" name="perdob" class="textbox"/>';
						echo '<select id="year" name="yyyy">';
							echo '<option selected="selected">'.$year.'</option>';
							echo '<option value="">- -</option>';
						echo '</select><span style="margin-right: 5px;">年</span>';
						echo '<select id="month" name="mm">';
							echo '<option selected="selected">'.$month.'</option>';
							echo '<option value="">- -</option>';
						echo '</select><span style="margin-right: 5px;">月</span>';
						echo '<select id="date" name="dd">';
							echo '<option selected="selected">'.$day.'</option>';
							echo '<option value="">- -</option>';
						echo '</select><span style="margin-right: 5px;">日</span>';
						echo '<script type="text/javascript">date_populate("date", "month", "year");</script>';
					echo '</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td class="label">';
						echo ''.$rLanguage->text("Hometown").' :';
					echo '</td>';
					echo '<td>';
						echo '<input type="text" id="ihometown" name="perhometown" class="textbox" value="'.$per->getPerHometown().'"/>';
					echo '</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td class="label">';
						echo ''.$rLanguage->text("Group").' :';
					echo '</td>';
					echo '<td>';
						//echo '<input type="text" id="igroup" name="pergroup" class="textbox" value="'.$per->getPerGroup().'"/>';
						echo '<select id="igroup" name="pergroup">';
							$q_group = getResultSet("SELECT group_id, group_name FROM tbl_group");
							echo '<option selected="selected" value="'.$per->getPerGroupId().'">'.$per->getPerGroup().'</option>';
							while($rg = mysql_fetch_array($q_group))
							{
								$group_id = $rg['group_id'];
								$group_name = $rg['group_name'];
								echo '<option value="'.$group_id.'">'.$group_name.'</option>';
							}
							
						echo '</select>';
					echo '</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td class="label">';
						echo ''.$rLanguage->text("Teacher").' :';
					echo '</td>';
					echo '<td>';
						echo '<input type="text" id="iteacher" name="perteacher" class="textbox" value="'.$per->getPerTeacher().'"/>';
					echo '</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td class="label">';
						echo ''.$rLanguage->text("Theme song").' :';
					echo '</td>';
					echo '<td>';
						echo '<input type="text" id="isong" name="persong" class="textbox" value="'.$per->getPerSong().'"/>';
					echo '</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td class="label" style="vertical-align: top;">';
						echo ''.$rLanguage->text("Best story").' :';
					echo '</td>';
					echo '<td>';
						//echo '<input type="text" id="istory" name="perstory" class="textbox" value="'.$per->getPerStory().'"/>';
						echo '<textarea id="istory" rows="3" name="perstory" class="textarea">'.str_replace("<br />", '', $per->getPerStory()).'</textarea>';
					echo '</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td class="label">';
						echo ''.$rLanguage->text("Homepage").' :';
					echo '</td>';
					echo '<td>';
						echo '<input type="text" id="iurl" name="perurl" class="textbox" value="'.$per->getPerUrl().'"/>';
					echo '</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td class="label">';
						echo ''.$rLanguage->text("Twitter ID").' :';
					echo '</td>';
					echo '<td>';
						echo '<input type="text" id="itwitter" name="pertwitter" class="textbox" value="'.$per->getPerTwitter().'"/>';
					echo '</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td class="label">';
						echo ''.$rLanguage->text("Mail Address*").' :';
					echo '</td>';
					echo '<td>';
						echo '<input type="text" id="iemail" name="peremail" class="textbox" value="'.$per->getPerEmail().'"/>';
					echo '</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td class="label">';
						echo ''.$rLanguage->text("Upload").' :';
					echo '</td>';
					echo '<td>';
						echo '<input type="file" id="perpicture" name="perpicture" class="textbox"/>';						
						echo '<input type="hidden" value="2000000" name="MAX_FILE_SIZE" />';
					echo '</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td class="label"></td>';
					echo '<td>';
						echo '<span class="tip">※アップロードした画像は、噺家プロフィール画面とトップページのピックアップに表示されます。</span';						
					echo '</td>';
				echo '</tr>';
				//New Password
				echo '<tr>';
					echo '<td class="label">';
						echo ''.$rLanguage->text("New Password").' :';
					echo '</td>';
					echo '<td>';
						echo '<input type="password" id="ipassword" name="perpassword" class="textbox"/>';
					echo '</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td class="label">';
						echo ''.$rLanguage->text("Confirm").' :';
					echo '</td>';
					echo '<td>';
						echo '<input type="password" id="iconfirm" name="perconfirm" class="textbox"/>';
					echo '</td>';
				echo '</tr>';
				//end New Password
				
				echo '<tr>';
					echo '<td class="label" height="10px"></td>';
					echo '<td></td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td class="label">';
					echo '</td>';
					echo '<td>';
						//echo '<input type="button" id="iadd_performer" name="persubmit" value="Register" onclick="add_newperformer()"/>';
						echo '<div class="submit button pink" style="float: left; margin-top: 5px;" onclick="submitProfileEdit();"><label style="width: 80px;">'.$rLanguage->text("Update").'</label><span></span></div>';
						//echo '<input class="submit" type="submit" id="iadd_performer" name="btn_add" value="Update" style="margin-left: 0px;">';
						echo '<div class="submit button pink" style="float: left; margin-top: 5px;" onclick="formPerEditCancel('.$per_id.')"><label style="width: 80px;">'.$rLanguage->text("Cancel").'</label><span></span></div>';
						echo '<div style="float: left; margin-top: 5px; width: 165px; height: 25px; font-size: 15px; padding: 8px 5px 5px 10px;"><img class="isending" src="'.HTTP_DOMAIN.'images/isending.gif" style="display:none;"></img></div>';
						//echo '<input type="button" id="ibtn_cancel" name="btn_cancel" value="Cancel" onclick="formPerEditCancel('.$per_id.')">';
					echo '</td>';
				echo '</tr>';
			echo '</table>';
			echo '</div>';
		echo '</form>';
		
		/*==Messages===========================================================*/

		echo '<div class="Lmessages">';
			echo '<span id="ialertcomplet">'.$rLanguage->text("Registration Complete").'</span>';
			echo '<span id="ismsrequired">'.$rLanguage->text("This field is required").'</span>';
			echo '<span id="ismsurl">'.$rLanguage->text("Please enter a valid URL").'</span>';
			echo '<span id="ismsemail">'.$rLanguage->text("Please enter a valid email address").'</span>';
			echo '<span id="ismsequalTo">'.$rLanguage->text("Please enter the same value again").'</span>';
			echo '<span id="iuploadfilevalidate">'.$rLanguage->text("Uploaded file is not supported!").'</span>';
		echo '</div>';

		/*==Messages===========================================================*/
	}
?>
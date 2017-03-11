<?php
ob_start();
if(!isset($_SESSION))session_start();

if(!defined(per_sub_path))define("per_sub_path",dirname(dirname(dirname(dirname(__FILE__)))));
require_once(per_sub_path . "/module/module.php");
	//require_once($_SERVER['DOCUMENT_ROOT'] . "/rakugo/module/module.php");
	$per_name = trim($_POST['pername']);
	$per_hometown = trim($_POST['perhometown']);
	$per_group = (int)trim($_POST['pergroup']);
	
	$per_song = trim($_POST['persong']);
	$per_story = trim(escapte_js_decrypt($_POST['perstory']));
	$per_story = nl2br($per_story);
	
	$per_picture = end(explode(".", $_FILES['perpicture']['name']));
	//echo $per_picture;
//	exit();
	$per_teacher = trim($_POST['perteacher']);
	$per_url = trim($_POST['perurl']);
	$per_email = trim($_POST['peremail']);
	$per_password = md5($_POST['perpassword']);
	$date_time = getDateTime();
	$date = getToday();
	$time = getTime();
	
	$dob_year = trim($_POST['yyyy']);
	$dob_month = trim($_POST['mm']);
	$dob_day = trim($_POST['dd']);
	//if($dob_year!='' && $dob_month!='' && $dob_day!=''){
		$per_dob = $dob_year.'-'.$dob_month.'-'.$dob_day;	
	//}
	
	//File
        $file_path = "../per_picture/";
		$getdob = str_replace('-','',$per_dob);
		$date = str_replace('-','',$date);
		$time = str_replace(':','', $time);
		
		$ext = strtolower($per_picture);
		//$picture_name = $getdob.'_'.$date.'_'.$time;
		$picture_name = $date.'_'.$getdob.'_'.$time;
		
		//echo $picture_name;
		//exit();

        $result=upload( "perpicture",$file_path, $picture_name);
        
		$tem=explode(";",$result);
        $result=$tem[0];
		$target_path=$tem[1];
		
        if($result=="0"){
            $target_path = substr($target_path,3,strlen($target_path));
            $target_path = str_replace("../", "", $target_path);
            $target_path = str_replace("//", "/", $target_path);
        }
	//end File
		if($per_picture=='' || $per_picture=null){$picture_name='';}
		else{$picture_name = $picture_name.'.'.$ext;}
		
	runSQL("INSERT INTO tbl_performer (per_name, per_dob, per_hometown, per_picture , group_id, per_teacher, per_song, per_story, per_url, per_email, per_password ) 
				VALUES('".$per_name."', '".$per_dob."', '".$per_hometown."', '".$picture_name."','".$per_group."', '".$per_teacher."','".$per_song."','".$per_story."', '".$per_url."', '".$per_email."', '".$per_password."')");
	$per_id = mysql_insert_id();	
	if(getUserType()!=ADMINISTRATOR){
		setCurrentUser($per_id);		
	}	
	///header('Location:../../../'.$_SESSION['language_selected'].'?page=perprofile&perid='.$per_id);
	//$topic_id = mysql_insert_id();
	
/*==Return Topic Detail==================================================================================================================================*/
/*
echo '<li id="' . $topic_id . '" onclick="load_topic_detail('.$topic_id.')">';
                echo '» '.$topic_title;//.'('.$total_memo.')';
echo '</li>';
*/
/*==Return Topic Detail==================================================================================================================================*/
?>
<script type="text/javascript">
	window.top.submitSuccess('<?php echo $per_id; ?>');
</script>





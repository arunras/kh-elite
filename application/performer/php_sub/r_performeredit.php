<?php
	ob_start();
    if(!isset($_SESSION))session_start();
	
if(!defined("per_sub_path"))define("per_sub_path",dirname(dirname(dirname(dirname(__FILE__)))));
require_once(per_sub_path . "/module/module.php");
	//require_once($_SERVER['DOCUMENT_ROOT'] . "/rakugo/module/module.php");
	
require_once($_SERVER['DOCUMENT_ROOT'] . ROOT . "/application/performer/class/performer.class.php");
$per_id = trim($_POST['perid']);
$per = new performer($per_id);
$getFileName = $per->getPerPictureName();

	
	$per_name = trim($_POST['pername']);
	$per_hometown = trim($_POST['perhometown']);
	$per_group = (int)trim($_POST['pergroup']);
	$per_song = trim($_POST['persong']);
	$per_story = trim(escapte_js_decrypt($_POST['perstory']));
	$per_story = nl2br($per_story);
	//$per_picture = end(explode(".", $_FILES['perpicture']['name']));
	$per_picture = current(explode(".", $_FILES['perpicture']['name']));
	
	$per_teacher = trim($_POST['perteacher']);
	$per_url = trim($_POST['perurl']);
	$per_twitter=trim($_POST['pertwitter']);
	$per_email = trim($_POST['peremail']);
	$per_getpw = $_POST['perpassword'];
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
		//set file name
		$getdob = str_replace('-','',$per_dob);
		$date = str_replace('-','',$date);
	    $time = str_replace(':','', $time);
		$ext = end(explode(".", $_FILES['perpicture']['name']));
		$ext = strtolower($ext);
		$file_name = $date.'_'.$getdob.'_'.$time;

        $result=upload( "perpicture",$file_path, $file_name);
        
		$tem=explode(";",$result);
        $result=$tem[0];
		$target_path=$tem[1];

        if($result=="0"){
            $target_path = substr($target_path,3,strlen($target_path));
            $target_path = str_replace("../", "", $target_path);
            $target_path = str_replace("//", "/", $target_path);
        }
	//end File
		
		if($per_picture!=''){
			fileDelete($file_path,$getFileName);
			$file_name = $file_name.'.'.$ext;
		}
		else{$file_name = $getFileName;}
		//if($file_name=='' || $per_picture=null){$picture_name='';}
		//else{$picture_name = $picture_name.'.'.$ext;}
		
	if($per_getpw!='' || $per_getpw!= null)
	{
	runSQL("UPDATE tbl_performer SET per_name='".$per_name."', per_dob='".$per_dob."', per_hometown='".$per_hometown."',per_picture='".$file_name."', group_id='".$per_group."', per_teacher='".$per_teacher."', per_song='".$per_song."', per_story='".$per_story."', per_url='".$per_url."', per_twitter='".$per_twitter."', per_email='".$per_email."', per_password='".$per_password."' WHERE performer_id=".$per_id); //, , per_password='".$per_password."'
	}
	else{
		runSQL("UPDATE tbl_performer SET per_name='".$per_name."', per_dob='".$per_dob."', per_hometown='".$per_hometown."',per_picture='".$file_name."', group_id='".$per_group."', per_teacher='".$per_teacher."', per_song='".$per_song."', per_story='".$per_story."', per_url='".$per_url."', per_twitter='".$per_twitter."', per_email='".$per_email."' WHERE performer_id=".$per_id); //, , per_password='".$per_password."'
	}
	
	//$per_id = mysql_insert_id();	
	$ja = '';
	if($_SESSION['language_selected']!='ja'){$ja=$_SESSION['language_selected'];}
	header('Location:../../../'.$ja.'?page=perprofile&perid='.$per_id);
	//$topic_id = mysql_insert_id();
	
function fileDelete($filepath,$filename) {
	$success = FALSE;
	if (file_exists($filepath.$filename)&&$filename!=""&&$filename!="n/a") {
		unlink ($filepath.$filename);
		$success = TRUE;
	}
	return $success;	
}
/*==Return Topic Detail==================================================================================================================================*/
/*
echo '<li id="' . $topic_id . '" onclick="load_topic_detail('.$topic_id.')">';
                echo '» '.$topic_title;//.'('.$total_memo.')';
echo '</li>';
*/
/*==Return Topic Detail==================================================================================================================================*/
?>



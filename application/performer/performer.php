<?php
//Performer
$action = $_GET['action'];
if(!defined(per_sub_path))define("per_sub_path",dirname(dirname(dirname(__FILE__))));
require_once(per_sub_path . "/module/module.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/". ROOT. "/application/performer/class/performer.class.php");

switch ($action){
	case 'performer_profile': break;
	case 'perregistration': getFormPerRegistration(); break;
	case 'newperformer': add_newperformer(); break;
	case 'userprofile': show_userprofile(); break;
	case 'pickup_perlist': show_pickupperformer(); break;
	//case 'listperformer': show_listperformer(); break;
}

/*==function_BLOCK==========================================================================================*/
function getPerformerProfile(){
	
}
function getListPerformer(){
	
}
function getFormPerRegistration(){
	$per = new performer();
    $per->form_PerRegistration();
}
function show_userprofile(){
	$per = new performer();
    $per->display_PerformerProfile();
}
function show_listperformer(){
	$per = new performer();
    $per->display_ListPerformer();
}
function add_newperformer(){
	//require_once($_SERVER['DOCUMENT_ROOT'] . "/". ROOT. "/module/module.php");
	
	$per_name = trim($_POST['pername']);
	$per_dob = trim($_POST['perdob']);
	$per_hometown = trim($_POST['perhometown']);
	$per_picture = trim($_POST['perpicture']);
	$per_teacher = trim($_POST['perteacher']);
	$per_url = trim($_POST['perurl']);
	$per_email = trim($_POST['peremail']);
	$per_password = trim($_POST['perpassword']);

	$date_time = getDateTime();

	runSQL("INSERT INTO tbl_performer (per_name, per_dob, per_hometown, per_picture, per_teacher, per_url, per_email, per_password ) 
				VALUES('".$per_name."', '".$per_dob."', '".$per_hometown."', '".$per_picture."', '".$per_teacher."', '".$per_url."', '".$per_email."', '".$per_password."')");
	//$topic_id = mysql_insert_id();	
}
function show_pickupperformer()
{
	echo '
	<center>
		<table class="rakugo schedule-list" style="margin-bottom: 20px;" width = 900>
    	<thead>
        <tr>
            <th>Choice</th>
            <th>Comic storyteller name</th>
            <th>Hometown</th>
            <th>Theme Song</th>
            <th>Best Story</th>
        </tr>
    	</thead>

    	<tbody>';
            
                $list_per = getResultSet("SELECT performer_id FROM tbl_performer");
                while($rp = mysql_fetch_array($list_per)){
                    $per = new performer($rp[0]);
                    $per->display_PickupPerformer();
                }
            
        echo '
    	</tbody>
	</table>
</center>';	
}
/*==END function_BLOCK==========================================================================================*/
?>
<?php
ob_start();
if(!isset($_SESSION))session_start();

if(!defined(per_sub_path))define("per_sub_path",dirname(dirname(dirname(dirname(__FILE__)))));
require_once(per_sub_path . "/module/module.php");
//require_once($_SERVER['DOCUMENT_ROOT'] . "/rakugo/module/module.php");
$pickup_id = $_POST['pickupid'];
$pickup_title = $_POST['pickup_title'];
$source_id = $_POST['sourceid'];
$source_type = $_POST['sourcetype'];
$pickup_comment = $_POST['pickup_comment'];

runSQL("UPDATE tbl_pickup SET pickup_title='".$pickup_title."', source_id='".$source_id."', source_type='".$source_type."', pickup_comment='".$pickup_comment."' WHERE pickup_id=".$pickup_id); //, 

$ja = '';
if($_SESSION['language_selected']!='ja'){$ja=$_SESSION['language_selected'];}		
header('Location:../../../'.$ja.'?page=pickup');


?>




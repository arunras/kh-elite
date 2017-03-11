<?php
if(!defined(per_sub_path))define("per_sub_path",dirname(dirname(dirname(dirname(__FILE__)))));
require_once(per_sub_path . "/module/module.php");
//require_once($_SERVER['DOCUMENT_ROOT'] . "/rakugo/module/module.php");
	
$pickup_id = $_GET['pickupid'];	
$pickup_title = '';
$pickup_comment = '';

runSQL("UPDATE tbl_pickup SET pickup_title='".$pickup_title."', pickup_comment='".$pickup_comment."' WHERE pickup_id=".$pickup_id); 

?>



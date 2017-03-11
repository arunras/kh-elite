<?php
//ob_start();
//if(!isset($_SESSION))session_start();
	
if(!defined(per_sub_path))define("per_sub_path",dirname(dirname(dirname(dirname(__FILE__)))));
require_once(per_sub_path . "/module/module.php");
//require_once($_SERVER['DOCUMENT_ROOT'] . "/rakugo/module/module.php");

$per_id = $_GET['perid'];
$teisuffix_id = $_GET['teisuffixid'];

	runSQL("UPDATE tbl_performer SET teisuffix_id='".$teisuffix_id."' WHERE performer_id=".$per_id);
echo $teisuffix_id;
?>




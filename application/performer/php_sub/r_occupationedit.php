<?php
//ob_start();
//if(!isset($_SESSION))session_start();
	
if(!defined(per_sub_path))define("per_sub_path",dirname(dirname(dirname(dirname(__FILE__)))));
require_once(per_sub_path . "/module/module.php");

$per_id = $_GET['perid'];
$occupation_id = $_GET['occupationid'];

	runSQL("UPDATE tbl_performer SET occupation_id='".$occupation_id."' WHERE performer_id=".$per_id);
echo $occupation_id;
?>




<?php
if(!defined(per_sub_path))define("per_sub_path",dirname(dirname(dirname(dirname(__FILE__)))));
require_once(per_sub_path . "/module/module.php");
$per_id = $_GET['perid'];

runSQL("DELETE FROM tbl_performer WHERE performer_id=".$per_id);

?>



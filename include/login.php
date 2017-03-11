<?php
    ob_start();
    if(!isset($_SESSION))@session_start();
    $id = $_POST['txtid'];
    $ps = $_POST['txtpassword'];

    include("../module/module.php");

	$per_id = checkUser($id, md5($ps));

    if($per_id){
        setCurrentUser($per_id);
    }

    //header("location:../" . $_SESSION['language_selected'] . "?page=index");
?>
<script type="text/javascript">window.top.finish_login();</script>
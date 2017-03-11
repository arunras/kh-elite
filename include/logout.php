<?php
    ob_start();
    if(!isset($_SESSION))session_start();

    unset($_SESSION['_user_rakugo_id']);
    $home_page = $_SERVER['SERVER_NAME'];
    $home_page = $home_page . "/rakugo/";
    header("location:http://" . $home_page);
?>

<?php
    //include("../module/module.php");
	/*
	ob_start();
    if(!isset($_SESSION))session_start();

    unset($_SESSION['_user_rakugo_id']);
	/*
    $home_page = $_SERVER['SERVER_NAME'];
    $home_page = $home_page . "/rakugo/";
	
    header("Location:http://".DOMAIN.ROOT."/?page=index");
	*/
?>
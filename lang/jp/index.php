<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<?php
    ob_start();
    if(!isset($_SESSION))@session_start();
    $_SESSION['language_selected'] = "ja";
    include("../include/language-index.php");
?>
</html>
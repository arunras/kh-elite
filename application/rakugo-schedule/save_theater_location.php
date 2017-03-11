<?php
    include_once(dirname(dirname(dirname(__FILE__))) . "/module/module.php");
    $rLanguage = CheckLanguageChange();

    //echo $lt . "\n" . $ln;
    runSQL("UPDATE tbl_theater SET latitude = " . $_GET['lt'] . ", longitude = " . $_GET['ln'] . " WHERE theater_id = " . $_GET['tid']);
    echo $rLanguage->text("Save successfully");
?>
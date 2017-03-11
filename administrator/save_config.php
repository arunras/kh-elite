<?php
    $field = "";
    switch($_GET['param']){
        case "ads_a" : $field = "top_ad"; break;
        case "ads_b" : $field = "ad_b"; break;
        case "ads_c" : $field = "ad_c"; break;
        case "flash_movie" : $field = "flash_movie"; break;
        case "sns_top" : $field = "sns_top"; break;
    }

    include(basename(basename(__FILE__)) . "/module/module.php");
    runSQL("UPDATE tbl_config SET $field = '" . $_POST['value'] . "' WHERE id = 1");
    echo $_POST['value'];
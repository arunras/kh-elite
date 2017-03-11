<?php

if(isset($_GET['mgt'])){


    $path = array(
        "schedule"=> "schedule.management.php"
    );

    if(!array_key_exists($_GET['mgt'], $path)){
        //$page = "index";
    }
    else{
        include($path[$_GET['mgt']]);
    }


}//if isset get mgt
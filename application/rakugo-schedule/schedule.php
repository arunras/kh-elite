<?php
    ob_start();
    if(!isset($_SESSION))@session_start();

    include_once(dirname(dirname(dirname(__FILE__))) . "/module/module.php");
    //include_once($_SERVER['DOCUMENT_ROOT'] . "/" . ROOT . "/module/module.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/" . ROOT . "/application/rakugo-schedule/class/schedule.class.php");

    $action = $_GET['action'];

    switch($action){
        case "register":
            $schedule = new schedule();
            $schedule->draw_register_page();
            break;
        case "json_performers":
            //include_once($_SERVER['DOCUMENT_ROOT'] . "/" . ROOT . "/application/rakugo-schedule/class/schedule.class.php");
            performers_list_json();
            break;
        case "json_theaters":
            //include_once($_SERVER['DOCUMENT_ROOT'] . "/" . ROOT . "/application/rakugo-schedule/class/schedule.class.php");
            theaters_list_json();
            break;
        case "insert":
            break;
        case "update":
            break;
        case "pickuplist":
            //include_once($_SERVER['DOCUMENT_ROOT'] . "/" . ROOT . "/application/rakugo-schedule/class/schedule.class.php");
            pickup_list();
            break;
        case "detail":

            if(getValue("SELECT COUNT(*) FROM tbl_event WHERE event_id = " . $_GET['id']) == "0"){
                if (!headers_sent()) {
                    header("location:" . $_SESSION['language_selected'] . "?page=index");
                }
            }
            //include_once($_SERVER['DOCUMENT_ROOT'] . "/" . ROOT . "/application/rakugo-schedule/class/schedule.class.php");
            $schedule = new schedule($_GET['id']);
            $schedule->view_detail();
            break;
        case "edit":
            if(getValue("SELECT COUNT(*) FROM tbl_event WHERE event_id = " . $_GET['id']) == "0"){
                if (!headers_sent()) {
                header("location:" . $_SESSION['language_selected'] . "?page=index");
                }
            }
            //include_once($_SERVER['DOCUMENT_ROOT'] . "/" . ROOT . "/application/rakugo-schedule/class/schedule.class.php");
            $schedule = new schedule($_GET['id']);
            $schedule->view_edit();
            break;
        case md5("delete"):
            //include_once($_SERVER['DOCUMENT_ROOT'] . "/" . ROOT . "/module/module.php");
            if(getUserType() == ADMINISTRATOR){
                $e_id = url_fake_value($_GET['id']);
                runSQL("DELETE FROM tbl_event WHERE event_id = " . $e_id);
                runSQL("DELETE FROM tbl_event_performer WHERE event_id = " . $e_id);
                runSQL("DELETE FROM tbl_event_theater WHERE event_id = " . $e_id);
            }
            if($_SESSION['language_selected'] == "ja"){
                $r = "";
            }
            else $r = $_SESSION['language_selected'];

            echo $r;
            break;
        case "search":
            //include_once($_SERVER['DOCUMENT_ROOT'] . "/" . ROOT . "/application/rakugo-schedule/class/schedule.class.php");
            if(isset($_GET['type'])) $type = "calendar";
            else $type = "list";
            display_search($type);
            break;
        case md5("delete_list_row"):
            //include_once($_SERVER['DOCUMENT_ROOT'] . "/" . ROOT . "/application/rakugo-schedule/class/schedule.class.php");
            if(getUserType() == ADMINISTRATOR){
                $e_id = url_fake_value($_GET['id']);
                runSQL("DELETE FROM tbl_event WHERE event_id = " . $e_id);
                runSQL("DELETE FROM tbl_event_performer WHERE event_id = " . $e_id);
                runSQL("DELETE FROM tbl_event_theater WHERE event_id = " . $e_id);
            }
            table_list();
            break;
        case "json_list_events":
            //include_once($_SERVER['DOCUMENT_ROOT'] . "/" . ROOT . "/application/rakugo-schedule/class/schedule.class.php");
            if(isset($_GET['filter'])){

            }
            else events_list_json();
            break;
        case "json_calendar_events": /* by: Leang Seang Ou */
            //include_once($_SERVER['DOCUMENT_ROOT'] . "/" . ROOT . "/application/rakugo-schedule/class/schedule.class.php");
            if(isset($_GET['filter'])){
                $keyword   = ($_POST['s_all']);
                $theater   = ($_POST['s_hall']);
                $group     = ($_POST['s_group']);
                $performer = ($_POST['s_performer']);

                $sql_end   = "";
                if(($_POST['s_date_min']) != "" && ($_POST['s_date_max']) != ""){
                    if($_SESSION['language_selected'] != "ja")list($y, $m, $d) = explode('/', ($_POST['s_date_min']));
                    else {
                        preg_match_all('/([\d]+)/', $_POST['s_date_min'], $matches);
                        list($y , $m, $d) = $matches[0];
                    }
                    $min_date    = date("Y-m-d", mktime(0, 0, 0, $m, $d, $y));

                    if($_SESSION['language_selected'] != "ja")list($y, $m, $d) = explode('/', ($_POST['s_date_max']));
                    else {
                        preg_match_all('/([\d]+)/', $_POST['s_date_max'], $matches);
                        list($y, $omit , $m, $d) = $matches[0];
                    }
                    $max_date    = date("Y-m-d", mktime(0, 0, 0, $m, $d, $y));
                    $sql_end = "WHERE event_post BETWEEN '$min_date' AND '$max_date'";
                }
                $sql  = "SELECT event_id, event_title, event_post FROM tbl_event $sql_end";
                //echo $sql;
                events_calendar_json($sql, $keyword, $theater, $group, $performer);
            }
            else events_calendar_json();
            break;
        case "register_theater": 
            $rLanguage = CheckLanguageChange();            
            
            $lat_lng =  simplexml_load_file("http://www.geocoding.jp/api/?q=" . $_POST['address'] . " " . $_POST['name']);
            
            
            //print_r($lat_lng);
            $lat = $_POST['theater_lat'];
            $lng = $_POST['theater_lng'];
            foreach($lat_lng as $key => $value){
                if($key == "coordinate"){
                    foreach($value as $label => $val){
                        if($label == 'lat') $lat = $val;
                        if($label == 'lng') $lng = $val;
                    }
                }
            }
            
            if($_POST['name'] == ""){
                //echo $rLanguage->text("");
            }
            else{
                if($_POST['action'] == "update"){
                    if(getValue("SELECT COUNT(*) FROM tbl_theater WHERE theater_name = '" . trim($_POST['name']) . "' AND theater_id <> " . $_POST['id']) != "0"){
                        echo $rLanguage->text('Theater exist') . ";0";
                    }
                    else{
                        runSQL("UPDATE tbl_theater SET theater_name = '" . trim($_POST['name']) . "', theater_phone = '" . trim($_POST['reference']) . "', theater_address = '" . trim($_POST['address']) . "', theater_nearest = '" . trim($_POST['nearest']) . "' WHERE theater_id = '" . $_POST['id'] . "'");
                        echo $rLanguage->text("save successfully") . ";" . mysql_insert_id();
                    }
                }
                else{                
                     if(getValue("SELECT COUNT(*) FROM tbl_theater WHERE theater_name = '" . trim($_POST['name']) . "'") != "0"){
                        echo $rLanguage->text('Theater exist') . ";0";
                     }
                     else{
                         runSQL("INSERT INTO tbl_theater(theater_name, theater_phone, theater_address, theater_nearest, latitude, longitude) VALUES('" . trim($_POST['name']) . "', '" . trim($_POST['reference']) . "','" . trim($_POST['address']) . "','" . trim($_POST['nearest']) . "', " . $lat . "," . $lng .  ")");
                         echo $rLanguage->text("save successfully") . ";" . mysql_insert_id();
                     }
                }
            }
            break;
        default: break;
    }
?>

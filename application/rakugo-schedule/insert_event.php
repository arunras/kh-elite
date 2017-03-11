<?php
    /* insert to table events */
            include_once("../../module/module.php");
            //convert data:event-date from input to date
            if($_SESSION['language_selected'] != "ja")list($y, $m, $d) = explode('/', $_POST['sc-date']);
            else {
                preg_match_all('/([\d]+)/', $_POST['sc-date'], $matches);
                list($y, $m, $d) = $matches[0]; // for ansi
            }
            $date    = date("Y-m-d", mktime(0, 0, 0, $m, $d, $y));


            runSQL("INSERT INTO tbl_event(event_title, event_description, event_price, event_post, event_open, event_curtain, event_status)
                VALUES(
                    '" . $_POST['sc-title'] . "',
                    '" . $_POST['txt_description'] . "',
                    '" . $_POST['sc-price'] . "',
                    '" . $date . "',
                    '" . convert_time($_POST['sc-open'], 24) . "',
                    '" . convert_time($_POST['sc-finish'], 24) . "',
                    1
                )
            ");

            $event_id = mysql_insert_id();

            /* insert performers */
            $sql = "";
            foreach($_POST['performers'] as $p){
                $sql .= "($event_id, $p),";
            }
            //remove last comma
            $sql = "INSERT INTO tbl_event_performer(event_id, performer_id) VALUES " . $sql;
            $sql = substr($sql, 0, strlen($sql) -1 );

            runSQL($sql);

            //insert theater
            runSQL("INSERT INTO tbl_event_theater(event_id, theater_id) VALUES($event_id, " . $_POST['theaterid'] . ")");
            //echo "?page=schedule&action=detail&id=" . $event_id;
            if($_SESSION['language_selected'] == "ja"){
                $r = "";
            }
            else $r = $_SESSION['language_selected'];

            header("location:../../" . $r . "?page=schedule&action=detail&id=" . $event_id);

?>
<?php            
            include("../../module/module.php");
           
            /* update to table events */
            //convert data:event-date from input to date
            /*list($y, $m, $d) = explode('/', $_POST['sc-date']);*/
            if($_SESSION['language_selected'] != "ja")list($y, $m, $d) = explode('/', $_POST['sc-date']);
            else {
                preg_match_all('/([\d]+)/', $_POST['sc-date'], $matches);
                list($y , $m, $d) = $matches[0];
            }

            $date    = date("Y-m-d", mktime(0, 0, 0, $m, $d, $y));

            $event_id = $_POST['sc-id'];
            $sql = "UPDATE tbl_event SET 
                    event_title = '" . $_POST['sc-title'] . "', 
                    event_price = '" . $_POST['sc-price'] . "', 
                    event_post = '$date', 
                    event_open = '" . convert_time($_POST['sc-open'], 24) . "', 
                    event_curtain = '" . convert_time($_POST['sc-finish'], 24) . "', 
                    event_description = '" . $_POST['txt_description'] . "'    
                    WHERE event_id = " . $event_id;
            runSQL($sql);

            /* delete last performers */
            runSQL("DELETE FROM tbl_event_performer WHERE event_id = " . $event_id);
            /* insert performers include last performers*/
            $sql = "";
            foreach($_POST['performers'] as $p){
                $sql .= "($event_id, $p),";
            }
            //remove last comma
            $sql = "INSERT INTO tbl_event_performer(event_id, performer_id) VALUES " . $sql;
            $sql = substr($sql, 0, strlen($sql) -1 );

            runSQL($sql);

            //update theater

            if(getValue("SELECT COUNT(*) FROM tbl_event_theater WHERE event_id = " . $event_id) == "0")
                runSQL("INSERT INTO tbl_event_theater(event_id, theater_id) VALUES(" . $event_id . ", " . $_POST['theaterid'] . ")");
            else
                runSQL("UPDATE tbl_event_theater SET theater_id = " . $_POST['theaterid'] . " WHERE event_id = " . $event_id);

            if($_SESSION['language_selected'] == "ja"){
                $r = "";
            }
            else $r = $_SESSION['language_selected'];

                header("location:../../" . $r . "?page=schedule&action=detail&id=" . $event_id);
<?php

    /*
     * Class for manipulate data with schedule (events table)
     * Creator: Loch Khemarin
     * Date: 10/04/2011
     */
     define("S_CLASS_PATH", dirname(dirname(dirname(dirname(__FILE__)))) . "/");
     /* include tbl class for theatre and extends for schedule object */
     include_once(S_CLASS_PATH . "application/tbl/tbl.class.php");
     class schedule extends tbl{
        public $id;                         //primary key in table of event data
        public $title;                      //Title of event
        public $post;                       //Date/Time of posting event
        public $open;                       //Date/Time of event to perform
        public $close;                      //Date/Time of event finish perform
        public $status;                     //True/False indicate whether the schedule is viewable or trash

        public $theater;                    //Theater of the event

        public $rLanguage;                  //store object of language to display

        /* initialize data */
        public function __construct($id = ""){
            $this->id = $id;
            $this->primary_key_value = $id;
            $this->table_name = "tbl_event";
            $this->primary_key_field = "event_id";
            if($id != "")
                $this->theater = new theater(getValue("SELECT theater_id FROM tbl_event_theater WHERE event_id = " . $this->id));
            $this->rLanguage = CheckLanguageChange();
        }

        /* initialize database functions */
        private function init_db(){
            include_once(S_CLASS_PATH . "/module/module.php");
        }

        /* register page */
        public function draw_register_page(){
            include("schedule.register.design.php");
        }


        /* display row of events in pickup */
        public function pickup_row(){
            $open_time = to_time_display($this->getValue("event_open"));
            if($open_time != "") $open_time .= ' ' . $this->rLanguage->text("open") . "<br />";
            $perform_time = to_time_display($this->getValue("event_curtain"));
            if($perform_time != "") $perform_time .= ' ' . $this->rLanguage->text("perform");
            echo '<tr>';
                    echo '<td class="tdPickup" id="' . $this->id . '" align="center"><input type="radio" id="' . $this->id . '" name="choice_event_pickup" class="rd_pickup"></td>';
                    echo '<td align="center"><a href="#" onclick="return false;" class="">' . to_date_display($this->getValue("event_post")) . '</a></td>';
                    echo '<td>
                        ' . $open_time . '
                        ' . $perform_time . '
                    </td>';
                    echo '<td align="center"><a href="?page=schedule&action=detail&id=' . $this->id . '" class="">' . $this->getValue("event_title"). '</a></td>';
                    echo '<td><a onclick="return false;" href="#" class="">' . $this->list_performers_names(). $this->get_hidden_performers(). '</a></td>';
                    echo '<td><a onclick="return false;" href="#" class="">' . $this->theater->getValue("theater_name"). '</a></td>';
                    echo '</tr>';
        }

        /* display row of events in search */
        public function search_row($user_type){
            $open_time = to_time_display($this->getValue("event_open"));
            if($open_time != "") $open_time .= ' ' . $this->rLanguage->text("open") . "<br />";
            $perform_time = to_time_display($this->getValue("event_curtain"));
            if($perform_time != "") $perform_time .= ' ' . $this->rLanguage->text("perform");
            echo '<tr id="' . $this->id . '">';
                    echo '<td>' . to_date_display($this->getValue("event_post")) . '</td>';
                    echo '<td>
                        ' . $open_time . '
                        ' . $perform_time . '
                    </td>';
                    echo '<td><a href="?page=schedule&action=detail&id=' . $this->id . '" class="rakugo">' . $this->getValue("event_title"). '</a></td>';
                    echo '<td>' . $this->list_performers_names(). '</td>';
                    echo '<td style="position: absolute; left: -9999px;">' . $this->list_group_id(). '</td>';
                    echo '<td>' . $this->theater->getValue("theater_name"). '</td>';
                    echo '<td>';
                    if($user_type == ADMINISTRATOR)
                        echo '
                        <a href="?page=schedule&action=edit&id=' . $this->id . '" class="rakugo" style="float: left; display: inline-block; margin-right: 10px;">' . $this->rLanguage->text("edit") . '</a>
                        <a href="#" onclick="return false;" class="delete_schedule rakugo" style="float: left;" schedule="' . $this->id . '">' . $this->rLanguage->text("delete") . '</a>
                        ';
                    else{
                        echo $this->theater->getValue("theater_nearest");
                    }
                    echo '</td>';
                    echo '<td style="position: absolute; left: -9999px;">' . $this->getValue("event_curtain") . '</td>';
                    echo '<td style="position: absolute; left: -9999px;">' . $this->getValue("event_post"). '</td>';
                    echo '</tr>';
        }

        /* display-in list- performers' names */
        public function list_performers_names($view_in = ""){
            /* include performer object */
            include_once(S_CLASS_PATH . "application/performer/class/performer.class.php");
            $style = '';
            if($view_in == "detail"){
                $style = " margin: 5px; margin-top: 10px;";
            }
            $p_rs = getResultSet("SELECT performer_id FROM tbl_event_performer WHERE event_id = " . $this->id);
            $text_return = '';
            while($pr = mysql_fetch_array($p_rs)){
                $p = new performer($pr[0]);
                $text_return .= '<a class="rakugo" style="display: block;' . $style . '" href="?page=perprofile&perid=' . $pr[0] . '" id="' . $pr[0] . '">' . $p->getPerName() . '</a>';
            }
            return $text_return;
        }

        /* display group id in search table for filtering */
        public function list_group_id(){
            $pid_rs = getResultSet("SELECT performer_id FROM tbl_event_performer WHERE event_id = " . $this->id);
            $text_return = '';
            while($pr = mysql_fetch_array($pid_rs)){
                $pr_rs = getResultset("SELECT group_id FROM tbl_performer WHERE per_user_type <> 'administrator' AND performer_id = " . $pr[0]);
                while($r = mysql_fetch_array($pr_rs)){
                    $text_return .= $r[0] . ' ';
                }
            }
            return $text_return;
        }

        /* display performer list in li */
        public function get_li_performers(){
            /* include performer object */
            include_once(S_CLASS_PATH . "application/performer/class/performer.class.php");
            $p_rs = getResultSet("SELECT performer_id FROM tbl_event_performer WHERE event_id = " . $this->id);
            $text_return = '';
            while($pr = mysql_fetch_array($p_rs)){
                $p = new performer($pr[0]);
                $text_return .= '
                    <li onclick="select_performer(' . $pr[0] . ')" id="' . $pr[0] . '">' . $p->getPerName() . '</li>
                ';
            }
            return $text_return;
        }

        /* get string value of performers name seperate by single space: for searching in calendar */
        public function get_ec_performers_name(){
            /* include performer object */
            include_once(S_CLASS_PATH . "/application/performer/class/performer.class.php");
            $per_rs = getResultSet("SELECT performer_id FROM tbl_event_performer WHERE event_id = " . $this->id);
            $result = "";
            while($r = mysql_fetch_array($per_rs)){
                $p = new performer($r[0]);
                //array_push($result, $p->getPerName());
                $result .= $p->getPerName() . " ";
            }
            return $result;
        }

        /* get array of group id of performer of the events */
        public function get_group_array(){
            /* include performer object */
            include_once(S_CLASS_PATH . "application/performer/class/performer.class.php");
            $per_rs = getResultSet("SELECT performer_id FROM tbl_event_performer WHERE event_id = " . $this->id);
            $result = array();
            while($r = mysql_fetch_array($per_rs)){
                $p = new performer($r[0]);
                array_push($result, $p->getPerGroupId());
            }
            return $result;
        }

        /* add the hidden list of performers for events in edit page */
        public function get_hidden_performers(){
            $p_rs = getResultSet("SELECT performer_id FROM tbl_event_performer WHERE event_id = " . $this->id);
            $text_return = '';
            while($pr = mysql_fetch_array($p_rs)){
                $text_return .= '
                    <input name="performers[]" type=hidden id="' . $pr[0] . '" value="' . $pr[0] . '" />
                ';
            }
            return $text_return;
        }

        /* get the select option list of performer for edit and registering */
        public function select_performers($id){
            /* include performer object */
            include_once(S_CLASS_PATH . "/application/performer/class/performer.class.php");
            echo '<select id="' . $id . '" style="width: 190px; margin-left: 10px; padding: 2px;">';
            echo '<option style="color: #888;" id="error">--</option>';
            $p_rs = getResultSet("SELECT performer_id FROM tbl_performer WHERE per_user_type <> 'administrator'");
            while($r = mysql_fetch_array($p_rs)){
                $p = new performer($r[0]);
                echo '<option id="' . $r[0] . '">' . $p->getPerName() . '</option>';
            }
            echo '</select>';
        }


        /* get the select option list of theater for edit and registering */
        public function select_theaters($view_in, $id){
            echo '<select id="' . $id . '" style="width: 190px; margin-left: 10px; padding: 2px;">';
            echo '<option style="color: #888;" id="error">--</option>';
            $p_rs = getResultSet("SELECT theater_id, theater_name FROM tbl_theater");
            while($r = mysql_fetch_array($p_rs)){
                $t = new theater($r[0]);
                echo '<option id="' . $r[0] . '" ref="' . $t->getValue("theater_phone") . '" adr="' . $t->getValue("theater_address") . '" near="' . $t->getValue("theater_nearest") . '"';
                if($view_in == "edit" && $r[0] == $this->theater->primary_key_value) echo ' selected ';
                echo '>' . $r[1] . '</option>';
            }
            echo '</select>';
        }

        /* get hall name */
        public function hall_name(){
            $theater = new theater(getValue("SELECT theater_id FROM tbl_event_theater WHERE event_id = " . $this->id));
            return $theater->getValue("theater_name");
        }

        /* display schedule-detail */
        public function view_detail(){
            include("schedule.detail.design.php");
        }

        /* display schedule-detail */
        public function view_edit(){
            include("schedule.edit.design.php");
        }


     }// class schedule

     class theater extends tbl{
        /* initialize database information of tbl theater for theater class */
        public function __construct($id = ""){
            $this->table_name = "tbl_theater";
            $this->primary_key_field = "theater_id";
            $this->primary_key_type = "non-string";
            $this->primary_key_value = $id;
        }
     }


     /* use for jquery autocomplete : performer data */
     function performers_list_json(){
            $q = strtolower($_GET["term"]);
            if(!$q) return;
            $items = getResultSet("SELECT per_name, performer_id FROM tbl_performer WHERE per_user_type <> 'administrator'");
            $result = array();
            while($r = mysql_fetch_array($items)){
                $key = $r[0] . " ";
                $value = $r[1];
            	if(strpos(strtolower($key), $q) !== false) {
            		array_push($result, array("id"=>$value, "label"=>$key, "value" => strip_tags($key)));
            	}
            }
            echo array_to_json($result);
        }

        /* use for jquery autocomplete : theaters data */
         function theaters_list_json(){
            $q = strtolower($_GET["term"]);
            if(!$q) return;
            $items = getResultSet("SELECT theater_name, theater_id, theater_phone, theater_address, theater_nearest FROM tbl_theater");
            $result = array();
            while($r = mysql_fetch_array($items)){
                $key = $r[0] . " ";
                $value = $r[1];
            	if(strpos(strtolower($key), $q) !== false) {
            		array_push($result, array("id"=>$value, "ref"=>$r[2], "adr"=>$r[3], "near"=>$r[4], "label"=>$key, "value" => strip_tags($key)));
            	}
            }
            echo array_to_json($result);
        }

        /* display list of events in pickup */
         function pickup_list(){
            include("schedule.pickuplist.design.php");
        }

        /* json calendar events */
		 function events_calendar_json($sql = "", $s_keyword = "", $theater = "", $group = "", $performer = ""){
            /* Note that date range is already filter from schedule.php */

            $filter = true;
            if($sql == ""){
                $sql = "SELECT event_id, event_title,event_post FROM tbl_event";
                $filter = false;
            }
            $items  = getResultSet($sql);
            $result = array();
            $group  = explode(";", $group);
            $l      = count($group);

            while($r = mysql_fetch_array($items)){
                $s            = new schedule($r[0]);
                $performers   = $s->get_ec_performers_name();
                $group_arr_id = $s->get_group_array();
                if($filter){
                    /* select by keyword */
                    if($s_keyword == "" && $theater == "" && $performer == "" && $l <= 1){
                        /* no filter */
                        array_push($result, array("url"=>"?page=schedule&action=detail&id=" . $r[0], "title"=>$r[1], "start"=>$r[2]));
                    }
                    else{
                        /* filter by any keyword */
                        if($s_keyword != ""){
                            //echo $s_keyword . "\n" .
                            if(
                                stristr((($s->getValue("event_title"))), ($s_keyword)) !== false ||
                                stristr(($performers), ($s_keyword)) !== false ||
                                stristr(($s->theater->getValue("theater_name")), ($s_keyword)) !== false

                            ){
                                array_push($result, array("url"=>"?page=schedule&action=detail&id=" . $r[0], "title"=>$r[1], "start"=>$r[2]));
                            }

                        }
                        /* filter by performer name */
                        else if($performer != ""){
                            if(stristr(($performers), ($performer)) !== false)
                                array_push($result, array("url"=>"?page=schedule&action=detail&id=" . $r[0], "title"=>$r[1], "start"=>$r[2]));
                        }
                        /* filter by theater name */
                        else if($theater != ""){
                            if(stristr(($s->theater->getValue("theater_name")), ($theater)) !== false)
                                array_push($result, array("url"=>"?page=schedule&action=detail&id=" . $r[0], "title"=>$r[1], "start"=>$r[2]));
                        }
                        /* filter by group */
                        else if($l > 1){
                            for($i = 0; $i < $l-1 ; $i++){
                            //echo $group[$i] ; print_r($group_arr_id); echo  in_array($group[$i], $group_arr_id) . "\n";
                                if(in_array($group[$i], $group_arr_id) > 0){
                                    array_push($result, array("url"=>"?page=schedule&action=detail&id=" . $r[0], "title"=>$r[1], "start"=>$r[2]));
                                }
                            }
                        }
                    }
                }
                else{
                    array_push($result, array("url"=>"?page=schedule&action=detail&id=" . $r[0], "title"=>$r[1], "start"=>$r[2]));
                }

            }
            echo array_to_json($result);
        }

        /* json calendar events */
		 function events_list_json($sql = ""){
            if($sql == "") $sql = "SELECT event_id FROM tbl_event";
            $items = getResultSet($sql);
            $result = '';
            $l = mysql_num_rows($items);
            $i = 0;
            $ut = getUserType();
            echo '
                {
                "aaData": [ ';
            while($r = mysql_fetch_array($items)){
                $i++;
                    $s = new schedule($r[0]);
                    $link_title = '<a href="?page=schedule&action=detail&id=' . $r[0] . '" class="rakugo">' . $s->getValue("event_title") . '</a>';
                    $action_link = '
                        <a href="?page=schedule&action=edit&id=' . $s->id . '" class="rakugo" style="float: left; display: inline-block; margin-right: 10px;">' . $this->rLanguage->text("edit") . '</a>
                        <a onclick="return false;" href="#" class="delete_schedule rakugo" style="float: left;" schedule="' . $s->id . '">' . $this->rLanguage->text("delete") . '</a>
                    ';
                    if($ut == ADMINISTRATOR){
                        echo '[
                        "' . to_date_display($s->getValue("event_post")) . '",
                        "' . to_time_display($s->getValue("event_open")) . ' ' . $this->rLanguage->text("open") . '<br />' . to_time_display($s->getValue("event_curtain")) . ' ' . $this->rLanguage->text("perform") . '",
                        "' . mysql_real_escape_string($link_title) . '",
                        "' . mysql_real_escape_string($s->list_performers_names()) . '",
                        "' . $s->list_group_id() . '",
                        "' . mysql_real_escape_string($s->theater->getValue("theater_name")) . '",
                        "' . mysql_real_escape_string($action_link) . '"
                        ]';
                    }
                    else{
                        echo '[
                        "' . to_date_display($s->getValue("event_post")) . '",
                        "' . to_time_display($s->getValue("event_open")) . ' ' . $this->rLanguage->text("open") . '<br />' . to_time_display($s->getValue("event_curtain")) . ' ' . $this->rLanguage->text("perform") . '",
                        "' . mysql_real_escape_string($link_title) . '",
                        "' . mysql_real_escape_string($s->list_performers_names()) . '",
                        "' . $s->list_group_id() . '",
                        "' . mysql_real_escape_string($s->theater->getValue("theater_name")) . '",
                        "' . mysql_real_escape_string($s->theater->getValue("theater_nearest")) . '"
                    ]';
                    }
                    if($i< $l) echo ',';
            }

            //$result = substr($result, 1);
            echo ' ]}';

              /*
              "sEcho": 1,
              "iTotalRecords": "57",
              "iTotalDisplayRecords": "57",
              */
        }


        /* display search filter panel */
         function search_filter_panel(){
            //$today = date("m") . "/" . date("d"). "/" . date("Y");
            $rLanguage = CheckLanguageChange();
            $today = "";
			
			$keyword = "";
			$dmin = "";
			$dmax = "";
	
			if(isset($_POST['search_trigger'])){
				$keyword = $_POST['s_all'];
				$dmin = $_POST['s_date_min'];
				$dmax = $_POST['s_date_max'];
			}
			
            echo '
                <div class="btn_search_condition"></div>
				<input type="hidden" value="' . $_POST['search_trigger'] . '" id="search_trigger" />
				
                <label class="schedule-search-label">' . $rLanguage->text("theater") . '</label><input class="schedule-search-text" type="text" id="s_hall" name="s_hall" />
                <label class="schedule-search-label">' . $rLanguage->text("performer_filter") . '</label><input class="schedule-search-text" type="text" id="s_performer" name="s_performer" />
                <label class="schedule-search-label">' . $rLanguage->text("keyword") . '</label><input class="schedule-search-text" type="text" id="s_all" name="s_all" value="' . $keyword . '" />

                <input class="schedule-search-text" type="text" id="s_group" name="s_group" style="position: absolute; left: -9999px;"/> <!--  style="position: absolute; left: -9999px;"  -->
                <label class="schedule-search-label">' . $rLanguage->text("filter by date from") . '</label><input class="schedule-search-text" type="text" id="s_date_min" name="s_date_min" value ="' . $dmin . '"  />
                <label class="schedule-search-label">' . $rLanguage->text("to") . '</label><input class="schedule-search-text" type="text" id="s_date_max" name="s_date_max" value ="' . $dmax . '" />
            ';

            echo '<div class="btn_search" id="schedule_search" style="margin-left: 50px; margin-bottom: 25px;"></div>';
            echo '<div class="filter-group-title">' . $rLanguage->text("group filter") . '</div>';
             $rs = getResultSet("SELECT group_id, group_name FROM tbl_group");
             echo '<table cellpadding=7 width=260>';
             while($r = mysql_fetch_array($rs)){
                echo '
                    <tr class="hover">
                        <td valign="top" width=20 class="dashed-line"><input style="float: left; margin: 0; padding: 0;" type=checkbox value="" id="' . $r[0] . '" class="group_filter"/></td>
                        <td valign="top" class="dashed-line group_filter_trigger"><span class="group_label" style="float: left;">' . $r[1] . '</span></td>
                    </tr>';
             }
             echo '</table>';
        }
		
		/* display search filter panel at top page version: 2 */
         function search_filter_panel_top(){
            //$today = date("m") . "/" . date("d"). "/" . date("Y");
            $rLanguage = CheckLanguageChange();
            $today = "";
            echo '
				<form action="' . HTTP_DOMAIN . '?page=schedule&action=search" method="POST">
				<div class="btn_search_title_top" style="margin: 0 0 10px 0;"></div>
				<div style="margin-left: 20px;">
					<label class="schedule-search-label span-9">' . $rLanguage->text("keyword") . '</label><input class="schedule-search-text span-5" type="text" id="s_all" name="s_all" />
                
                	<label class="schedule-search-label span-9">' . $rLanguage->text("filter by date from") . '</label><input class="schedule-search-text span-5" type="text" id="s_date_min" name="s_date_min" value ="' . $today . '"  />
                	<label class="schedule-search-label span-9">' . $rLanguage->text("to") . '</label><input class="schedule-search-text span-5" type="text" id="s_date_max" name="s_date_max" value ="' . $today . '" />
					
					<input type="hidden" name="search_trigger" value="true"/>
				</div>
				</form>
            ';

            echo '<div class="btn_search span-4" id="schedule_search" style="margin-left: 60px; margin-bottom: 25px;"></div>';
        }

        /* display table list searching when delete callback */
         function table_list(){
            $ut = getUserType();
            $rLanguage = CheckLanguageChange();
            echo '
                <table class="rakugo schedule-list" style="float: left; margin-left: 0px; position: relative; top: -20px; border: 0.2em solid #000;" width = 790>
                <thead>
                    <tr>
                        <th width=130>' . $rLanguage->text("date") . '</th>
                        <th width=100>' . $rLanguage->text("time") . '</th>
                        <th width=250>' . $rLanguage->text("title") . '</th>
                        <th width=140>' . $rLanguage->text("performer") . '</th>
                        <th width=0 style="position: absolute; left: -9999px;"></th>
                        <th width=140>' . $rLanguage->text("meeting place") . '</th>';
                            if($ut == ADMINISTRATOR) echo '<th width=100>' . $rLanguage->text("edit, delete") . '</th>';
                            else echo '<th width=100>Nearest</th>';                        
            echo '
                        <th width=0 style = "position: absolute; left: -9999px;">post</th>
                        <th width=0 style = "position: absolute; left: -9999px;">open</th>
                    </tr>
                </thead>

                <tbody>
                ';
                $list_event = getResultSet("SELECT event_id, event_title, event_post, event_open, event_curtain FROM tbl_event WHERE event_status = 1");
                while($event = mysql_fetch_array($list_event)){
                    $event = new schedule($event[0]);
                    $event->search_row($ut);
                }
            echo '
                </tbody>
            </table>
            ';
        }

        /* display list of search events */
        function display_search($type = "list"){
            if($type == "list"){
                include("schedule.search.list.php");
            }
            else{
                include("schedule.search.calendar.php");
            }
        }
?>
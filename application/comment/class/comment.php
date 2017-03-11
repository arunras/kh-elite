<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of comment
 *
 * @author Camitss_ Khemarin
 */

include_once($_SERVER['DOCUMENT_ROOT'] . ROOT . "/application/tbl/tbl.class.php");

class comment extends tbl{
    //put your code here
                
    public function __construct($id = ""){
        $this->table_name = "tbl_event_comments";
        $this->primary_key_field = "comment_id";
        $this->primary_key_type = "non-string";
        $this->primary_key_value = $id;
    }  
    
    public function comment_row(){
        $date = explode(" ", $this->getValue("comment_date"));            
        $time = $date[1];
        $date = $date[0];
        echo '
        <div class="event_comment_row">                
            <span class="date" style="margin-right: 10px;">' . to_date_display($date) . ' ' . to_time_display($time) .  '</span>
            <span class="title">' . $this->getValue("comment_title") . '</span>
            <div>' . $this->getValue("comment_text") . '</div>
        </div>
        ';
    }
    
}

?>

<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
 include_once("../../module/module.php");
 include_once("class/comment.php");
 $date    = date("Y-m-d H:i:s"); 
 runSQL("INSERT INTO tbl_event_comments(event_id, user_id, comment_date, comment_title, comment_text) VALUES(
      " . $_POST['txt_event_id'] . ", " . getCurrentUser() . ", '$date', '" . $_POST['txt_comment_title'] . "', '" . $_POST['txt_comment'] . "'          
     )");
 
 $c = new comment(mysql_insert_id());
 $c->comment_row();
 
?>

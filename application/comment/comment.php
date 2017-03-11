<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
 echo '<link rel="stylesheet" type="text/css" href="' . HTTP_DOMAIN . 'application/comment/css/comment.css" />';
 include_once($_SERVER['DOCUMENT_ROOT'] . ROOT . "/application/comment/class/comment.php");
 
 $c_rs = getResultSet("SELECT comment_id FROM tbl_event_comments WHERE event_id = " . $_GET['id'] . " ORDER BY comment_date ASC");
 
?>
<div class="comment_wrapper">    
    <?php
        echo '<div class="rows">';
        while($r = mysql_fetch_array($c_rs)){
            $c = new comment($r[0]);
            $c->comment_row();
        }
        echo '</div>';
        $ut = getUserType();
        if($ut != VIEWER){
            echo ' 
                <form id="form_comment">
                    <input type="text" class="comment_title" name="txt_comment_title" />
                    <textarea id="txt_comment" name="txt_comment">
                    </textarea> 
                    <input type="hidden" name="txt_event_id" value="' . $_GET['id'] . '" />
                    
                    <div class="button pink" style="float: right; margin: 5px 15px 10px 0;" id="post_comment"><label>'. $this->rLanguage->text("post comment") . '</label><span></span></div>
                </form>
            ';
        }
    ?>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        var e = $("#txt_comment").cleditor({
            height: 100,
            controls : "bold italic underline strikethrough subscript superscript | font size " +
                        "style | color highlight removeformat | bullets numbering " +
                        "| alignleft center alignright justify | undo redo | "                        
        })[0];
        
        
        $("#post_comment").click(function(){
            $.post(
            base_url + "application/comment/save.php", $("form#form_comment").serialize(), 
                function(data){
                    //alert(data);
                    $("div.comment_wrapper div.rows").append(data);
                    e.clear();
                    $("input[type=text].comment_title").val("");
                }
            );
        });
    });
</script>
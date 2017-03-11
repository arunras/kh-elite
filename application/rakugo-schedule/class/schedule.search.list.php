<?php echo '<link type="text/css" rel="stylesheet" href="' . HTTP_DOMAIN . 'application/rakugo-schedule/css/datatable.css" />'; ?>

<center>

<table>
<tr>
    <td class="top" rowspan="2" style="width: 260px;">
    <div class="span-6" style="">
        <?php
            search_filter_panel();
            //$user_type = getUserType();
            /* since this use for searching without operation
            * each user-event the administrator- will view this page without any action
            */
            /* set display as viewer */
            $user_type = getUserType();

            $rLanguage = CheckLanguageChange();
        ?>
    </div>

    </td>

    <td>
        <span style="float: left; margin-left: 30px;"><?php echo $rLanguage->text("switch type"); ?> :</span>
        <span style="float: left; margin-left: 5px;"><?php echo $rLanguage->text("list view"); ?> </span>
        <span style="float: left; margin-left: 5px;">/</span>
        <a href="?page=schedule&action=search&type=calendar" class="rakugo" style="float: left; margin-left:5px;"><?php echo $rLanguage->text("calendar view"); ?></a>
    </td>
</tr>
<tr>
<td>
<div class="schedule-search-list-title" style="margin-left: 30px;">
<?php if($user_type == ADMINISTRATOR || $user_type == PERFORMER){ ?><a href="?page=schedule&action=register" class="rakugo" style="position: relative; float: right; right: 10px; top: 20px;"><?php echo $rLanguage->text("Register Event"); ?></a><?php } ?> 
</div>

<div style="float: left; min-height: 700px; width: 790px; margin-left: 30px;" id="event_list_content">
<table class="rakugo schedule-list" style="float: left; margin-left: 0px; position: relative; top: -2px; border: 0.2em solid #000;" width = 790>
    <thead>
        <tr>
            <th width=130 class="date"><?php echo $rLanguage->text("date"); ?></th>
            <th width=100 class="time"><?php echo $rLanguage->text("time"); ?></th>
            <th width=250><?php echo $rLanguage->text("title"); ?></th>
            <th width=140><?php echo $rLanguage->text("performer"); ?></th>
            <th width=0 style = "position: absolute; left: -9999px;"></th>
            <th width=140><?php echo $rLanguage->text("meeting place"); ?></th>            
            <?php
                if($user_type == ADMINISTRATOR) echo '<th width=100>' . $rLanguage->text("edit, delete") . '</th>';
                else echo '<th width=100>' . $rLanguage->text("nearest") . '</th>';
            ?>
            <th width=0 style = "position: absolute; left: -9999px;">post</th>
            <th width=0 style = "position: absolute; left: -9999px;">open</th>
        </tr>
    </thead>

    <tbody>
            <?php
                $list_event = getResultSet("SELECT event_id, event_title, event_post, event_open, event_curtain FROM tbl_event WHERE event_status = 1");
                while($event = mysql_fetch_array($list_event)){
                    $event = new schedule($event[0]);
                    $event->search_row($user_type);
                }
            ?>
    </tbody>
</table>
</div>
</td></tr>
</table>
</center>
<div style="position: absolute; left: -9999px;">
    <div id="confirm_delete"><?php echo $rLanguage->text("are you sure want to delete this?"); ?></div>
</div>
<?php echo '<script type="text/javascript" src="' . HTTP_DOMAIN . 'application/rakugo-schedule/js/schedule-search.js"></script>'; ?>

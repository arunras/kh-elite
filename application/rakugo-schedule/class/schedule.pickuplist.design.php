<?php
    $rLanguage = CheckLanguageChange();
?>
<center>
<table class="rakugo schedule-list" style="margin-bottom: 20px;" width = 900>
    <thead>
        <tr>
            <th><?php echo $rLanguage->text("choice"); ?></th>
            <th><?php echo $rLanguage->text("date"); ?></th>
            <th><?php echo $rLanguage->text("time"); ?></th>
            <th><?php echo $rLanguage->text("title"); ?></th>
            <th><?php echo $rLanguage->text("performer"); ?></th>
            <th><?php echo $rLanguage->text("meeting place"); ?></th>
        </tr>
    </thead>

    <tbody>
            <?php
                $list_event = getResultSet("SELECT event_id, event_title, event_post, event_open, event_curtain FROM tbl_event WHERE event_status = 1");
                while($event = mysql_fetch_array($list_event)){
                    $event = new schedule($event[0]);
                    $event->pickup_row();
                }
            ?>
    </tbody>
</table>
</center>
<?php echo '<script type="text/javascript" src="' . HTTP_DOMAIN . 'application/rakugo-schedule/js/pickup.js"></script>';?>
<?php echo '<link type="text/css" rel="stylesheet" href="' . HTTP_DOMAIN . 'application/rakugo-schedule/css/datatable.css" />'; ?>
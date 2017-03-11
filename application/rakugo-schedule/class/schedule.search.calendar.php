<?php
    /*
    *  By: Leang Seang Ou
    */
    echo '
    <link rel="stylesheet" href="' . HTTP_DOMAIN . 'application/_fullcalendar/fullcalendar_customize.css" type="text/css"/>
    <link rel="stylesheet" href="' . HTTP_DOMAIN . 'application/_fullcalendar/fullcalendar.print.css" type="text/css"/>
    ';
    $rLanguage = CheckLanguageChange();
    $user_type = getUserType();
?>




<center>
<table style="float: left;">
<tr>
    <td class="top" rowspan="2" style="width: 260px;">
      <div class="span-6" style="padding-right: 10px;">
          <?php
              echo '<form id="filter_calendar">';
              search_filter_panel();
              echo '</form>';
          ?>
      </div>
    </td>
    <td>
        <span style="float: left; margin-left: 26px;"><?php echo $rLanguage->text("switch type"); ?>:</span>
        <a href="?page=schedule&action=search" class="rakugo" style="float: left; margin-left: 5px;"><?php echo $rLanguage->text("list view"); ?> </a>
        <span style="float: left; margin-left: 5px;">/</span>
        <span style="float: left; margin-left:5px;"><?php echo $rLanguage->text("calendar view"); ?></span>
    </td>
</tr>
<tr>
<td>
<div class="schedule-search-calendar-title" style="margin-left: 26px;">
<?php if($user_type == ADMINISTRATOR || $user_type == PERFORMER){ ?><a href="?page=schedule&action=register" class="rakugo" style="position: relative; float: right; right: 10px; top: 20px;"><?php echo $rLanguage->text("Register Event"); ?></a><?php } ?>
</div>

<div id="navigate_date" style="float: right;">
    <a href="#" onclick="return false;" id="prev_month" class="rakugo" style="float: left; margin-left: 10px;"><?php echo $rLanguage->text("previous month"); ?></a>
    <a href="#" onclick="return false;" id="today_month" class="rakugo" style="float: left; margin-left: 10px;"><?php echo $rLanguage->text("this month"); ?></a>
    <a href="#" onclick="return false;" id="next_month" class="rakugo" style="float: left; margin-left: 10px;"><?php echo $rLanguage->text("next month"); ?></a>
</div>

<div style="float: right;" id="event_calendar_content">
<div id='calendar'></div>
</div>
</td></tr>
</table>
<!--<div class="span-full" style="width: 1080px; height: 20px; float: left;"></div>-->
</center>

<?php echo '<script type="text/javascript" src="' . HTTP_DOMAIN . 'application/rakugo-schedule/js/schedule-search-calendar.js"></script>'; ?>
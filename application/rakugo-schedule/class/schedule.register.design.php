<?php
    if(getUserType() != ADMINISTRATOR){
        echo '<script type="text/javascript">window.location = "' . HTTP_DOMAIN . '"</script>';
    }
    $today = to_date_display(date("Y") . "-" . date("m"). "-" . date("d"));
?>
<form id="register-event" action="<?php echo HTTP_DOMAIN; ?>application/rakugo-schedule/insert_event.php" method="post">
<div class="span-full last" style="display: block; width: 1080px; margin-top: -20px;">

    <input type = text value = "" name="sc-title" class = "schedule-title" id = "title" size = 40 />

    <table cellpadding=5 width=700 class="schedule_input">
        <tbody>
            <tr>
                <td width = 150 style="background: #B2B27F"><?php echo $this->rLanguage->text("date and time"); ?></td>
                <td class="input">
                    <div class="span-8"><label style="width: 50px; float: left; margin-top: 7px;"><?php echo $this->rLanguage->text("date"); ?></label><input name="sc-date" type="text" class="span-4" id="schedule_registration_date" value="<?php echo $today; ?>" size=18/></div>
                    <div class="span-8"><label style="width: 50px; float: left; margin-top: 7px;"><?php echo $this->rLanguage->text("open"); ?></label><input name = "sc-open" class="span-4" type="text" id="schedule_registration_open_time" value="12:00PM" size=18 /></div>
                    <div class="span-8"><label style="width: 50px; float: left; margin-top: 7px;"><?php echo $this->rLanguage->text("perform"); ?></label><input name = "sc-finish" class="span-4" type="text" id="schedule_registration_finish_time" size=18 value="12:00PM"/></div>
<!--                    <div class="span-8"><label style="width: 50px; float: left; margin-top: 7px;"><?php echo $this->rLanguage->text("price"); ?></label><input name = "sc-price" class="span-4" type="text" id="price" size=18 value=""/></div>-->
                </td>
            </tr>

            <tr>
                <td class="background" style="border-top: 1px solid #EDEDED; background: #B2B27F;"><?php echo $this->rLanguage->text("appearance"); ?></td>
                <td class="input">
                    <input type = text class="span-5" style="margin-left: 10px; /*width: 162px;padding-right: 20px;*/" value = "" id = "schedule_registration_performers" />
                    <div id="show_all_performers" class="small_button">...</div>
                    <?php
                        //$this->select_performers("schedule_registration_performers");
                    ?>
                    <div class="span-3" style="float: right; margin-top: 5px; width: 146px;">
                        <div class="button pink" style="float: right; display: block;" id="add_performer"><label style="width: 100px;"><?php echo $this->rLanguage->text("add performer"); ?></label><span></span></div>
                        <div class="button pink" style="float: right; display: block;" id="delete_performer"><label style="width: 100px;"><?php echo $this->rLanguage->text("delete performer"); ?></label><span></span></div>
                    </div>
                    <ul class="schedule-register-performer-list"></ul>
                </td>
            </tr>
            <tr>
                <td class="background" style="border-top: 1px solid #EDEDED; background: #B2B27F;"><?php echo $this->rLanguage->text("reference"); ?></td>
                <td class="input">
                    <input name="reference" type = text class="span-5 theater_items" style="margin-left: 10px;" value = "" id = "reference" />
                </td>
            </tr>
            <tr>
                <td class="background" style="border-top: 1px solid #EDEDED; background: #B2B27F;"><?php echo $this->rLanguage->text("meeting place"); ?></td>
                <td class="input">
                    <input type = text class="span-5" style="margin-left: 10px;" value = "" id = "schedule-registration-theaters" name="schedule-registration-theaters"/>
                    <div id="show_all_theaters" class="small_button">...</div>
                    <div id="register_theater" class="small_button"><?php echo $this->rLanguage->text("add to master"); ?></div>
<!--                    <div id="update_theater" class="small_button"><?php echo $this->rLanguage->text("update master"); ?></div>-->
                    <?php //$this->select_theaters("register", "schedule-registration-theaters"); ?>
                    <input type = hidden id = "theaterid" name="theaterid" />
                </td>
            </tr>
            <tr>
                <td class="background" style="border-top: 1px solid #EDEDED; background: #B2B27F;"><?php echo $this->rLanguage->text("address"); ?></td>
                <td class="input">
                    <input type = text class="span-5 theater_items" style="margin-left: 10px;" value = "" id = "address" />
                </td>
            </tr>
            <tr>
                <td class="background" style="border-top: 1px solid #EDEDED; background: #B2B27F;"><?php echo $this->rLanguage->text("neighborhood station"); ?></td>
                <td class="input" style="border-bottom: none;">
                    <input type = text class="span-5 theater_items" style="margin-left: 10px;" value = "" id = "neighborhood" />
                </td>
            </tr>
            <tr>
                <td class="background" style="border-top: 1px solid #fff; background: #B2B27F;"><?php echo $this->rLanguage->text("price"); ?></td>
                <td  class="input" style="border-bottom: none;">
<!--                    <textarea name="sc-price" style="margin-left: 10px;"></textarea>-->
                    <input type = text name="sc-price" class="span-5" style="margin-left: 10px;" value = "" />
                </td>
            </tr>
            <tr>
                <td class="background" style="border-top: 1px solid #fff; background: #B2B27F;">
                    <?php echo $this->rLanguage->text("description"); ?>
                </td>
                <td class="input" style="border-bottom: none;">
                    <textarea style="margin-left: 10px;" name="txt_description" id="txt_description"><?php echo $this->getValue('event_description'); ?></textarea>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="button pink" style="float: left; margin-bottom: 20px; display: block;" id="register"><label style="width: 100px;"><?php echo $this->rLanguage->text("save event"); ?></label><span></span></div>

</div>
</form>

<span style="position: absolute; left: -9999px;" id="error_title"><?php echo $this->rLanguage->text("invalid title"); ?></span>
<span style="position: absolute; left: -9999px;" id="error_theater"><?php echo $this->rLanguage->text("invalid theater"); ?></span>
<span style="position: absolute; left: -9999px;" id="error_performer"><?php echo $this->rLanguage->text("performer require"); ?></span>
<span style="position: absolute; left: -9999px;" id="confirm_sure"><?php echo $this->rLanguage->text("Are you sure?"); ?></span>
<?php
    echo '<script type="text/javascript" src="' . HTTP_DOMAIN . 'application/rakugo-schedule/js/schedule.js"></script>';
?>
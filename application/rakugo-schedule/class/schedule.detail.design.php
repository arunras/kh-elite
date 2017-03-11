<div class="span-full last" style="display: block; width: 1080px;">
<table style="width: 100%;">
<tr><td>

    <div style="width: 500px; border-bottom: 3px solid #000; margin-bottom: 5px; display: inline-block;">
    <div class="info" id="title"><?php echo $this->getValue("event_title"); ?></div>
    </div>
    <table cellpadding=10 width=500 class="schedule_input">
        <tbody>
            <tr>
                <td width = 200 style="background: #B2B27F;"><?php echo $this->rLanguage->text("date and time"); ?></td>
                <td class="input">
                    <div class="span-8"><label style="width: 50px; float: left; margin-top: 10px;"><?php echo $this->rLanguage->text("date"); ?></label><div class="info"><?php echo to_date_display($this->getValue("event_post")); ?></div></div>
                    <div class="span-8"><label style="width: 50px; float: left; margin-top: 10px;"><?php echo $this->rLanguage->text("open"); ?></label><div class="info"><?php echo to_time_display($this->getValue("event_open")); ?></div></div>
                    <div class="span-8"><label style="width: 50px; float: left; margin-top: 10px;"><?php echo $this->rLanguage->text("perform"); ?></label><div class="info"><?php echo to_time_display($this->getValue("event_curtain")); ?></div></div>
<!--                    <div class="span-8"><label style="width: 50px; float: left; margin-top: 7px;"><?php echo $this->rLanguage->text("price"); ?></label><div class="info"><?php echo $this->getValue("event_price"); ?></div></div>-->
                </td>
            </tr>

            <tr>
                <td class="background" style="border-top: 1px solid #EDEDED; background: #B2B27F;"><?php echo $this->rLanguage->text("appearance"); ?></td>
                <td class="input">
                    <!--<ul class="schedule-register-performer-list" style="border: none;"></ul>-->
                    <?php
                        echo $this->list_performers_names("detail");
                    ?>
                </td>
            </tr>
            <tr>
                <td class="background" style="border-top: 1px solid #EDEDED; background: #B2B27F;"><?php echo $this->rLanguage->text("reference"); ?></td>
                <td class="input">
                    <div class="info"><?php echo $this->theater->getValue("theater_phone"); ?></div>
                </td>
            </tr>
            <tr>
                <td class="background" style="border-top: 1px solid #EDEDED; background: #B2B27F;"><?php echo $this->rLanguage->text("meeting place"); ?></td>
                <td class="input">
                    <div class="info"><?php echo $this->theater->getValue("theater_name"); ?></div>
                </td>
            </tr>
            <tr>
                <td class="background" style="border-top: 1px solid #EDEDED; background: #B2B27F;"><?php echo $this->rLanguage->text("address"); ?></td>
                <td class="input">
                    <div class="info"><?php echo $this->theater->getValue("theater_address"); ?></div>
                </td>
            </tr>
            <tr>
                <td class="background" style="border-top: 1px solid #EDEDED; background: #B2B27F;"><?php echo $this->rLanguage->text("neighborhood station"); ?></td>
                <td class="input" style="border-bottom: none;">
                    <div class="info"><?php echo $this->theater->getValue("theater_nearest"); ?></div>
                    <input type=hidden id="theater_id" value="<?php echo $this->theater->primary_key_value; ?>" />
                    
                    <?php
                        $lat = $this->theater->getValue("latitude");
                        $long = $this->theater->getValue("longitude");
                    ?>
                    
                    <input type=hidden id="address" value="<?php echo $this->theater->getValue("theater_address"); ?>" />
                    <input type=hidden id="lat" value="<?php echo $lat ?>" />
                    <input type=hidden id="lng" value="<?php echo $long; ?>" />
                </td>
            </tr>
            
            <tr>
                <td class="background" style="border-top: 1px solid #fff; background: #B2B27F;"><?php echo $this->rLanguage->text("price"); ?></td>
                <td class="input" style="border-bottom: none;">
                    <div class="info"><?php echo nl2br($this->getValue("event_price")); ?></div>
                </td>
            </tr>
            <tr>
                <td class="background" style="border-top: 1px solid #fff; background: #B2B27F;">
                    <?php echo $this->rLanguage->text("description"); ?>
                </td>
                <td  class="input" style="border-bottom: none;">
                    <div class="info"><?php echo $this->getValue('event_description'); ?></div>
                </td>
            </tr>
        </tbody>
    </table>

    <?php
        $ut = getUserType();
        if($ut == ADMINISTRATOR){
            echo '<a href="?page=schedule&action=edit&id=' . $this->id . '" class="button pink" style="float: left; margin-top: 2px;"><label style="width: 50px;">' . $this->rLanguage->text("edit") . '</label><span></span></a>';
            echo '<div class="button pink" style="float: left; margin-bottom: 20px;" id="delete_schedule" schedule="' . $this->id . '"><label style="width: 50px;">'. $this->rLanguage->text("delete") . '</label><span></span></div>';
        }
        /*else if($ut == PERFORMER){
            echo '<a href="?page=schedule&action=edit&id=' . $this->id . '" class="button pink" style="float: left;"><label style="width: 50px;">' . $this->rLanguage->text("edit") . '</label><span></span></a>';
        }*/ 
      
    ?>  
            
    </td>        
<td>
<?php
	$run_direction = $lat.','.$long.'('.$this->theater->getValue("theater_name").')';
	echo '<div class="map_direction">';
    	echo "<a href='http://maps.google.co.jp/maps?saddr=&daddr=$run_direction' target='_new'>".$this->rLanguage->text("Get Directions")."</a>";//Tokyo, Japan
    echo '</div>';
?>
<div id="map_canvas" style="width: 540px; height: 500px; border: 1px solid; float: right;"></div>
<input type="hidden" id="u_edit" value="<?php echo ($ut == ADMINISTRATOR) ? "true" : "false" ; ?>" />
<?php
    if($ut == ADMINISTRATOR){ echo'<div class="button pink" style="float: right; margin: 10px 0 10px 0;" onclick="save_map()"><label style="width: 100px;">' . $this->rLanguage->text("save") . '</label><span></span></div>';}
?>
<div id="save_map_result" style="float: right; margin: 20px 30px 0 0; color: #DF6060;"></div>
</td>
</tr>
</table>
    
</div>
<div style="position: absolute; left: -9999px;" id="txt_description"></div>



<?php
echo '<input type=hidden id="confirm_delete" value="' . $this->rLanguage->text("are you sure want to delete this?") . '">';
echo '
<script type="text/javascript" src="' . HTTP_DOMAIN . 'application/rakugo-schedule/js/load_map.js"></script>
';

if($ut == ADMINISTRATOR)
    echo '<script type="text/javascript" src="' . HTTP_DOMAIN . 'application/rakugo-schedule/js/schedule-edit.js"></script>';
?>
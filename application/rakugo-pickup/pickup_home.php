<?php
if(!defined(per_sub_path))define("per_sub_path",dirname(dirname(dirname(__FILE__))));
require_once(per_sub_path . "/module/module.php");

//require_once($_SERVER['DOCUMENT_ROOT']."/". ROOT. "/module/module.php");	


if(getCurrentUser()==0 || getUserType()!=ADMINISTRATOR){	
	//require_once($_SERVER['DOCUMENT_ROOT'] . "/rakugo/include/hacker.php");
	echo '<script type="text/javascript">';
		echo 'window.location.href="?page=index"';
	echo '</script>';
	exit();
}
?>
<style type="text/css">
a.btn
{
	text-decoration: none;
}
</style>

<table border="0" width="1080px" bgcolor="white" style="vertical-align:top">
<tr><td>
<h2 style="margin-left:170px"><?php echo $rLanguage->text("Pickup Management"); ?></h2>
<table border="0" align="center" width="850px" cellpadding="10" cellspacing="5" style="vertical-align:top">
	<tr bgcolor="#A1A012" align="center">
    	<th class="border-right-doth border-bottom-doth"width="15%" align="left"  bgcolor="white"></th>
        <th class="border-right-doth border-left-doth border-bottom-doth"width="25%" align="left"><?php echo $rLanguage->text("Registration Name"); ?></th>
        <th class="border-right-doth border-bottom-doth"width="35%" align="left"><?php echo $rLanguage->text("Pickup comment"); ?></th>
        <th class="border-right-doth border-bottom-doth"width="25%" align="left"><?php echo $rLanguage->text("Operation"); ?></th>
    </tr>
<?php
	$q_pickup = getResultSet("SELECT pickup_id, pickup_title, source_id, pickup_comment  FROM tbl_pickup");
	$i=0;
	while($rp = mysql_fetch_array($q_pickup))
	{
		$i++;
		$pickup_id = $rp['pickup_id'];
		$pickup_title = $rp['pickup_title'];
		$source_id = $rp['source_id'];
		
		//$source_type = $rp['source_type'];
		$pickup_comment = $rp['pickup_comment'];
		/*
		echo '<tr bgcolor="#EEEEEE">';
			echo '<td class="border-left-doth border-right-doth border-bottom-doth"width="20%" align="center" bgcolor="#A1A012" >Pickup'.$i.'</td>
        <td class="border-right-doth border-bottom-doth"width="25%"><label for="reg1" id="reg1" class="pickup_title'.$pickup_id.'">'.$pickup_title.'</label></td>
        <td class="border-right-doth border-bottom-doth"width="35%"><label for="comment1" id="comment1" class="commentdel'.$pickup_id.'">'.$pickup_comment.'</label></td>
        <td class="border-right-doth border-bottom-doth"width="25%" bgcolor="#A1A012">
		<a href="?page=pickup_schedule&action=pickup_list&pickupid='.$i.'"><div class="button" style="width:60px" align="center">Schedule</div></a><br>
		<a href="?page=pickup_performe&action=pickup_perlist&pickupid='.$i.'"><div class="button" style="width:60px" align="center">Performer</div></a><br>
	    <a value="Delete"><div class="button" style="width:60px" align="center" onclick="deletePickup('.$pickup_id.')">Delete</div></a>		
		</td>';
		echo '</tr>';
		*/
		echo '<tr bgcolor="#EEEEEE">';
			echo '<td class="border-left-doth border-right-doth border-bottom-doth"width="20%" align="center" bgcolor="#A1A012" >'.$rLanguage->text("Pickup").''.$i.'</td>';
        	echo '<td class="border-right-doth border-bottom-doth"width="25%"><label for="reg1" id="reg1" class="pickup_title'.$pickup_id.'">'.$pickup_title.'</label></td>';
			echo '<td class="border-right-doth border-bottom-doth"width="35%"><label for="comment1" id="comment1" class="commentdel'.$pickup_id.'">'.$pickup_comment.'</label></td>';
			echo '<td class="border-right-doth border-bottom-doth"width="25%" bgcolor="#A1A012">';
				echo '<a class="btn" href="?page=pickup_schedule&action=pickuplist&pickupid='.$i.'">';
					echo '<div class="button pink" style="float: left; margin-top: 5px;  border-radius: 5px; -moz-border-radius: 5px; -webkit-border-radius: 5px; border: 2px #FFF solid;"><label style="width: 80px;">'.$rLanguage->text("Schedule").'</label><span></span></div>';
				echo '</a><br>';
				echo '<a class="btn" href="?page=pickup_performe&action=pickup_perlist&pickupid='.$i.'">';
					echo '<div class="button pink" style="float: left; margin-top: 5px;  border-radius: 5px; -moz-border-radius: 5px; -webkit-border-radius: 5px; border: 2px #FFF solid;"><label style="width: 80px;">'.$rLanguage->text("Performer").'</label><span></span></div>';
				echo '</a><br>';
				echo '<a class="btn" value="Delete"><div class="button pink" style="float: left; margin-top: 5px;  border-radius: 5px; -moz-border-radius: 5px; -webkit-border-radius: 5px;  border: 2px #FFF solid;" onclick="deletePickup('.$pickup_id.')"><label style="width: 80px;">'.$rLanguage->text("Delete").'</label><span></span></div>';
				echo '</a>';		
			echo '</td>';
		echo '</tr>';
		//echo '<div class="button pink" style="float: left; margin-top: 5px;" onclick="deletePickup('.$pickup_id.')"><label style="width: 80px;">Delete</label><span></span></div>';
	}
?>
</table>
</td>
</tr>
</table>
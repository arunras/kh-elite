<?php
    //start session
    ob_start();
    if(!isset($_SESSION))session_start();
	$rLanguage =  CheckLanguageChange();
?>
<style type="text/css" title="currentStyle">
	<?php 
		echo '@import "'.HTTP_DOMAIN.'application/performer/css/s_performer.css";';
		echo '@import "'.HTTP_DOMAIN.'css/button_rakugo.css";';
	?>
</style>
<?php
	echo '<link type="text/css" rel="stylesheet" href="'.HTTP_DOMAIN.'application/rakugo-schedule/css/datatable.css" />';
	echo '<script type="text/javascript" language="javascript" src="'.HTTP_DOMAIN.'application/_datatable/js/jquery.dataTables.js"></script>';
	echo '<script type="text/javascript" language="javascript" src="'.HTTP_DOMAIN.'application/rakugo-pickup/js/j_pickupperlist.js"></script>';
	//echo '<script type="text/javascript" charset="utf-8">';
?>

<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/". ROOT. "/application/performer/class/performer.class.php");

//display_PickupPerList();
//function display_PickupPerList(){

		echo '<div class="list_performer">';
		echo '<table border="0px" width="1080px">';
			echo '<tr>';
				echo '<td align="center" valign="middle">';
					echo '<table border="0px" width="750px">';
                        echo '<tr>';
							echo '<td align="right" valign="middle" width="120px"><div style="font-size: 25px; margin: 5px 0px 0px 0px;">'.$rLanguage->text("Search").'</div></td>';
							echo '<td align="center" width="400px"><input type="text" id="search_performer" style="width: 100%; height: 30px; margin-top: 5px;"></td>';
							echo '<td align="center" width="170px"><div class="btn_search"></div></td>';
						echo '</tr>';
					echo '</table>';
				echo '</td>';
			echo '</tr>';
			
			echo '<tr>';
				echo '<td style="padding-left: 30px;">';
					//echo '<span class="label">List Performer</span>';
					/*
					echo '<div class="title_list">
							<img src="images/button_rakugo/title_list.jpg" width="100%"/>
						  </div>';
					*/
					$q_performer_id = getResultSet("SELECT performer_id, group_id FROM tbl_performer");
			//echo '<div id="dt_example">';
				//echo '<div id="container">';
					//echo '<div class="demo_jui datatable">';

					echo '<table border="0" cellpadding="0" cellspacing="0" class="display rakugo schedule-list" style="border: 0.2em solid #000; width: 100%;" id="ipickupperformerlist">';
						echo '<thead>
							<tr style="height: 28px;">
								<th>'.$rLanguage->text("Choice").'</th>
								<th>'.$rLanguage->text("Comic storyteller name").'</th> <!-- style="border:none;" -->
								<th>'.$rLanguage->text("Hometown").'</th>
								<th>'.$rLanguage->text("Theme Song").'</th>
								<th>'.$rLanguage->text("Best Story").'</th>
							</tr>';
						echo '</thead>';
						echo '<tbody>';
							while($ri = mysql_fetch_array($q_performer_id))
							{
								$per_id = $ri['performer_id'];
								$per_group = $ri['group_id'];
								$per = new performer($per_id);
								
								//$group_name = getValue("SELECT group_name FROM tbl_group WHERE group_id=". $per_group);
								if($per->getPerUserType()!="administrator"){
								echo '<tr class="gradeA" id="'.$per_id.'">';
									echo '<td align="center" class="radio_action"><input type="radio" id="' . $per_id . '" name="choice_event_pickup" /></td>';	
									echo '<td class="per_name">' . $per->getPerName() . '</td>';
									echo '<td align="center">'.$per->getPerHometown().'</td>';
									echo '<td align="center">'.$per->getPerSong().'</td>';
									echo '<td align="center">'.$per->getPerStory().'</td>';
								echo '</tr>';
								}
							}		
						echo '</tbody>';
					echo '</table>';
				//echo '</div>';
			//echo '</div>';
		//echo '</div>';
					//****************************************************************//
				echo '</td>';
			echo '</tr>';
		echo '</table>';
		echo '</div>';
//}
?>
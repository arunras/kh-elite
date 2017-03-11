<?php
    //start session
    ob_start();
    if(!isset($_SESSION))session_start();
?>
<style type="text/css" title="currentStyle">
			/*@import "application/_datatable/css/tb_screen.css";*/
			<?php
				echo '@import "'.HTTP_DOMAIN.'application/performer/css/s_performer.css";';
				echo '@import "'.HTTP_DOMAIN.'css/button_rakugo.css";';
			?>
			/*
			@import "application/_datatable/css/demo_page.css";
			@import "application/_datatable/css/demo_table_jui.css";
			@import "application/_datatable/css/jquery-ui-1.8.4.custom.css";
			*/
</style>
<?php
	echo '<link type="text/css" rel="stylesheet" href="'.HTTP_DOMAIN.'application/rakugo-schedule/css/datatable.css" />';
	echo '<script type="text/javascript" language="javascript" src="'.HTTP_DOMAIN.'application/_datatable/js/jquery.dataTables.js"></script>';
	echo '<script type="text/javascript" language="javascript" src="'.HTTP_DOMAIN.'application/performer/js/j_perlist.js"></script>';

require_once($_SERVER['DOCUMENT_ROOT'] . "/". ROOT. "/application/performer/class/performer.class.php");

//display_ListPerformer();
//function display_ListPerformer(){

		echo '<div class="list_performer">';
		echo '<table width="1080px">';
			echo '<tr>';
				echo '<td width="20%">';
					echo '<table border="0" width="200px">';
						echo '<tr><td><div class="btn_search_condition"></div></td></tr>';
						//echo '<tr><td align="center"><div class="lbl_search"></div></td></tr>';
						//echo '<tr><td><input type="text" name="persearch" class="txt_search"/></td></tr>';

                        /* input for searching datatable */
                        echo '<tr><td align="center" style="padding-top: 2px;"><input type="text" id="search_performer"></td></tr>';


						echo '<tr><td align="left">
						<span class="tip">※噺家名、亭号、ネタなど</span></td></tr>';
						//btn_search
						echo '<tr><td align="center"><div class="btn_search" style="margin: 10px 0px 20px 0px;"></div></td></tr>';
						echo '<tr><td></td></tr>';
						echo '<tr><td><input type="hidden" id="isGroupSearch" name="sGroupSearch" /></td></tr>';
							echo '<tr><td><input type="hidden" id="isPositionSearch" name="sPositionSearch" /></td></tr>';
						echo '<tr><td><div class="nar_label">'.$rLanguage->text("Narrowing Condition").'</div></td></tr>';

						$q_group = getResultSet("SELECT group_id, group_name FROM tbl_group");
						$q_position = getResultSet("SELECT position_id, position_name FROM tbl_position");
						//$q_group_id = getResultSet("SELECT performer_id, per_group FROM tbl_performer");
						while($rg = mysql_fetch_array($q_group))
						{
							$group_id = $rg['group_id'];
							$group_name = $rg['group_name'];
							echo '<tr><td><div class="narrow">'; //onClick="checkGroup('.$group_id.')"
								echo '<input type="checkbox" id="'.$group_id.'" name="n'.$group_id.'" value="'.$group_id.'" class="group_filter" />';
								echo $group_name; //for="'.$group_id.'"
							echo '</div></td></tr>';
						}
						echo '<tr height="15px"><td></td></tr>';
						while($rp = mysql_fetch_array($q_position))
						{
							$position_id = $rp['position_id'];
							$position_name = $rp['position_name'];
							echo '<tr><td><div class="narrow">'; //onClick="checkGroup('.$position_id.')"
								echo '<input type="checkbox" id="'.$position_id.'" name="n'.$position_id.'" value="'.$position_id.'" class="position_filter" />';
								echo $position_name; //for="'.$position_id.'"
							echo '</div></td></tr>';
						}
					echo '</table>';
				echo '</td>';
				echo '<td style="padding-left: 30px;">';
					//echo '<span class="label">List Performer</span>';
					echo '<div class="title_list">
							<img src="'.HTTP_DOMAIN.'images/button_rakugo/title_list.jpg" width="100%"/>
						  </div>';
					$q_performer_id = getResultSet("SELECT performer_id, group_id FROM tbl_performer");
			//echo '<div id="dt_example">';
				//echo '<div id="container">';
					//echo '<div class="demo_jui datatable">';

					echo '<table border="0" cellpadding="0" cellspacing="0" class="display rakugo schedule-list" style="border: 0.2em solid #000; width: 100%;" id="ilistperformer">';
						echo '<thead>
							<tr style="height: 28px;">
								<th>'.$rLanguage->text("Comic storyteller name").'</th> <!-- style="border:none;" -->
								<th>'.$rLanguage->text("Hometown").'</th>
								<th>'.$rLanguage->text("Theme Song").'</th>
								<th>'.$rLanguage->text("Best Story").'</th>
								<th style="display: none;">'.$rLanguage->text("Group").'</th>
								<th style="display: none;">'.$rLanguage->text("Postion").'</th>
							</tr>';//style="border:none; display: none;" //style="display: none;"
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
									echo '<td class="per_name">'.$per->getPerName().'</td>';
									echo '<td align="center">'.$per->getPerHometown().'</td>';
									echo '<td align="center">'.$per->getPerSong().'</td>';
									echo '<td align="center">'.$per->getPerStory().'</td>';
									echo '<td style="display: none;">'.$per->getPerGroupId().'</td>';//style="display: none;"
									echo '<td style="display: none;">'.$per->getPerPositionId().'</td>';//style="display: none;"
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
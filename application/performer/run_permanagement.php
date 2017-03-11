<?php
    //start session
    ob_start();
    if(!isset($_SESSION))session_start();
	
	if(!defined(per_sub_path))define("per_sub_path",dirname(dirname(dirname(__FILE__))));
	require_once(per_sub_path . "/module/module.php");
	//require_once($_SERVER['DOCUMENT_ROOT']."/". ROOT. "/module/module.php");
	if(getCurrentUser()==0 || getUserType()!=ADMINISTRATOR){ //getCurrentUser()!=$_GET['perid'] ||	
		//require_once($_SERVER['DOCUMENT_ROOT'] . "/rakugo/include/hacker.php");
		echo '<script type="text/javascript">';
			echo 'window.location.href="?page=index"';
		echo '</script>';
		exit();
	}
	
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
require_once($_SERVER['DOCUMENT_ROOT'] ."/". ROOT. "/application/performer/class/performer.class.php");

//display_PickupPerList();
//function display_PickupPerList(){

		echo '<div class="list_performer">';
		echo '<table border="0px" width="1080px">';
			echo '<tr>';
				echo '<td align="center" valign="middle">';
					echo '<h2 style="margin-bottom: 0px;">'.$rLanguage->text("Performer Management").'</h2>';
				echo '</td>';
			echo '</tr>';
			echo '<tr >';
				echo '<td align="right" height="25px">';
					echo '<a href="?page=perregistration" class="rakugo">'.$rLanguage->text("Add New Performer").'</a>';
				echo '</td>';
			echo '</tr>';
			
			echo '<tr>';
				echo '<td style="padding-left: 30px;">';
					//echo '<span class="label">List Performer</span>';
					/*
					echo '<div class="title_list">
							<img src="'.HTTP_DOMAIN.'images/button_rakugo/title_list.jpg" width="100%"/>
						  </div>';
					*/
					$q_performer_id = getResultSet("SELECT performer_id, group_id, per_user_type FROM tbl_performer");
			//echo '<div id="dt_example">';
				//echo '<div id="container">';
					//echo '<div class="demo_jui datatable">';

					echo '<table border="0" cellpadding="0" cellspacing="0" class="display rakugo schedule-list" style="border: 0.2em solid #000; width: 100%;" id="ipickupperformerlist">';
						echo '<thead>
							<tr style="height: 28px;">
								<th>'.$rLanguage->text("Comic storyteller name").'</th>
								<th>'.$rLanguage->text("Occupation").'</th>
								<th>'.$rLanguage->text("TEI suffix").'</th>
								<th>'.$rLanguage->text("Social Position").'</th>
								<th>'.$rLanguage->text("Group").'</th>
								<th>'.$rLanguage->text("Email").'</th>
								<th>'.$rLanguage->text("edit, delete").'</th>
							</tr>';
						echo '</thead>';
						echo '<tbody>';
							while($ri = mysql_fetch_array($q_performer_id))
							{
								$per_id = $ri['performer_id'];
								$per_group = $ri['group_id'];
								$user_type = $ri['per_user_type'];
								$per = new performer($per_id);
								
								//$group_name = getValue("SELECT group_name FROM tbl_group WHERE group_id=". $per_group);
								echo '<tr class="gradeA" id="'.$per_id.'">';
									echo '<td class="per_name">' . $per->getPerName() . '</td>';
									echo '<td>';
										echo '<select name="occupation" onChange="update_occupation('.$per_id.',this.options[this.selectedIndex].value)">';
											$q_occupation = getResultSet("SELECT occupation_id, occupation FROM tbl_occupation");
											echo '<option selected="selected" value="'.$per->getPerOccupationId().'">'.$per->getPerOccupation().'</option>';
											while($ro = mysql_fetch_array($q_occupation))
											{
												$occupation_id = $ro['occupation_id'];
												$occupation_name = $ro['occupation'];
												echo '<option value="'.$occupation_id.'">'.$occupation_name.'</option>';	
											}
										echo '</select>';
									echo '</td>';
									echo '<td>';
										echo '<select name="teisuffix" onChange="update_teisuffix('.$per_id.',this.options[this.selectedIndex].value)">';
											$q_suffix = getResultSet("SELECT teisuffix_id, teisuffix FROM tbl_teisuffix");
											echo '<option selected="selected" value="'.$per->getPerTeisuffixId().'">'.$per->getPerTeisuffix().'</option>';
											while($rs = mysql_fetch_array($q_suffix))
											{
												$teisuffix_id = $rs['teisuffix_id'];
												$teisuffix = $rs['teisuffix'];
												echo '<option value="'.$teisuffix_id.'">'.$teisuffix.'</option>';	
											}
										echo '</select>';
									echo '</td>';
									echo '<td>';
										echo '<select name="socialposition" onChange="update_position('.$per_id.',this.options[this.selectedIndex].value)">';
											$q_position = getResultSet("SELECT position_id, position_name FROM tbl_position");
											echo '<option selected="selected" value="'.$per->getPerPositionId().'">'.$per->getPerPosition().'</option>';
											while($rp = mysql_fetch_array($q_position))
											{
												$position_id = $rp['position_id'];
												$position_name = $rp['position_name'];
												echo '<option value="'.$position_id.'">'.$position_name.'</option>';	
											}
										echo '</select>';
									echo '</td>';
									echo '<td align="center">'.$per->getPerGroup().'</td>';
									echo '<td align="center">'.$per->getPerEmail().'</td>';
									echo '<td align="center">';										
										//echo '<input type="button" value="'.$rLanguage->text("Delete").'" onclick="delete_performer('.$per_id.')">';
										//echo '<a href="?page=perprofileedit&perid='.$per_id.'"><input type="button" value="'.$rLanguage->text("Edit").'"></a>';
										echo '<a href="?page=perprofileedit&perid='.$per_id.'" class="rakugo" style="float: left; display: inline-block; margin-right: 5px;">' . $rLanguage->text("Edit") . '</a>';
										if($user_type!='administrator'){
										echo '<a href="#" class="rakugo"  onclick="delete_performer('.$per_id.')">' . $rLanguage->text("Delete") . '</a>';
										}
									echo '</td>';
								echo '</tr>';
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
<?php
if(!defined("master_path"))define("master_path", dirname(dirname(dirname(__FILE__))));
require_once(master_path . "/module/module.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/". ROOT ."/application/master_table/class/master_table.class.php");


/*if(getCurrentUser()==0 || getUserType()!=ADMINISTRATOR){ 
		require_once($_SERVER['DOCUMENT_ROOT'] . "/rakugo/include/hacker.php");
	}
*/
if(getCurrentUser()==0 || getUserType()!=ADMINISTRATOR){
	echo '<script type="text/javascript">';
	echo 'window.location.href="?page=index"';
	echo '</script>';
	exit();
//require_once($_SERVER['DOCUMENT_ROOT'] . "/rakugo/include/hacker.php");
}

$master_table = new master_table();
$rLanguage = CheckLanguageChange() ;
if(!isset($_GET['type'])) {$display='occupation';}
else {
	$display = $_GET['type'];
}
	
 	switch($display) {
		
		case 'occupation':
			$master_table->table_name='tbl_occupation';
			$master_table->field_name_id ='occupation_id';
			$master_table->field_name_name ='occupation';
			
			$master_table->add_block($rLanguage->text("occupation"));
			$master_table->header_title($rLanguage->text("occupation"));
			break;
			
		case 'teisuffix':
			$master_table->table_name='tbl_teisuffix';
			$master_table->field_name_id ='teisuffix_id';
			$master_table->field_name_name ='teisuffix';
			
			$master_table->add_block($rLanguage->text("tei name"));
			$master_table->header_title($rLanguage->text("tei name"));
			break;
			
		case 'position':
			$master_table->table_name='tbl_position';
			$master_table->field_name_id ='position_id';
			$master_table->field_name_name ='position_name';
			
			$master_table->add_block($rLanguage->text("position"));
			$master_table->header_title($rLanguage->text("position"));
			break;
			
		case 'theater':
			$master_table->table_name='tbl_theater';
			$master_table->field_name_id ='theater_id';
			$master_table->field_name_name ='theater_name';
			$master_table->fn_address ='theater_address';
			$master_table->fn_phone ='theater_phone';
			$master_table->fn_image= 'theater_image';
			$master_table->fn_nearest ='theater_nearest';
			$master_table->fn_url = 'theater_url';
			$master_table->fn_latitude = 'latitude';
			$master_table->fn_longitude = 'longitude';
			
			$master_table->add_block($rLanguage->text("theater"));
			$master_table->add_block($rLanguage->text("address"));
			$master_table->add_block($rLanguage->text("reference"));
			$master_table->add_block($rLanguage->text("nearest"));
			$master_table->add_block($rLanguage->text("theater url"));
			
			$master_table->header_title($rLanguage->text("theater"));
			$master_table->header_title($rLanguage->text("banner"));
			$master_table->header_title($rLanguage->text("address"));
			$master_table->header_title($rLanguage->text("reference"));
			$master_table->header_title($rLanguage->text("nearest"));
			$master_table->header_title($rLanguage->text("theater url"));
			$master_table->header_title($rLanguage->text("top"));
			
			break;
			
			case 'group':
			$master_table->table_name='tbl_group';
			$master_table->field_name_id ='group_id';
			$master_table->fn_image='group_image';
			$master_table->field_name_name ='group_name';
			$master_table->fn_url ='group_url';
			
			$master_table->add_block($rLanguage->text("group"));
			$master_table->add_block($rLanguage->text("group url"));
			
			$master_table->header_title($rLanguage->text("group"));
			$master_table->header_title($rLanguage->text("banner"));
			$master_table->header_title($rLanguage->text("group url"));
			
			
			break;
	}
	
	if(!isset($_GET['action'])) {$action='display';}
	
	else {$action = $_GET['action']; }
	
	switch ($action) {
		case 'insert':
                    
			if($master_table->table_name=='tbl_theater'){
				
				$master_table->val_item[0]= $_POST['val_item1'];
				$master_table->val_item[1]= $_POST['val_item2'];
				$master_table->val_item[2]= $_POST['val_item3'];
				$master_table->val_item[3]= $_POST['val_item4'];
				$master_table->val_item[4]= $_POST['val_item5'];
                                $master_table->val_item[5]= $_POST['val_item6'];
                                $master_table->val_item[6]= $_POST['val_item7'];
                                
			}
                                
			elseif ($master_table->table_name=='tbl_group') {
				$master_table->val_item[0]= $_POST['val_item1'];
				$master_table->val_item[1]= $_POST['val_item2'];
			}
				
			else {
				$master_table->val_item[0] = $_POST['val_name'];
			}
                            
			if(isDuplicate($master_table->table_name, $master_table->field_name_name,$master_table->val_item[0], 'string')) {
                            echo 'error';
                            exit();
                        }
                        
			$master_table->insert_data();
				
			break;
			
		case 'insert_picture':
		
				//File
			
				$id = $_POST['t_g_id'];
				if ($master_table->table_name=='tbl_group'){ $file_path ="../master_table/group_images/".$id;
															 $type = 'group';
															}
				else {$file_path = "../master_table/theater_images/".$id;
					  
					  if(isset($_POST['show_on_top'])){
					  	$show_on_top = 1;
					  }
					  else {
					  	$show_on_top = 0;
					  }
					  
					  runSQL("UPDATE tbl_theater SET show_top=".$show_on_top." WHERE theater_id = ".$id);
					 
					  $type = 'theater';
					  }
					
					 //echo $file_path;
					//exit();
					$result=upload( "fl_pic",$file_path);
					
					$tem=explode(";",$result);
					$result=$tem[0];
					$target_path=$tem[1];
			
					if($result=="0"){
						$target_path = substr($target_path,3,strlen($target_path));
						$target_path = str_replace("../", "", $target_path);
						$target_path = str_replace("//", "/", $target_path);
						$sql="UPDATE ".$master_table->table_name." SET ".$master_table->fn_image." = '" . $target_path . "' WHERE ".$master_table->field_name_id." = " . $id;				
						
					runSQL($sql);
					
					}
					/* close ja */
					$language_session = $_SESSION['language_selected'];
					if($language_session == 'ja') { $language_session ='';}
					
					header("location:../../" . $language_session. "?page=master&action=display&type=".$type);
			break;
			
		case 'delete':
			$master_table->delete($_GET['val_id']);
			break;
		
		case'display': $master_table->display();
			break;
			
		case 'edit':
			
			if($master_table->table_name=='tbl_theater'){
				$master_table->edit_val[0]= $_POST['edit_name'];
				$master_table->edit_val[1]= $_POST['edit_address'];
				$master_table->edit_val[2]= $_POST['edit_phone'];
				$master_table->edit_val[3]= $_POST['edit_nearest'];
				$master_table->edit_val[4]= $_POST['edit_url'];
                                $master_table->edit_val[5]= $_POST['edit_latitude'];
                                $master_table->edit_val[6]= $_POST['edit_longitude'];
				$master_table->edit_id= $_POST['edit_id'];
				
				}
			elseif($master_table->table_name=='tbl_group') {
		
				$master_table->edit_val[0]= $_POST['edit_name'];
				$master_table->edit_val[1]= $_POST['edit_url'];
				$master_table->edit_id = $_POST['edit_id'];
			}
				
			else {
				$master_table->edit_val[0] = $_POST['edit_name'];
				$master_table->edit_id = $_POST['edit_id'];
				
			}
                        
                        if(getValue("SELECT COUNT(*) FROM " .$master_table->table_name." WHERE ".$master_table->field_name_name." = '".$master_table->edit_val[0]. "' AND ".$master_table->field_name_id." <> ".$master_table->edit_id)!= 0) {
                            echo 'error';
                            exit();
                        }
				$master_table->update_data();	
			
			break;
	}
?>
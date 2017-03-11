<?php

	class master_table{
		public $table_name;
		public $field_name_id;
		public $field_name_name;
		public $fn_address;
		public $fn_phone ;
		public $fn_image;
		public $fn_nearest ;
		public $title_bar;
		public $val_item ;
		public $fn_url;
		public $table_head;
		public $edit_val;
		public $edit_id;
        public $fn_latitude;
        public $fn_longitude;		
		public $rLanguage;
		
		
		public function __construct(){
			$this->table_name = "";
			$this->field_name_id = "";
			$this->field_name_name = "";
			$this->fn_address = "";
			$this->fn_phone = "";
			$this->fn_image= "";
			$this->fn_nearest = "";
			$this->fn_url = "";
                        $this->fn_latitude="";
                        $this->fn_longitude= "";
			$this->rLanguage = CheckLanguageChange() ;
			$this->edit_id ="";
			
			$this->title_bar = array();
			$this->table_head = array();
			$this->val_item = array();
			$this->edit_val = array();
		}

		
		public function return_type() {
			$type = explode('_',$this->table_name);
			return $type[1];	
		}

		public function add_block($title){
			array_push($this->title_bar, $title);
		}
		public function header_title($header_name){
			array_push($this->table_head, $header_name);
		}

		/* draw row when registertration */ 
		public function add_registration(){
			
			$count = count($this->title_bar);
			echo'<table border="0" cellpadding="0" cellspacing="0" id="input_value" ><tr> ';
				for($i=0; $i<$count; $i++)
				{
					echo'<td>';
						
						echo '<table border="0" cellpadding="0" cellspacing="0">';
						echo '<tr><td class="o_menu_bar" height="30" '; if($count>2) {echo 'width="165"';} elseif($i==0 && $count==2){echo 'width="240"';} else {echo 'width="310"';}echo '>'.$this->title_bar[$i].'</td></tr>';
						echo '<tr><td><input type="text" id="'.$this->title_bar[$i].'" style="margin-top:0;'; if($count>2){echo 'width:163px;';} elseif($i==0 && $count==2) {echo 'width:238px;';} else { echo 'width:308px;';} echo '" class="o_text_input"/></td></tr>';
						echo '</table>';
					
					echo '</td>';
				}
				
			echo '</tr></table>';
			
			if($this->table_name=='tbl_group'||$this->table_name=='tbl_theater'){
				echo '<div style="height:30px;"><form action="' . HTTP_DOMAIN . 'application/master_table/master_table.php?action=insert_picture&type='.$this->return_type().'" method="post" id="upload_pic" enctype="multipart/form-data">';
				if($this->table_name=='tbl_theater'){
					echo '<div class="span-6">
                                                        <span class = "input_show_top " ><input type="checkbox" name="show_on_top" /></span>
							<span class=""> ' .$this->rLanguage->text("show on top page").'<span>
							
						 </div>';	
				}
					echo '<input type="file" id="fl_pic" name="fl_pic"/>';
					echo '<input type="hidden" value="2000000" name="MAX_FILE_SIZE"/>';
					echo '<input type="hidden" id="t_g_id" name ="t_g_id" />';
				echo '</form>';
				echo '</div>';
			  }
		}

		/* load data from database  */ 
		public function load_row(){

			$count_header = count($this->table_head);
			
			echo '<table border="0" class="rakugo" style="margin-top:10px;"'; if($count_header >=2) { echo 'width = " 853 " ' ; } echo ' id = "insert" >';
			echo '<thead><tr>';
			echo '<th width="40" >'.$this->rLanguage->text("choice").'</th>';
                        
			if($this->table_name=='tbl_theater') {
				$result_rs = getResultSet("SELECT " .$this->field_name_id.",".$this->field_name_name.",".$this->fn_image.",".$this->fn_address.",".$this->fn_phone.",".$this->fn_nearest." ,".$this->fn_url.", show_top FROM ".$this->table_name. " ORDER BY show_top DESC ");
				
				for($j=0; $j<$count_header; $j++){
					echo'<th ';
                                            if( $j == 0 ){
                                                echo 'class = "sort" ';
                                            }
                                            if($this->table_head[$j]==$this->rLanguage->text("top")){
                                                echo ' class="hide" ';
                                            }
                                            
                                            if($count_header>3) {echo ' width="140" ';} 
                                            else {echo' width="300"'; } echo '>'.$this->table_head[$j].'
                                        </th>';
				}
				
		    	echo '</tr></thead><tbody>';
				while($result_info = mysql_fetch_array($result_rs)){
	        		if($result_info[0]!="") {
                                        
					echo '<tr'; if($result_info[7] == 1) { echo ' class ="show_top" '; } echo '>';
						echo '
							<td  align="center" class="checkbox_choice">
								<input type="checkbox" id="'.$result_info[0].'"/> </td> ';
							for($a=1; $a<=$count_header; $a++){
								if($this->table_head[$a-1]==$this->rLanguage->text("banner") && $result_info[$a]!="" ) {
									echo '<td align="center"> <img src="'.HTTP_DOMAIN.'application/'.$result_info[$a].'" width="140" height="50" /> </td>';
									} 
								elseif(isValidURL($result_info[$a])) { echo '<td style="text-align:left !important;" > <a href="'.$result_info[$a].'" >'.$result_info[$a].'</a> </td>'; }
								elseif($this->table_head[$a-1]==$this->rLanguage->text("top")){
									echo '<td align="center" class="show_top_checkbox hide">';
										  echo'<input type="checkbox" onclick="return false" onkeydown="return false" '; if($result_info[$a]=="1"){ echo 'checked="checked"';} echo '/>';
									echo'</td> ';
								}
								else { echo'<td style = "text-align:left !important;" >'.$result_info[$a].'</td>'; }
								
							}
							
					echo '</tr>';
					}
				}// end while	
				exit;
				
			}
			elseif($this->table_name=='tbl_group') {
				$result_rs = getResultSet("SELECT " .$this->field_name_id. ",".$this->field_name_name.",".$this->fn_image. ",".$this->fn_url. " FROM ".$this->table_name);
				}
			else {
			
			$result_rs = getResultSet("SELECT " .$this->field_name_id. ",".$this->field_name_name." FROM ".$this->table_name);
			}

			for($j=0; $j<$count_header; $j++){
					echo'<th '; if( $j == 0 ){
                                                echo 'class = "sort" ';
                                            } if($count_header>3) {echo ' width="140" ';} else {echo' width="300"'; } echo '>'.$this->table_head[$j].'</th>';
			}
			
		    echo '</tr></thead><tbody>';
			while($result_info = mysql_fetch_array($result_rs)){
        		if($result_info[0]!="") {
				echo '<tr>';
					echo '
						<td align="center" class="checkbox_choice">
							<input type="checkbox" id="'.$result_info[0].'"/>
					        </td> ';
						for($a=1; $a<=$count_header; $a++){
							if($this->table_head[$a-1]==$this->rLanguage->text("banner") && $result_info[$a]!="" ) {
								echo '<td align="center"> <img src="'.HTTP_DOMAIN.'application/'.$result_info[$a].'" width="140" height="50" /> </td>';
								} 
							elseif(isValidURL($result_info[$a])) { echo '<td style="text-align:left !important;" > <a href="'.$result_info[$a].'" >'.$result_info[$a].'</a> </td>'; }	
							elseif($this->table_head[$a-1]==$this->rLanguage->text("top")){
								echo '<td align="center" class="checkbox_top" ><input type="checkbox" id=""/></td> ';
								
							}
							else { echo'<td style = "text-align:left !important;" >'.$result_info[$a].'</td>'; }
							
						}
				echo '</tr>';
				}
			}// end while
			echo '</tbody></table>';
		}

		/* insert data to database */
		public function insert_data(){
		
			if($this->table_name=='tbl_theater'){
				$lat_lng =  simplexml_load_file("http://www.geocoding.jp/api/?q=" . $this->val_item[1] . " " . $this->val_item[0]);
				foreach($lat_lng as $key => $value){
					if($key == "coordinate"){
						foreach($value as $label => $val){
							if($label == 'lat') $this->val_item[5] = $val;
							if($label == 'lng') $this->val_item[6] = $val;
						}
					}
				}

				runSQL("INSERT INTO ".$this->table_name."(" . $this->field_name_name.",".$this->fn_address.",".$this->fn_phone.",".$this->fn_nearest.",".$this->fn_url.",".$this->fn_latitude.",".$this->fn_longitude.") VALUES ('".$this->val_item[0]."','".$this->val_item[1]."','".$this->val_item[2]."','".$this->val_item[3]."','".$this->val_item[4]."',".$this->val_item[5].",".$this->val_item[6].") ");
				$id = mysql_insert_id();
				echo'<tr>';
				echo'<td align="center"><input type="checkbox" id="'.$id.'" /></td>
					 <td align="center">'.$this->val_item[0].'</td>
					 <td align="center">'.$this->val_item[1].'</td>
					 <td align="center">'.$this->val_item[2].'</td>
					 <td align="center">'.$this->val_item[3].'</td>
					 <td align="center">'.$this->val_item[4].'</td>';
					 
			   echo '</tr>';
			}
			elseif($this->table_name=='tbl_group') {
				runSQL("INSERT INTO ".$this->table_name."(" . $this->field_name_name.",".$this->fn_url.") VALUES ('".$this->val_item[0]."','".$this->val_item[1]."')");
				$id = mysql_insert_id();
				echo'<tr>';
				echo'<td align="center"><input type="checkbox" id="'.$id.'" /></td>
					 <td align="center">'.$this->val_item[0].'</td>
					 <td align="center">'.$this->val_item[1].'</td>';
			   echo '</tr>';
			}

			else { runSQL("INSERT INTO ".$this->table_name." (".$this->field_name_name.") VALUES('".$this->val_item[0]."')");
				$id = mysql_insert_id();
				echo'<tr>';
				echo'<td align="center"><input type="checkbox" id="'.$id.'" /></td><td align="center">'.$this->val_item[0].'</td>';
				echo '</tr>';
			}
		}
		/* update */ 
		public function update_data() {
			$sql ="";	
			
			if($this->table_name=='tbl_theater') {	
				$lat_lng =  simplexml_load_file("http://www.geocoding.jp/api/?q=" . $this->edit_val[1] . " " . $this->edit_val[0]);	
				foreach($lat_lng as $key => $value){
					if($key == "coordinate"){
						foreach($value as $label => $val){
							if($label == 'lat') $this->edit_val[5] = $val;
							if($label == 'lng') $this->edit_val[6] = $val;
						}
					}
				}
	
				$sql= "UPDATE tbl_theater SET theater_name ='".$this->edit_val[0]."', theater_address = '".$this->edit_val[1]."', theater_phone= '".$this->edit_val[2]."', theater_nearest= '".$this->edit_val[3]."', theater_url= '".$this->edit_val[4]."', latitude = ".$this->edit_val[5].", longitude = ".$this->edit_val[6]." WHERE theater_id=".$this->edit_id;
			}
			elseif($this->table_name=='tbl_group') {
				$sql = "UPDATE tbl_group SET group_name ='".$this->edit_val[0]."', group_url = '".$this->edit_val[1]."' WHERE group_id= ".$this->edit_id;
			}
			else {
				$sql = "UPDATE ".$this->table_name." SET ".$this->field_name_name." = '" .$this->edit_val[0]. "' WHERE ".$this->field_name_id." = ".$this->edit_id;
			}
			runSQL($sql);
                       
		}
		
		/* delete */ 
		public function delete($id) {
			runSQL("DELETE FROM ".$this->table_name." WHERE ".$this->field_name_id."=".$id." ");
		}

		/* display page */ 
		public function display() {
                    echo '<link type="text/css" rel="stylesheet" href="' . HTTP_DOMAIN . 'application/rakugo-schedule/css/datatable.css" />';
                        /* confirm when delete */
                        echo '<label class="hide" id = message_confirm >'.$this->rLanguage->text("are you sure want to delete this?").'</label>';
                        /* confirm data exist */
                        echo '<label class="hide" id = data_exist >'.$this->rLanguage->text("data already exist!").'</label>';
			/*left side */
			echo '<div class="master_left">'; 
				echo'<div class="dashed-line"><a href="?page=master&type=occupation&action=display" style="margin-left:20px;font-size:14px;" class="rakugo">'.$this->rLanguage->text("occupation master").'</a></div>
					 <div class="dashed-line"><a href="?page=master&type=teisuffix&action=display" style="margin-left:20px;font-size:14px;" class="rakugo">'.$this->rLanguage->text("tei name master").'</a></div>
					 <div class="dashed-line"><a href="?page=master&type=position&action=display" style="margin-left:20px;font-size:14px;" class="rakugo">'.$this->rLanguage->text("position master").'</a></div>
					 <div class="dashed-line"><a href="?page=master&type=theater&action=display" style="margin-left:20px;font-size:14px;" class="rakugo">'.$this->rLanguage->text("theater master").'</a></div>
					 <div class="dashed-line"><a href="?page=master&type=group&action=display" style="margin-left:20px;font-size:14px;" class="rakugo">'.$this->rLanguage->text("group master").'</a></div>';
			echo '</div>'; 
			/*end left side */
			
			 /*right side*/ 
			echo ' <div class="master_right" id="master_right">';
				echo '<div class="button pink" style="float: left;"><a href="#" onclick="add_item(\''.$this->return_type().'\'); return false;"><label style="width: 70px;">'.$this->rLanguage->text("register").'</label><span></span></a></div>';
				
				echo '<div style="width:100%; float:left;margin-top:10px;">';$this->add_registration();echo '</div>';
				/* 
                                 * form for update picture */
				echo '<div class="button pink" id="btn_edit" style="float: left; margin-top:30px;" onclick="edit_item(\''.$this->return_type().'\')"><label style="width: 70px;">'.$this->rLanguage->text("save").'</label><span></span></div>';
				
				/* end update picture form */
				echo '<div class="button pink" style="float: left; margin-top:30px;" onclick="delete_item(\''.$this->return_type().'\')"><label style="width: 70px;">'.$this->rLanguage->text("delete").'</label><span></span></div>';
				echo '<div style="width:100%; float:left;">';$this->load_row();echo '</div>';
			echo '</div>';
			/* end right side */
                        
                        
		}
                
	}	
?>
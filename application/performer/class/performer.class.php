<?php
ob_start();
if(!isset($_SESSION))session_start();
    /*
    * This class is used to design and access to database for tbl_performer
    * Creator: Rith Phearun
    * Date Created: Oct-01-2011
    */
class performer{
	private $per_id;
    private $per_name;
    private $per_dob;
	private $per_hometown;
	private $per_picture;
	private $per_group;
	private $per_teacher;
	private $per_song;
	private $per_story;
	private $per_url;
	private $per_email;
	private $per_password;
	private $per_position;
	private $per_user_type;
	
	private $per_occupation;
	private $per_teisuffix;
		
	//User Mng
	private $user_id;
	private $user_name;

    public function __construct($id = ""){
            $this->per_id = $id;
            $this->per_name = "";
            $this->per_dob = "";
			$this->per_hometown = "";
			$this->per_picture = "";
			$this->per_group = "";
			$this->per_teacher = "";
			$this->per_song = "";
			$this->per_story = "";
            $this->per_url = "";
			$this->per_email = "";
			$this->per_password = "";
			$this->per_position = "";
			$this->per_user_type = "";
			$this->per_occupation = 0;
			$this->per_teisuffix = 0;
			//User Mng
			$this->user_id = 0;
			$this->user_name = "NO Name";
    }

    private function initDb(){
    	//require_once($_SERVER['DOCUMENT_ROOT'] . "/biznavi/module/module.php");
    }
/*==GET from DB=============================================================================================================*/
	//get Per_Name
	public function getPerName(){
		$this->initDb();
		if($this->per_id !=0){
			$this->per_name = getValue("SELECT per_name FROM tbl_performer WHERE performer_id=".$this->per_id);
		}
		return $this->per_name;	
	}	
	//get Per_DOB
	public function getPerDob(){
		$this->initDb();
		if($this->per_id !=0){
			$q_dob = getValue("SELECT per_dob FROM tbl_performer WHERE performer_id=".$this->per_id);
			$this->per_dob = $q_dob;
			/*
			$dob = explode('-', $q_dob);
			$y = $dob[0];
			$m = $dob[1];
			$d = $dob[2];
			$this->per_dob = $y.'年'.$m.'月'.$d.'日';
			*/
		}
		return $this->per_dob;	
	}
	//get Per_Picture
	public function getPerPicture(){
		$this->initDb();
		$picture_path = HTTP_DOMAIN.'application/performer/per_picture/'; //HTTP_DOMAIN.
		$path_name = $picture_path.$this->getPerPictureName();
		//echo 'Path_Name: '.$path_name;
		if($this->getPerPictureName()=='' || !@fopen($path_name,'r')){// || file_exists($path_name)){
			return $picture_path.'no_profile.jpg';
		}
		else{
			return $path_name;	
		}
	}
	//get Per_PictureName
	public function getPerPictureName(){
		$this->initDb();
		if($this->per_id !=0){
			$this->per_picture = getValue("SELECT per_picture FROM tbl_performer WHERE performer_id=".$this->per_id);
		}
		return $this->per_picture;	
	}
	//get Per_Hometown
	public function getPerHometown(){
		$this->initDb();
		if($this->per_id !=0){
			$this->per_hometown = getValue("SELECT per_hometown FROM tbl_performer WHERE performer_id=".$this->per_id);
		}
		return $this->per_hometown;	
	}
	//get Per_Group
	public function getPerGroup(){
		$this->initDb();
		if($this->per_id !=0){
			$this->per_group = getValue("SELECT group_name FROM tbl_group WHERE group_id=".$this->getPerGroupId());
		}
		return $this->per_group;	
	}
	//get Per_GroupID
	public function getPerGroupId(){
		$this->initDb();
		if($this->per_id !=0){
			$this->per_groupid = getValue("SELECT group_id FROM tbl_performer WHERE performer_id=".$this->per_id);
		}
		return $this->per_groupid;	
	}
	//get Per_Teacher
	public function getPerTeacher(){
		$this->initDb();
		if($this->per_id !=0){
			$this->per_teacher = getValue("SELECT per_teacher FROM tbl_performer WHERE performer_id=".$this->per_id);
		}
		return $this->per_teacher;	
	}
	//get Musical
	public function getPerSong(){
		$this->initDb();
		if($this->per_id !=0){
			$this->per_song = getValue("SELECT per_song FROM tbl_performer WHERE performer_id=".$this->per_id);
		}
		return $this->per_song;	
	}
	//get Musical
	public function getPerStory(){
		$this->initDb();
		if($this->per_id !=0){
			$this->per_story = getValue("SELECT per_story FROM tbl_performer WHERE performer_id=".$this->per_id);
		}
		return $this->per_story;	
	}
	//get Per_Url
	public function getPerUrl(){
		$this->initDb();
		if($this->per_id !=0){
			$this->per_url = getValue("SELECT per_url FROM tbl_performer WHERE performer_id=".$this->per_id);
		}
		return $this->per_url;	
	}
	//get Per_Email
	public function getPerEmail(){
		$this->initDb();
		if($this->per_id !=0){
			$this->per_email = getValue("SELECT per_email FROM tbl_performer WHERE performer_id=".$this->per_id);
		}
		return $this->per_email;	
	}
	//get Per_Password
	public function getPerPassword(){
		$this->initDb();
		if($this->per_id !=0){
			$this->per_password = getValue("SELECT per_password FROM tbl_performer WHERE performer_id=".$this->per_id);
		}
		return $this->per_password;	
	}
	//get Per_Position
	public function getPerPosition(){
		$this->initDb();
		if($this->per_id !=0){
			$this->per_position = getValue("SELECT position_name FROM tbl_position WHERE position_id=".$this->getPerPositionId());
		}
		return $this->per_position;	
	}
	//get Per_PositionId
	public function getPerPositionId(){
		$this->initDb();
		if($this->per_id !=0){
			$this->per_positionid = getValue("SELECT position_id FROM tbl_performer WHERE performer_id=".$this->per_id);
		}
		return $this->per_positionid;	
	}
	//get Per_Occupation
	public function getPerOccupation(){
		$this->initDb();
		if($this->per_id !=0){
			$this->per_occupation = getValue("SELECT occupation FROM tbl_occupation WHERE occupation_id=".$this->getPerOccupationId());
		}
		return $this->per_occupation;	
	}
	//get Per_OccupationID
	public function getPerOccupationId(){
		$this->initDb();
		if($this->per_id !=0){
			$this->per_occupationid = getValue("SELECT occupation_id FROM tbl_performer WHERE performer_id=".$this->per_id);
		}
		return $this->per_occupationid;	
	}
	//get Per_Teisuffix
	public function getPerTeisuffix(){
		$this->initDb();
		if($this->per_id !=0){
			$this->per_teisuffix = getValue("SELECT teisuffix FROM tbl_teisuffix WHERE teisuffix_id=".$this->getPerTeisuffixId());
		}
		return $this->per_teisuffix;	
	}
	//get Per_TeisuffixID
	public function getPerTeisuffixId(){
		$this->initDb();
		if($this->per_id !=0){
			$this->per_teisuffixid = getValue("SELECT teisuffix_id FROM tbl_performer WHERE performer_id=".$this->per_id);
		}
		return $this->per_teisuffixid;	
	}
	//get Per_User_Type
	public function getPerUserType(){
		$this->initDb();
		if($this->per_id !=0){
			$this->per_user_type = getValue("SELECT per_user_type FROM tbl_performer WHERE performer_id=".$this->per_id);
		}
		return $this->per_user_type;	
	}
	//get Per_Twitter
	public function getPerTwitter(){
		$this->initDb();
		if($this->per_id !=0){
			$this->per_twitter = getValue("SELECT per_twitter FROM tbl_performer WHERE performer_id=".$this->per_id);
		}
		return $this->per_twitter;	
	}
/*==END GET from DB=============================================================================================================*/
/*==DISPLAY=============================================================================================================*/
	public function display_ListPerformer(){
		echo '<div class="list_performer">';
		echo '<table border="0" width="100%">';
			echo '<tr>';
				echo '<td width="20%">';
					echo '<table border="0" width="100%">';
						echo '<tr><td class="label">Search Keyword</td></tr>';
						echo '<tr><td><input type="text" name="persearch" class="txt_search"/></td></tr>';
						echo '<tr><td align="right"><input type="button" name="btn_search" value="Search"/></td></tr>';
						echo '<tr><td class="label">Narrowing Condition</td></tr>';
						echo '<tr><td class="narrow"><input type="checkbox" name="" value="" />Association of rakugo</td></tr>';
						echo '<tr><td class="narrow"><input type="checkbox" name="" value="" />Rakugo Arts Council</td></tr>';
						echo '<tr><td class="narrow"><input type="checkbox" name="" value="" />Yen comfort school society</td></tr>';
						echo '<tr><td class="narrow"><input type="checkbox" name="" value="" />Rakugo Tachikara style</td></tr>';
						echo '<tr><td class="narrow"><input type="checkbox" name="" value="" />Association of Kansai rakugo</td></tr>';
						echo '<tr><td class="narrow"><input type="checkbox" name="" value="" />Qualification given to comic</td></tr>';
						echo '<tr><td class="narrow"><input type="checkbox" name="" value="" />Two eyes</td></tr>';
					echo '</table>';
				echo '</td>';
				echo '<td style="border-left: 1px #999 solid; padding-left: 10px;">';
					echo '<span class="label">List Performer</span>';
					echo '<table border="0" width="100%" height="300px">';
						echo '<th height="20px">Comic storyteller name</th>';
						echo '<th>Hometown</th>';
						echo '<th>Musical accompaniment on a stag</th>';
						echo '<th>Material</th>';
						echo '<tr><td></td></tr>';
					echo '</table>';
				echo '</td>';
			echo '</tr>';
		echo '</table>';
		echo '</div>';
	}
	
	public function display_PerformerProfile(){
		$rLanguage =  CheckLanguageChange();
		//https://twitter.com/#!/
		echo '<link rel="stylesheet" href="'.HTTP_DOMAIN.'application/performer/css/s_performer.css" type="text/css" />';
		$user_id = getCurrentUser();
		//echo $user_id;
		echo '<table border="0" width="50%" class="user_profile">';
			echo '<tr>';
				echo '<td width="210px">';
					echo '<div class="picture">';
						echo '<a href="'.$this->getPerPicture().'" class="mypicture"><img src="'.$this->getPerPicture().'"/></a>';
						//echo '<img src="http://localhost/rakugo/application/performer/per_profile_picture/2011Jan1_20111013_071035.jpg" />';
					echo '</div>';
				echo '</td>';
			
				echo '<td>';
					echo '<div class="userinfo">';
						echo '<div class="name">';
							echo '<span>'. $this->getPerName() .'</span>';
						echo '</div>';
						echo '<div class="info">';
					echo '<table border="0" width="100%" cellpadding="1">';
						/*
						echo '<tr>';
							echo '<td colspan="2" class="name">';
								echo $this->getPerName();
							echo '</td>';
						echo '</tr>';
						*/
						echo '<tr>';
							$per_dob = '';
							$y='';$m='';$d='';
							if($this->getPerDob()!=''){
								$dob = explode('-', $this->getPerDob());
								if($dob[0]!=''){$y = $dob[0].'年';}
								if($dob[1]!=''){$m = $dob[1].'月';}
								if($dob[2]!=''){$d = $dob[2].'日';}
								$per_dob = $y.$m.$d;
							}
							
							echo '<td class="label">'.$rLanguage->text("Date of Birth").'</td>';
							echo '<td class="data">'.$per_dob.'</td>';
						echo '</tr>';
						echo '<tr>';
							echo '<td class="label">'.$rLanguage->text("Hometown").'</td>';
							echo '<td class="data">'.$this->getPerHometown().'</td>';
						echo '</tr>';
						echo '<tr>';
							echo '<td class="label">'.$rLanguage->text("Group").'</td>';
							echo '<td class="data">'.$this->getPerGroup().'</td>';
						echo '</tr>';
						echo '<tr>';
							echo '<td class="label">'.$rLanguage->text("Teacher").'</td>';
							echo '<td class="data">'.$this->getPerTeacher().'</td>';
						echo '</tr>';
						echo '<tr>';
							echo '<td class="label">'.$rLanguage->text("Theme song").'</td>';
							echo '<td class="data">'.$this->getPerSong().'</td>';
						echo '</tr>';
						echo '<tr>';
							echo '<td class="label">'.$rLanguage->text("Durability Material").'</td>';
							echo '<td class="data">'.$this->getPerStory().'</td>'; 
						echo '</tr>';
						echo '<tr>';
							echo '<td class="label">'.$rLanguage->text("Homepage blog").'</td>';
							echo '<td class="data">';
								echo '<a href="'.$this->getPerUrl().'" target="_new" class="link">'.$this->getPerUrl().'</a>';
							echo '</td>';
						echo '</tr>';
						echo '<tr>';
							echo '<td class="label">'.$rLanguage->text("Twitter ID").'</td>';
							echo '<td class="data">';
								echo'<a href="https://twitter.com/'.$this->getPerTwitter().'" target="_new" class="link">'.$this->getPerTwitter().'</a>';
							echo'</td>';
						echo '</tr>';
						
						if(($user_id==$this->per_id && $user_id!=0)|| getUserType()==ADMINISTRATOR){
							echo '<tr>';
								echo '<td><a href="?page=perprofileedit&perid='.$this->per_id.'"><div class="button pink" style="float: left;"><label style="width: 80px;">'.$rLanguage->text("Edit").'</label><span></span></div></a></td>';
								
								//echo '<td align="right" valign="bottom"><div style="margin: 24px 5px 0px 0px;"><a href="?page=perpasswordedit&perid='.$this->per_id.'" class="pwtext">Change Password</a></div></td>'; 
							echo '</tr>';
						}
							
						
					echo '</table>';
						echo '</div>';
						/*==Twitter Profile================*/
						///
				/////
				//$twitter_url = 'https://twitter.com/';
				//$twitter_url_jp = 'https://twitter.jp/';			
				$twitter_url = '://twitter.';
				$getUserName = array_map('strrev', explode('/', strrev($this->getPerUrl())));
				$username = $getUserName[0];
				
				$isTwitter = strpos($this->getPerUrl(), $twitter_url);
				//$isTwitherJP = strpos(' '.$this->getPerUrl(), $twitter_url_jp);
				
				//if ($isTwitter == true) {
				$twitter_username = $this->getPerTwitter();
				if ($twitter_username!='' || $twitter_username!=null ) {
					echo '<div class="userinfo" style="margin: 20px 0px 0px 0px; ">';
						echo "<script src='http://widgets.twimg.com/j/2/widget.js'></script>
							<script>
							new TWTR.Widget({
							  version: 2,
							  type: 'profile',
							  rpp: 10,
							  width: 500,
							  height: 300,
							  theme: {
								shell: {
								  background: '#333',
								  color: '#ffffff'
								},
								tweets: {
								  background: '#FFFFF3',
								  color: '#000000',
								  links: '#069'
								}
							  },
							  features: {
								scrollbar: true,
								loop: true,
								live: true,
								behavior: 'all',
							  }
							}).render().setUser('".$twitter_username."').start();
							</script>
						";
						
							echo '
								<style type="text/css">
									.twtr-user{
										display: none;	
									}
								</style>
							';
					echo '</div>';
				}
				else {}
						/*==Twitter Profile================*/
					echo '</div>';
					
					
				echo '</tr>';
		echo '</table>';
	}
/*==END DISPLAY=============================================================================================================*/
/*==FORM Registration=============================================================================================================*/
	public function form_PerRegistration(){
		echo '<h2>Registration Form</h2>';
		echo '<form id="form_newperformer" method="post">';
			echo '<table border="0" width="100%" class="form_perregistration">';
				echo '<tr>';
					echo '<td class="label">';
						echo 'Name :';
					echo '</td>';
					echo '<td>';
						echo '<input type="text" id="iname" name="pername" class="textbox"/>';
					echo '</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td class="label">';
						echo 'Date of Birth :';
					echo '</td>';
					echo '<td>';
						//echo '<input type="text" id="idob" name="perdob" class="textbox"/>';
						echo '<select id="year" name="yyyy">';
						echo '</select>&nbsp;';
						echo '<select id="month" name="mm">';
						echo '</select>&nbsp;';
						echo '<select id="date" name="dd">';
						echo '</select>';
						echo '<script type="text/javascript">date_populate("date", "month", "year");</script>';
					echo '</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td class="label">';
						echo 'Hometown :';
					echo '</td>';
					echo '<td>';
						echo '<input type="text" id="ihometown" name="perhometown" class="textbox"/>';
					echo '</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td class="label">';
						echo 'Group :';
					echo '</td>';
					echo '<td>';
						echo '<input type="text" id="igroup" name="pergroup" class="textbox"/>';
					echo '</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td class="label">';
						echo 'Teacher :';
					echo '</td>';
					echo '<td>';
						echo '<input type="text" id="iteacher" name="perteacher" class="textbox"/>';
					echo '</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td class="label">';
						echo 'Theme song :';
					echo '</td>';
					echo '<td>';
						echo '<input type="text" id="isong" name="persong" class="textbox"/>';
					echo '</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td class="label">';
						echo 'Best story :';
					echo '</td>';
					echo '<td>';
						echo '<input type="text" id="istory" name="perstory" class="textbox"/>';
					echo '</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td class="label">';
						echo 'Homepage :';
					echo '</td>';
					echo '<td>';
						echo '<input type="text" id="iurl" name="perurl" class="textbox"/>';
					echo '</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td class="label">';
						echo 'Mail Address :';
					echo '</td>';
					echo '<td>';
						echo '<input type="text" id="imail" name="permail" class="textbox"/>';
					echo '</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td class="label">';
						echo 'Upload :';
					echo '</td>';
					echo '<td>';
						echo '<input type="file" id="iupload" name="perupload" class="textbox"/>';
					echo '</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td class="label">';
						echo 'Password :';
					echo '</td>';
					echo '<td>';
						echo '<input type="password" id="ipassword" name="perpassword" class="textbox"/>';
					echo '</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td class="label">';
						echo 'Confirm :';
					echo '</td>';
					echo '<td>';
						echo '<input type="password" id="iconfirm" name="perconfirm" class="textbox"/>';
					echo '</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td class="label">';
					echo '</td>';
					echo '<td>';
						echo '<input type="button" id="iadd_performer" name="persubmit" value="Register" onclick="add_newperformer()"/>';
					echo '</td>';
				echo '</tr>';
			echo '</table>';
		echo '</form>';
	}
	 /* display list of events in pickup */
	public function display_PickupPerformer()
	{
		echo '<tr>';
                    echo '<td align="center"><input type="radio" id="' . $this->per_id . '" name="choice_event_pickup" /></td>';
                    echo '<td><a href="#" class="">' . $this->getPerName() . '</a></td>';
                    echo '<td>'.$this->getPerHometown().'</td>';
                    echo '<td>'.$this->getPerSong().'</td>';
                    echo '<td>'.$this->getPerStory().'</td>';
		echo '</tr>';
	}
/*==END FORM Registration=============================================================================================================*/
	
}
?>
<?php
echo '<link type="text/css" rel="stylesheet" href="'.HTTP_DOMAIN.'css/s_sitemap.css" />';

if(!defined(per_sub_path))define("per_sub_path",dirname(dirname(__FILE__)));
require_once(per_sub_path . "/module/module.php");
//require_once($_SERVER['DOCUMENT_ROOT']."/" . ROOT . "/module/module.php");

	//$rLanguage =  CheckLanguageChange();
	//echo $rLanguage->text("keyword");

echo '<div class="sitemap_wrapper">';
	echo '<img src="'.HTTP_DOMAIN.'images/button_rakugo/title_sitemap.jpg"  />';
	echo '<div class="sitemap">';
		echo '<a href="?page=index" class="item"><img src="'.HTTP_DOMAIN.'images/pickup-icon-over.png" />'.$rLanguage->text("Home").'</a>';
		echo '<a href="?page=schedule&action=search" class="item"><img src="'.HTTP_DOMAIN.'images/pickup-icon-over.png" />'.$rLanguage->text("Search").'</a>';
		echo '<a href="?page=perlist" class="item"><img src="'.HTTP_DOMAIN.'images/pickup-icon-over.png" />'.$rLanguage->text("List Performer").'</a>';
		echo '<a href="?page=inquery" class="item"><img src="'.HTTP_DOMAIN.'images/pickup-icon-over.png" />'.$rLanguage->text("Inquiry").'</a>';
		echo '<a href="#" class="item"><img src="'.HTTP_DOMAIN.'images/pickup-icon-over.png" />'.$rLanguage->text("Sitemap").'</a>';
		echo '<a href="http://www.headwaters.co.jp" class="item" target="_new"><img src="'.HTTP_DOMAIN.'images/pickup-icon-over.png" />'.$rLanguage->text("Company").'</a>';
		echo '<a href="?page=term" class="item"><img src="'.HTTP_DOMAIN.'images/pickup-icon-over.png" />'.$rLanguage->text("Term of usage").'</a>';
	echo '</div>';
	
	//TEST of Admistrator
	if (getCurrentUser()!=0){
	echo '<div class="sitemap">';
		//echo '<span class="item" style="color: #00F;">'.$rLanguage->text("AMINISTRATION").' (test)</span>';
		if(getUserType()==ADMINISTRATOR){
			echo '<a href="?page=perregistration" class="item"><img src="'.HTTP_DOMAIN.'images/pickup-icon-over.png" />'.$rLanguage->text("Add New Performer").'</a>';		
			echo '<a href="?page=permanagement" class="item"><img src="'.HTTP_DOMAIN.'images/pickup-icon-over.png" />'.$rLanguage->text("Performer Management").'</a>';
			echo '<a href="?page=pickup" class="item"><img src="'.HTTP_DOMAIN.'images/pickup-icon-over.png" />'.$rLanguage->text("Pickup Management").'</a>';
			echo '<a href="?page=master" class="item"><img src="'.HTTP_DOMAIN.'images/pickup-icon-over.png" />'.$rLanguage->text("Master Table").'</a>';			
		}
		echo '<a href="?page=perprofile&perid='.getCurrentUser().'" class="item"><img src="'.HTTP_DOMAIN.'images/pickup-icon-over.png" />'.$rLanguage->text("My Profile").'</a>';
		echo '<a href="' . HTTP_DOMAIN . 'include/logout.php" class="item" style="border: none;"><img src="'.HTTP_DOMAIN.'images/pickup-icon-over.png" />'.$rLanguage->text("Logout").'</a>';
	echo '</div>';
	}
echo '</div>';
?>

<?php
	ob_start();
	if(!isset($_SESSION))@session_start();
    $disable_top = "";
    $disable_site_map = "";
    $link_top = "?page=index";
    $link_site_map = "?page=sitemap";
    $link_performer_list = "?page=perlist";
    $rLanguage = CheckLanguageChange();
?>
<!--<div id="tabs">
<ul>-->
  <!--
  <li><a href="index.php"><span>Home</span></a></li>
  <li><a href="inquiry.php"><span>Inquiry</span></a></li>
  <li><a href="sitemap.php"><span>Site Map</span></a></li>
  -->
  <!--d
  <li><a href="?page=perregistration"><span>Registration</span></a></li>
  <li><a href="?page=perprofile"><span>Performer Profile</span></a></li>
  <li><a href="?page=perlist"><span>List Performer</span></a></li>
  <li><a href="?page=pickup"><span>Pickup</span></a></li>


</ul>
</div>
-->
<div style="height: 40px; margin-right: 20px;" class="span-full"><a class="goto-top rakugo <?php echo getCurrentPageStyle("top"); ?>" href="<?php echo getValidLink("top", $link_top); ?>" style="float: left; display: block;">TOP</a></div>
<div style="height: 40px; margin-right: 20px;" class="span-full"><a class="goto-top rakugo <?php echo getCurrentPageStyle("perlist"); ?>" href="<?php echo getValidLink("perlist", $link_performer_list); ?>" style="float: left; display: block;"><?php echo $rLanguage->text("list performer"); ?></a></div>
<div style="height: 40px; margin-right: 20px;" class="span-full"><a class="goto-top rakugo last <?php echo getCurrentPageStyle("sitemap"); ?>" href="<?php echo getValidLink("sitemap", $link_site_map); ?>" style="float: left; display: block;"><?php echo $rLanguage->text("site map"); ?></a></div>

<?php
/*
    echo '<div style="height: 40px; margin-right: 20px;" class="span-full"><a class="goto-top last" href="?page=perregistration" style="float: left; display: block;">Registration</a></div>';
    echo '<div style="height: 40px; margin-right: 20px;" class="span-full"><a class="goto-top last" href="?page=perlist" style="float: left; display: block;">List Performer</a></div>';
if (getCurrentUser()!=0){
echo '<div style="height: 40px; margin-right: 20px;" class="span-full"><a class="goto-top last" href="?page=inquery" style="float: left; display: block;">Inquery</a></div>';
echo '<div style="height: 40px; margin-right: 20px;" class="span-full"><a class="goto-top last" href="?page=pickup" style="float: left; display: block;">Pickup</a></div>';
	if(getUserType()==ADMINISTRATOR){
echo '<div style="height: 40px; margin-right: 20px;" class="span-full"><a class="goto-top last" href="?page=master" style="float: left; display: block;">Master Table</a></div>';
	}
echo '<div style="height: 40px; margin-right: 20px;" class="span-full"><a class="goto-top last" href="?page=perprofile&perid='.getCurrentUser().'" style="float: left; display: block;">My Profile</a></div>';
echo '<div style="height: 40px; margin-right: 20px;" class="span-full"><a class="goto-top last" href="/rakugo/include/logout.php" style="float: left; display: block;">Logout</a></div>';
}*/

function getCurrentPageStyle($menu){
    if(!isset($_GET['page']) || $_GET['page'] == "index"){
        if($menu == "top") return  "disabled";
        else return "";
    }
    else{
        if($_GET['page'] == $menu) return "disabled";
        else return "";
    }
}

function getValidLink($menu, $reload_url){
    if(!isset($_GET['page']) || $_GET['page'] == "index"){
        if($menu == "top") return "#";
        else return $reload_url;
    }
    else{
        if($_GET['page'] == $menu) return "#";
        else return $reload_url;
    }
}
?>


<!--<table cellpadding="0" cellspacing="0" width="100%">
<tr>
<td align="center"><span class="label-login">ID</span></td>
<td>
    <div class="text-login"><input type="text" class="text-login" id="txtid" style="height: 13px; font-size: 11px;margin:0; width: 100%;" name="txtid"></div>
</td>
<td rowspan="2"><a class="button" style="float: right; margin-right: 10px;" href="#"><span>ログイン</span></a></td>
</tr>
<tr>
<td align="center"><span class="label-login">PASS</span></td>
<td>
    <div class="text-login"><input type="password" style="margin:0;margin-top: 1px;height: 13px; width: 100%; font-size: 11px;" class="text-login" id="txtid" name="txtid"></div>
</td>
</tr>
</table>-->

<!--<a class="button-large grey" style="float: right; margin-left: 10px;" href="#"><span>ログイン</span></a>
<div class="button green" style="float: left; margin-left:40px;"><label style="width: 100px;">ログイン</label><span></span></div>
<div class="text-login">
    <span>ID</span><input type="text" class="text-login" id="txtid" name="txtid">
</div>
<div class="text-login">
    <span>Password</span><input type="password" class="text-login" id="txtid" name="txtid">
</div> -->
<?php
    if(getUserType() == VIEWER){
?>
<form id="login" method="POST" action="<?php echo HTTP_DOMAIN; ?>include/login.php" onsubmit="return check_valid();" style="margin: 0; padding: 0; float: right; width: 300px;" target="here">
<input class="btn_login" type="submit" id="btn_login" style="float:right; border: none;" value=""/>
<div class="text-login" style="float: right; margin: 2px 0 0 0px;">
	<table border="0" cellpadding="1" cellspacing="0">
    	<tr>
        	<td><div class="btn_head_login_id"></div></td>
            <td><input type="text" class="text-login" id="txtid" name="txtid"></td>
        </tr>
        <tr>
        	<td><div class="btn_head_login_pass"></div></td>
            <td><input type="password" class="text-login" id="txtpassword" name="txtpassword"></td>
        </tr>
    </table>
</div>
</form>
<a href="?page=schedule&action=search" class="btn_search_header" style="float: right;"></a>
<iframe id="here" name="here" style="border: 0px solid; width: 0px; height: 0px;"></iframe>
<?php
  }
  else{
?>
<a href="<?php echo HTTP_DOMAIN . "include/logout.php"; ?>" class="btn_logout" style="float: right;"></a>
<a href="?page=schedule&action=search" class="btn_search_header" style="float: right; margin-top: -1px;"></a>
<?php
    }
    echo '<script type="text/javascript" src="' . HTTP_DOMAIN . 'js/login.js"></script>';
?>


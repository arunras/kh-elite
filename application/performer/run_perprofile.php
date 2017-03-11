<script type="text/javascript">
$(document).ready(function(){
	$("a.mypicture").fancybox({
		'overlayShow'	: true,
		'transitionIn'	: 'elastic',
		'transitionOut'	: 'elastic',
        'easingIn' : 	'swing',
        'easingOut' : 	'swing',
        'autoDimensions': true
	});	
});
</script>
<?php
//require_once($_SERVER['DOCUMENT_ROOT'] . "/rakugo/module/module.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/". ROOT. "/application/performer/class/performer.class.php");
$page = $_GET['page'];
$per_id = $_GET['perid'];
if($page='perprofile'){
	$per = new performer($per_id);
	if($per_id!=0){
		echo $per->display_PerformerProfile();
	}
}
?>
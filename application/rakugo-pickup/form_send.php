<?php
if(isset($_POST['email'])) {
echo 'Content-Type: text/plain;charset="utf-8"';
	// CHANGE THE TWO LINES BELOW
	//$email_to = $_POST['email'];//"run@camitss.com";
	
	//$email_to = 'run@camitss.com';
	$email_to = 'tokutake@headwaters.co.jp';
	$email_subject = "[落語ちゃん]";
	$email_subject = '=?UTF-8?B?'.base64_encode($email_subject).'?=';
	
	
	
	$first_name = $_POST['first_name']; // required
	$last_name = $_POST['last_name']; // required
	$say	=$_POST['say']; //required
	$may	=$_POST['may'];//required
	$email_from = $_POST['email']; // required
	$comments = $_POST['comment']; // required
	
	$error_message = "";
	$email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
  if(!preg_match($email_exp,$email_from)) {
  	$error_message .= 'The Email Address you entered does not appear to be valid.<br />';
  }
	$string_exp = "/^[A-Za-z .'-]+$/";
  if(!preg_match($string_exp,$first_name)) {
  	$error_message .= 'The First Name you entered does not appear to be valid.<br />';
  }
  if(!preg_match($string_exp,$last_name)) {
  	$error_message .= 'The Last Name you entered does not appear to be valid.<br />';
  }
  if(!preg_match($string_exp,$say)) {
  	$error_message .= 'The Last Name you entered does not appear to be valid.<br />';
  }
  if(!preg_match($string_exp,$may)) {
  	$error_message .= 'The Last Name you entered does not appear to be valid.<br />';
  }
  if(strlen($comments) < 2) {
  	$error_message .= 'The Comments you entered do not appear to be valid.<br />';
  }
  
	$email_message = "Form details below.\n\n";
	
	function clean_string($string) {
	  $bad = array("content-type","bcc:","to:","cc:","href");
	  return str_replace($bad,"",$string);
	}
	$email_message .= "姓: ".clean_string($first_name)."\n";
	$email_message .= "名: ".clean_string($last_name)."\n";
	$email_message .= "アドレス: ".clean_string($email_from)."\n";
	$email_message .= "姓: ".clean_string($say)."\n";
	$email_message .= "姓: ".clean_string($may)."\n";
	$email_message .= "お問合せ内容: ".clean_string($comments)."\n";
	/*
	$email_message .= "First Name: ".clean_string($first_name)."\n";
	$email_message .= "Last Name: ".clean_string($last_name)."\n";
	$email_message .= "Email: ".clean_string($email_from)."\n";
	$email_message .= "Say: ".clean_string($say)."\n";
	$email_message .= "May: ".clean_string($may)."\n";
	$email_message .= "Comments: ".clean_string($comments)."\n";
	*/
	
// create email headers
$headers = 'From: '.$email_from."\r\n".
'Reply-To: '.$email_from."\r\n" .
'X-Mailer: PHP/' . phpversion()."\r\n";
@mail($email_to, $email_subject, $email_message, $headers);  
//header("Location:http://google.com");
//header("Location:http://".$_SERVER['SERVER_NAME']."/rakugo/?page=index");
}
?>

<script type="text/javascript">
	window.top.endMailSuccess();
</script>
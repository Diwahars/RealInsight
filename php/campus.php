<?php

if(!(empty($_SERVER['HTTP_X_REQUESTED_WITH'])) and strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
	session_start();
	header("Content-Type: text/xml");
	if(!(isset($_SESSION['username']))){
		echo '<user><error content="You have to LOG IN first to register as an ambassador. &lt;br&gt; Don\'t have an account, &lt;a data-toggle=\'modal\' data-target=\'#form-signup\' &gt;Sign Up &lt;a/&gt; now. " /></user>';
		die();
	}
	$to = "mahendermanral007@gmail.com";
	$subject = "Request for Campus Ambassador.";
	$type = 'html';
	$charset = 'utf-8';
	$a = $_SESSION['username'];
	$b = $_SESSION['mail'];

	$content = "Request from ".$a." <br><br>Email: ".$b;

	$mail     = 'KSS ONLINE< info@'.str_replace('www.', '', $_SERVER['SERVER_NAME']) .' >';
	$uniqid   = md5(uniqid(time()));
	$headers  = 'From: '.$mail."\n";
	$headers .= 'Reply-to: '.$mail."\n";
	$headers .= 'Return-Path: '.$mail."\n";
	$headers .= 'Message-ID: <'.$uniqid.'@'.$_SERVER['SERVER_NAME'].">\n";
	$headers .= 'MIME-Version: 1.0'."\n";
	$headers .= 'Date: '.gmdate('D, d M Y H:i:s', time())."\n";
	$headers .= 'X-Priority: 3'."\n";
	$headers .= 'X-MSMail-Priority: Normal'."\n";
	$headers .= 'Content-Type: multipart/mixed;boundary="----------'.$uniqid.'"'."\n";
	$headers .= '------------'.$uniqid."\n";
	$headers .= 'Content-type: text/'.$type.';charset='.$charset.''."\n";
	$headers .= 'Content-transfer-encoding: 7bit';

	if(!mail($to, $subject, $content, $headers)){
		$error = json_encode(error_get_last());
		$error = str_replace('"', '', $error);
		$error = str_replace("'", "", $error);
		echo "<user><error content='We are unable to process your query right now. Please try again later or contact KSS Official. ".$error."'></error></user>";
		die();
	}
	else{
		echo "<user><success></success></user>";
	}
}else{
	echo "You don't have permission to access this. Go to <a href='/'>home page</a> ";
}
?>
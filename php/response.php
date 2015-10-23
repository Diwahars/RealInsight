<?php
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
	require('connectdb.php');
	header("Content-type: text/xml");

	$connection=mysqli_connect ('localhost', $username, $password);
	if (!$connection) {
	  die('<user><error content="Not connected : ' . mysql_error().'"></error></user>');
	}

	$db_selected = mysqli_select_db($connection, $database);
	if (!$db_selected) {
	  die ('<user><error content="Can\'t use db : ' . mysql_error()).'"></error></user>';
	}
	if(isset($_POST['t']) and $_POST['t']==1){
		if(!(isset($_POST['name'])) or !(isset($_POST['email'])) or !(isset($_POST['subject'])) or !(isset($_POST['mail']))){
			die("<user><error content='Data not set'></error></user>");
		}
		$a = $_POST['name'];
		$b = $_POST['email'];
		$c = $_POST['subject'];
		$d = $_POST['mail'];
		$type = 'html';
		$charset = 'utf-8';

		$content = "Feedback/ Query from ".$a." (email: ".$b.")<br><br>".$d;

		$mail     = 'KSS Online <info@'.str_replace('www.', '', $_SERVER['SERVER_NAME']).'>';
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

		$query = "SELECT * FROM `members` WHERE `admin`='1' ";
		$result = mysqli_query($connection, $query)
		or die('<user><error content="Error selecting recipients. Try again after some time."></error></user>');
		while($admin = mysqli_fetch_array($result)){
			if(!(mail($admin['email'], $c, $content, $headers))){
				echo "<user><error content='Mail sending failed. Try after some time.'></error></user>";
				die();
			}	
		}
		echo "<user><success /></user>";
	}
	mysqli_close($connection);
}else{
	echo "You don't have permission to access this piece of information. Go to <a href='/'>home page</a>";
}
?>
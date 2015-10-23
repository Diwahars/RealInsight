<?php

/*for random string*/
function random($characters=8,$letters = '23456789bcdfghjkmnpqrstvwxyz'){
	$str='';
	for ($i=0; $i<$characters; $i++) { 
		$str .= substr($letters, mt_rand(0, strlen($letters)-1), 1);
	}
	return $str;
}

if(!(empty($_SERVER['HTTP_X_REQUESTED_WITH'])) and strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
	require('connectdb.php');

	header('Content-Type: text/xml');
	$to = $_REQUEST['to'];

	// Opens a connection to a MySQL server
	$connection=mysqli_connect ('localhost', $username, $password);
	if (!$connection) {
	  die('<error content="Not connected : ' . mysql_error() . '"></error>');
	}

	// Set the active MySQL database
	$db_selected = mysqli_select_db($connection, $database);
	if (!$db_selected) {
	  die ('<error content="Can\'t use db : ' . mysql_error() . '"></error>');
	}
	
	$query = "SELECT * FROM `user` WHERE `email`='".$to."' ";
	$result = mysqli_query($connection, $query) or die('<error content="Can\'t find email id :' .mysql_error() . '"></error>');
	if(mysqli_num_rows($result) === 0){
		die('<error content="No registered email found"></error>');
	}
	$password = random();

	$subject = "Mail for Password Recovery";
	$body = "<html>
	<body>
		<div>
			<p><strong>Hello</strong></p>
			<p>Thank you for using our services.<br> Your new password is <strong>". $password ."</strong></p>
			<p>Please <a href='http://kssonline.in'>Log In </a>to SUPER WORKPLACES and change the password from Profile page under Options &gt; Change Password</p>
			<p>Regards<br>Technical Team<br>SUPER WORKPLACES ( <a href='http://kssonline.in'>kssonline.in</a> )</p>
		</div>
	</body>
	</html>";
	$type = 'html';
	$charset = 'utf-8';

	$mail     = 'SUPER WORKPLACES< info@'.str_replace('www.', '', $_SERVER['SERVER_NAME']) .' >';
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

	if(!mail($to, $subject, $body, $headers)){
		die('<error content="mail error"></error>');
	}else{
		$query = "UPDATE `user` SET `password`='". md5($password) ."' WHERE `email`='".$to."' ";
		$result = mysqli_query($connection, $query)
		or die('<error content="Can\'t update password."></error>');
		echo('<user><success></success></user>');
	}

	mysqli_close($connection);
}else{
	echo "You don't have permission for this data.";
}
?>
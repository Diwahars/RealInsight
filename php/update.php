<?php

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
	session_start();
	header('Content-type: text/xml');
	if(!(isset($_SESSION['username']))){
		echo "<user><error><refresh></error></user>";
		die();
	}
	if(!(isset($_REQUEST['name'])) or !(isset($_REQUEST['email'])) or !(isset($_REQUEST['college'])) or !(isset($_REQUEST['city'])) ){
		die("<user><error content='Data not set'></error></user>");
	}

	require('connectdb.php');
	$connection=mysqli_connect ('localhost', $username, $password);
	if (!$connection) {
	  die('<user><error content="Not connected : ' . mysql_error().'"></error></user>');
	}

	$db_selected = mysqli_select_db($connection, $database);
	if (!$db_selected) {
	  die ('<user><error content="Can\'t use db : ' . mysql_error()).'"></error></user>';
	}
	$a = $_POST['name'];
	$b = $_POST['email'];
	$c = $_POST['college'];
	$d = $_POST['city'];
	if(isset($_POST['status']))
		$e = str_replace("'", "\'", $_POST['status']);
	else
		$e = '';

	$query = "UPDATE `user` SET `name`='".$a."', `email`='".$b."', `college`='".$c."', `city`='".$d."', `status`='".$e."' WHERE `id`='".$_SESSION['userid']."' ";
	$result = mysqli_query($connection, $query)
	or die('<user><error content="Can\'t Perform Update"></error></user>');

	echo "<user><success /></user>";
	mysqli_close($connection);
}else{
	echo "You Don't have permission for this. Go to <a href='/'>home page</a>.";
}
?>
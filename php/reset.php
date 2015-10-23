<?php
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) and strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
	header("Content-type: text/xml");
	echo "<user>";
	if(!isset($_REQUEST['passo']) or !isset($_REQUEST['passn']) or !isset($_REQUEST['passnr'])){
		die('<error content="Data is not valid"></error></user>');
	}
	require('connectdb.php');
	session_start();
	if(!isset($_SESSION['username'])){
		die('<error content="User is not valid."></error></user>');
	}
	$connection = mysqli_connect('localhost', $username, $password)
	or die('<error> content="Connection failed. Contact admin."></error></user>');
	$db = mysqli_select_db($connection, $database)
	or die("<error content='Connection failed. Contact admin.'></error></user>");
	$query = "SELECT password FROM `user` WHERE `id`='".$_SESSION['userid']."' ";
	$result = mysqli_query($connection, $query)
	or die('<error content="Can not process your request." ></error></user>');
	$user_data = mysqli_fetch_array($result);
	if(count($user_data) == 0){
		die('<error content="Can not process your request."></error></user>');
	}
	if($user_data['password'] == md5($_REQUEST['passo'])){
		if($_REQUEST['passn'] == $_REQUEST['passnr']){
			$query = "UPDATE user 
				SET password='".md5($_REQUEST['passn'])."' 
				WHERE id='".$_SESSION['userid']."' ";
			$result = mysqli_query($connection, $query)
			or die("<error content='Can not update password. Please try after some time.'></error></user>");
			echo "<success></success></user>";
		}else{
			die("<error content='Your supplied new password does not match.'></error></user>");
		}
	}else{
		die("<error content='Your password is not valid. Please use a valid password.'></error></user>");
	}
}else{
	echo "You don't have permission for this data.";
}
?>
<?php

session_start();
if(isset($_SESSION['username'])){
	die("<user><error content='Another user is logged in. Please refresh the page or log out first.'></error></user>");
}
require('connectdb.php');

// Opens a connection to a MySQL server
$connection=mysqli_connect ('localhost', $username, $password);
if (!$connection) {
  die('Not connected : ' . mysql_error());
}

// Set the active MySQL database
$db_selected = mysqli_select_db($connection, $database) or die ('Can\'t use db : ' . mysql_error());

$email = $_REQUEST["name"];
$password = $_REQUEST["pass"];

$password=md5($password);
if($email!="" and $password!=""){
	$query = " SELECT * FROM `user` WHERE email = '".$email."' ";
	$uid = mysqli_query($connection, $query) or die("Couldn't Select id ".mysql_error());
	$res = mysqli_fetch_array($uid);
	if ($res['password'] == $password){
		$_SESSION["username"] = $res["username"];
		$_SESSION["userid"] = $res["userid"];
		$_SESSION["mail"] = $res["email"];
		if(isset($_SESSION['failedLogin']))
			unset($_SESSION['failedLogin']);
		header("Location: /");
	}else{
		$_SESSION["failedLogin"] = 1;
		if(array_count_values($res) == 0)
			header("Location: /loginattempt.php?t=1");
		else
			header("Location: /loginattempt.php?t=2&u=".$email);
	}
}else{
	header("Location: /");
}

mysqli_close($connection);
?>
<?php
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
	require('connectdb.php');
	require('function.php');
	session_start();
	if(!isset($_SESSION['userid'])){
		die('<div class="error">Invalid User.</div>');
	}

	$connection=mysqli_connect ('localhost', $username, $password);
	if (!$connection) {
	  die('<div class="error">Not connected : ' . mysql_error().'"</div>');
	}

	$db_selected = mysqli_select_db($connection, $database);
	if (!$db_selected) {
	  die ('<div class="error">Can\'t use db : ' . mysql_error()).'</div>';
	}
	$query = "SELECT * FROM `city`";
	$result = mysqli_query($connection, $query)
	or die();
	echo '
	<h4>Sort By</h4>
	<div class="full">
		<span>Employee Size</span>
		<div class="minor" data-target="size=1&sl=0&su=50">&lt; 50</div>
		<div class="minor" data-target="size=1&sl=50&su=1000">&gt; 50 &lt; 1000</div>
		<div class="minor" data-target="size=1&sl=1000&su=5000">&gt; 1000 &lt; 5000</div>
	</div>
	<div class="full">
		<span>Location wise</span>';
	while($cityData = mysqli_fetch_array($result)){
		echo'<div class="minor" data-target="city=1&c='.$cityData['cityID'].'">'.$cityData['name'].'</div>';
	}
	echo '</div>';

}else{
	echo "You don't have permission to access this piece of information. Go to <a href='/'>home page</a>";
}

?>
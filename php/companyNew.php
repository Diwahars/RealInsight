<?php
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
	require('connectdb.php');
	require('function.php');
	session_start();
	// header("Content-type: text/xml");

	$connection=mysqli_connect ('localhost', $username, $password);
	if (!$connection) {
	  die('<user><error content="Not connected : ' . mysql_error().'"></error></user>');
	}

	$db_selected = mysqli_select_db($connection, $database);
	if (!$db_selected) {
	  die ('<user><error content="Can\'t use db : ' . mysql_error()).'"></error></user>';
	}
	if($_REQUEST['t'] == 1){
		$company = $_REQUEST['c'];
		$query = "SELECT * FROM `company` 
			WHERE `id`='".$company."' ";
		$result = mysqli_query($connection, $query)
		or die('<user><error content="Query Failed"></error></user>');
		$city_name = mysqli_fetch_array($result);

		$column = array(
				array('id'=> '0', 'label' => 'Month', 'pattern'=> '', 'type'=> 'string'), 
				array('id'=> '1', 'label' => 'Overall Company Ratings', 'pattern'=> '', 'type'=> 'number'));

		$rows = array();

		$query = "SELECT `satisfaction`.`date`, sum(`satisfaction`.`level`) AS `level`
			FROM `satisfaction`
			INNER JOIN `company`
			ON `satisfaction`.`companyID` = `company`.`id`
			WHERE `company`.`id`='".$company."'
			GROUP BY `satisfaction`.`date` ASC
			LIMIT 12";
		$result = mysqli_query($connection, $query)
		or die("<user><error content='Query failed 1'></error></user>");
		while($satisfaction = mysqli_fetch_array($result)){
			$date = explode('-', $satisfaction['date']);
			$rate = array(
				'c' => array(
					array('v' => $date[1].'-'.$date[0]),
					array('v' => $satisfaction['level']),
				)
			);
			array_push($rows, $rate);
		}
		$json = array('cols'=> $column, 'rows' => $rows);

		$jsonstring = json_encode($json);
		echo($jsonstring);
	}else if($_REQUEST['t'] == 2){
		$company = $_REQUEST['c'];
		$query = "SELECT * FROM `company` 
			WHERE `id`='".$company."' ";
		$result = mysqli_query($connection, $query)
		or die('<user><error content="Query Failed"></error></user>');
		$city_name = mysqli_fetch_array($result);

		$column = array(
				array('id'=> '0', 'label' => 'Gender', 'pattern'=> '', 'type'=> 'string'), 
				array('id'=> '1', 'label' => 'Employees', 'pattern'=> '', 'type'=> 'number'));

		$rows = array();
		$rate = array(
			'c' => array(
				array('v' => 'Male'),
				array('v' => $city_name['maleEmployee']),
			)
		);
		array_push($rows, $rate);
		$rate = array(
			'c' => array(
				array('v' => 'Female'),
				array('v' => $city_name['femaleEmployee']),
			)
		);
		array_push($rows, $rate);
		$json = array('cols'=> $column, 'rows' => $rows);

		$jsonstring = json_encode($json);
		echo($jsonstring);
	}


	mysqli_close($connection);
}else{
	echo "You don't have permission to access this piece of information. Go to <a href='/'>home page</a>";
}
?>
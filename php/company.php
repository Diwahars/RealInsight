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
		$city = $_REQUEST['c'];
		$query = "SELECT * FROM `city` 
			WHERE `cityID`='".$city."' ";
		$result = mysqli_query($connection, $query)
		or die('<user><error content="Query Failed"></error></user>');
		$city_name = mysqli_fetch_array($result);

		$column = array(
				array('id'=> '0', 'label' => 'Month', 'pattern'=> '', 'type'=> 'string'), 
				array('id'=> '1', 'label' => 'Overall Satisfaction Level('.$city_name['name'].')', 'pattern'=> '', 'type'=> 'number'),
				array('id'=> '2', 'label' => 'Average Salary of City('.$city_name['name'].')', 'pattern'=> '', 'type'=> 'number'));

		$rows = array();

		$query = "SELECT `satisfaction`.`date`, sum(`satisfaction`.`level`) AS `level`
			FROM `satisfaction`
			INNER JOIN `company`
			ON `satisfaction`.`companyID` = `company`.`id`
			INNER JOIN `city`
			ON `city`.`cityID` = `company`.`city`
			WHERE `city`.`cityID`='".$city."'
			GROUP BY `satisfaction`.`date` ASC
			LIMIT 12";
		$result = mysqli_query($connection, $query)
		or die("<user><error content='Query failed 1'></error></user>");
		$query1 = "SELECT `salary`.`date`, sum(`salary`.`salary`) AS `salary`
			FROM `salary`
			INNER JOIN `company`
			ON `salary`.`companyID` = `company`.`id`
			INNER JOIN `city`
			ON `city`.`cityID` = `company`.`city`
			WHERE `city`.`cityID`='".$city."'
			GROUP BY `salary`.`date` ASC 
			LIMIT 12";
		$result1 = mysqli_query($connection, $query1)
		or die("<user><error content='Query failed'></error></user>");
		while($satisfaction = mysqli_fetch_array($result) and $salary = mysqli_fetch_array($result1)){
			$date = explode('-', $satisfaction['date']);
			$rate = array(
				'c' => array(
					array('v' => $date[1].'-'.$date[0]),
					array('v' => $satisfaction['level']),
					array('v' => $salary['salary'])
				)
			);
			array_push($rows, $rate);
		}
		$json = array('cols'=> $column, 'rows' => $rows);

		$jsonstring = json_encode($json);
		echo($jsonstring);

	}else if($_REQUEST['t'] == 2){
		$city = $_REQUEST['c'];
		$query = "SELECT `company`.`name` AS `compName`, `city`.`name` AS `cityName` , avg(`rating`) AS `rates`
			FROM `review`
			INNER JOIN `company`
			ON `review`.`companyID`=`company`.`id`
			INNER JOIN `city`
			ON `company`.`city`=`city`.`cityID`
			WHERE `city`.`cityID`='".$city."'
			ORDER BY avg(`rating`) DESC
			LIMIT 15 ";
		$result = mysqli_query($connection, $query)
		or die("<user><error content='Query failed at 3'></error></user>");
		$rank = 1;
		echo "<div class='text-center'>
			<h2>Top Rated Companies In Your City</h2>
		</div>";
		echo "<ul class='collection col-sm-6 col-sm-offset-3'>";
		while($companyData = mysqli_fetch_array($result)){
			echo "<li class='collection-item avatar'>
				<div class='circle'>".$rank."</div>
				<span class='title'>".$companyData['compName']."</span>
				<p>".$companyData['cityName']."</p>
				<p>".$companyData['rates']."</p>
				<a href='#!' class='secondary-content'><i class='material-icons'>grade</i></a>
		    </li>";
			$rank++;
		}
		echo "</tbody>
		</ul>";
	}

	mysqli_close($connection);
}else{
	echo "You don't have permission to access this piece of information. Go to <a href='/'>home page</a>";
}
?>
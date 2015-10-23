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
	if($_REQUEST['t'] == 'timeline'){
		$query = "SELECT * FROM `post`
			INNER JOIN `user` ON `user`.`userid`=`post`.`userID`
			LIMIT 5";
		$result = mysqli_query($connection, $query)
		or die('<div class="error">Query failed at 1</div>');
		echo '<div class="boxmodified">
			<div class="post-box">
				<div class="input-field">
					<textarea class="materialize-textarea" id="posting" ></textarea>
					<label for="posting">Share An Update</label>
				</div>
				<button class="btn btn-success" id="post" value="POST">POST</button>
			</div>
		</div>
		<div class="boxmodified">
			<div class="title">
				Recent Updates
			</div>
			<div id="response1"></div>';
		while($postData = mysqli_fetch_array($result)){
			$date = explode("-", $postData['date']);
			echo "<div class='post-box'>
				<div class='post-name'>".$postData['username']." &nbsp;
				<span>".$date[2]." ".getMonth($date[1])." ".$date[0]."</span>
				</div>
				<div class='post-msg'>".$postData['content']."
				</div>
				<div class='post-foot'>
					<span class='fa fa-thumbs-up'>".$postData['upvote']."</span>&nbsp;&nbsp;
					<span class='fa fa-thumbs-down'>".$postData['downvote']."</span>
				</div>
			</div>";
		}
		echo "</div>";
	}else if($_REQUEST['t'] == 'post'){
		if(!(isset($_REQUEST['d'])) or empty($_REQUEST['d'])){
			die('<div class="error">Data is not set properly.</div>');
		}
		$d = str_replace("\"", "\\\"", $_REQUEST['d']);
		$query = "INSERT INTO `post`(`userID`, `content`, `date`) VALUES ('".$_SESSION['userid']."', '".$d."', '".date('Y-m-d')."')";
		$result = mysqli_query($connection, $query)
		or die('<div class="error">Query failed at 1</div>');
		echo "<div class='post-box'>
			<div class='post-name'>".$_SESSION['username']."&nbsp;
			<span>now</span>
			</div>
			<div class='post-msg'>".$_REQUEST['d']."
			</div>
			<div class='post-foot'>
				<span class='fa fa-thumbs-up'>0</span>&nbsp;&nbsp;
				<span class='fa fa-thumbs-down'>0</span>
			</div>
		</div>";
	}else if($_REQUEST['t'] == 'rankings'){
		if(isset($_REQUEST['city']) and isset($_REQUEST['c']) ){
			$query = "SELECT `company`.`name` AS `compName`, `city`.`name` AS `cityName` , avg(`rating`) AS `rates`
				FROM `review`
				INNER JOIN `company`
				ON `review`.`companyID`=`company`.`id`
				INNER JOIN `city`
				ON `company`.`city`=`city`.`cityID`
				WHERE `city`.`cityID`='".$_REQUEST['c']."'
				ORDER BY avg(`rating`) DESC";
		}else if(isset($_REQUEST['size']) and isset($_REQUEST['sl']) and isset($_REQUEST['su']) ){
			$query = "SELECT `company`.`name` AS `compName`, `city`.`name` AS `cityName` , avg(`rating`) AS `rates`
				FROM `review`
				INNER JOIN `company`
				ON `review`.`companyID`=`company`.`id`
				INNER JOIN `city`
				ON `company`.`city`=`city`.`cityID`
				WHERE `company`.`totalEmployee`>'".$_REQUEST['sl']."' AND `company`.`totalEmployee`<'".$_REQUEST['su']."'
				ORDER BY avg(`rating`) DESC";
		}else{
			$query = "SELECT `company`.`name` AS `compName`, `city`.`name` AS `cityName` , avg(`rating`) AS `rates`
				FROM `review`
				INNER JOIN `company`
				ON `review`.`companyID`=`company`.`id`
				INNER JOIN `city`
				ON `company`.`city`=`city`.`cityID`
				ORDER BY avg(`rating`) DESC";
		}
		$result = mysqli_query($connection, $query)
		or die("<user><error content='Query failed at 2'></error></user>");
		echo '<div class="boxmodified">
				<div class="title">Top Rating Companies</div>
			</div>
			<div class="boxmodified">
			<ul class="collection">';
		$rank = 1;
		while($companyData = mysqli_fetch_array($result)){
			if(empty($companyData['compName']))
				die('<div class="error">There are no companies satisfying this query.</div></ul>');
			echo "<li class='collection-item avatar'>
				<div class='circle'>".$rank."</div>
				<span class='title'>".$companyData['compName']."</span>
				<p>".$companyData['cityName']."</p>
				<p> Ratings : ".$companyData['rates']."</p>
				<a href='#!' class='secondary-content'><i class='material-icons'>grade</i></a>
		    </li>";
			$rank++;
		}
		echo "</tbody>
			</ul>
		</div>";
	}else if($_REQUEST['t'] == 'statistics'){
		$query = "SELECT * FROM `user` WHERE `userid`='".$_SESSION['userid']."' ";
		$result = mysqli_query($connection, $query)
		or die('<div class="error">Can not process query.</div>');
		$query1 = "SELECT * FROM `company` ";
		$result1 = mysqli_query($connection, $query1)
		or die('<div class="error">Can not process query.</div>');
		$userData = mysqli_fetch_array($result);
		echo "<div class='boxmodified'>
			<div class='title'>
				Statistics Area
			</div>
		</div>
		<div class='boxmodified'>
			<div class='post-box'>
				<div class='input-field col sm 12'>
					<select name='company-data' id='company-data' class='browser-default'>
						<option value='0' disabled selected>Select Company Name</option>";
		while($companyData = mysqli_fetch_array($result1)){
				echo "<option value='".$companyData['id']."'>".$companyData['name']."</option>";
		}
		echo"</select>
				</div>
			</div>
			<div class='post-box'>
				<button id='generate-data' class='btn btn-info'>Generate Statistics</button>
			</div>
		</div>";
	}
}else{
	echo "You don't have permission to access this piece of information. Go to <a href='/'>home page</a>";
}

?>
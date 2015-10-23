<?php
session_start();
require('/php/connectdb.php');

$connection = mysqli_connect('localhost', $username, $password)
or die('Can\'t connect to this network');
$db = mysqli_select_db($connection, $database)
or die('Can\'t connect to this network');

if(!(isset($_SESSION['username']))){
	header('Location: /');
	die();
}

$company = $_REQUEST['t'];
$query = "SELECT * FROM `company` WHERE id='".$company."' ";
$result = mysqli_query($connection, $query)
or die("Can not perform query.");
$companyData = mysqli_fetch_array($result);
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $_SESSION['username']; ?> | Super Workplaces</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link href="css/materialize.min.css" rel="stylesheet">
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.min.css">
	<link rel="stylesheet" type="text/css" href="css/font-awesome.css">
	<link rel="stylesheet" type="text/css" href="css/stats.css">
	<script src="js/jquery.min.js"></script>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
	<script src="js/mapNew.js"></script>
</head>
<body>
	<div class="navbar navbar-default navbar-fixed-top" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-main">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="/">Super Workplaces</a>
				</div>
				<div class="collapse navbar-collapse" id="navbar-collapse-main">
				<ul class="nav navbar-nav navbar-right">
					<li><a href="/">Home</a></li>
					<li><a href="/review.php">Reviews</a></li>
					<li class="dropdown">
			            <a href="#" class="dropdown-toggle" data-toggle="dropdown">My Account<span class="caret"></span></a>
			            <ul class="dropdown-menu" role="menu">
							<li><a href="/profile.php"><i class="fa fa-user fa-fw"></i> Profile</a></li>
							<li class="divider"></li>
							<li><a id="logout" style="cursor:pointer;"><i class="fa fa-lock fa-fw"></i> Log Out</a></li>
			            </ul>
			        </li>
				</ul>
			</div>
		</div>
	</div>
	<div class="division col-sm-8 col-sm-offset-2" style="top:60px;" id="<?php echo $company;?>">
	<div class="page-header" id="<?php echo $companyData['name']; ?>">
		<h2>Company details of <?php echo $companyData['name']; ?></h2>
	</div>
	<div class="separator20"></div>
	<div id="chart_div"></div>
	<div class="separator10"></div>
	<div id="piechart"></div>
	</div>
	<footer>
		<div class="container text-center">
			<div class="row">
				<div class="columns">
					<ul class="social-links text-center">
						<li>
						  	<a title="Follow us on Facebook" href="https://www.facebook.com/knowledgesharingsessions/" class="fa fa-facebook-square fa-lg fa-2x" rel="nofollow" target="_blank"></a>
						</li>
						<li>
							<a title="Follow us on Twitter" href="http://twitter.com/kssonline" class="fa fa-twitter-square fa-lg fa-2x" rel="nofollow" target="_blank"></a>
						</li>
					</ul>
				</div>
			</div>
			<div class="row">
				<div class="columns">
					<p>Copyright &copy; KSS Foundations 2015</p>
				</div>
			</div>
		</div>
	</footer>
	<!-- attach JavaScripts -->
	<script src="js/bootstrap.min.js"></script>
	<script src="js/materialize.js"></script>
	<script src="js/validate.js"></script>
	<script src="js/profile.js"></script>
	<!-- javascript ending -->
</body>
</html>
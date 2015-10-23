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

$query = "SELECT *, `company`.`name` AS `compName`, `user`.`name`AS `uname`, `user`.`city` AS `cname` FROM `user`
	LEFT JOIN `company`
	ON `user`.`companyID`=`company`.`id` WHERE `userid`='".$_SESSION['userid']."'";
$result = mysqli_query($connection, $query)
or die('Can\'t Process The Request. Go to <a href="/">home page</a>');
$userDetail = mysqli_fetch_array($result);

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
	<link href="css/homestyle.css" rel="stylesheet" />
	<link rel="stylesheet" type="text/css" href="css/font-awesome.css">
	<script src="js/jquery.min.js"></script>
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
			            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Options<span class="caret"></span></a>
			            <ul class="dropdown-menu" role="menu">
							<li><a data-toggle="modal" data-target="#bug-container" style="cursor:pointer;"><i class="fa fa-pencil fa-fw"></i> Report bug</a></li>
			            	<li><a data-toggle="modal" data-target="#pass-mod" style="cursor: pointer;"><i class="fa fa-fw fa-gears"></i> Change Password</a></li>
							<li class="divider"></li>
							<li><a id="logout" style="cursor:pointer;"><i class="fa fa-lock fa-fw"></i> Log Out</a></li>
			            </ul>
			        </li>
				</ul>
			</div>
		</div>
	</div>
	<?php if(!(isset($_REQUEST['edit']))){?>
	<div class="container main">
		<div class="col-sm-3 user-detail">
			<div class="detail">
				<div class="image full">
					<?php if($userDetail['profile'] == '')
						echo "<div class='img-responsive img-rounded image-inner'></div>";
					else
						echo "<div class='img-responsive img-rounded image-inner' style='background-image: url(".$userDetail['profile']."); '></div>"; ?>
				</div>
				<div class="name full"><?php echo $userDetail['uname'];?></div>
				<div class="email full" title="Email Address">
					<span class="glyphicon glyphicon-send" aria-hidden="true"></span>
					<span class="email-container">
						<a href="mailto: <?php echo $userDetail['email']?>"> <?php echo $userDetail['email']?></a>
					</span>
				</div>
				<div class="college full" title="Works At">
					<span class="fa fa-university" aria-hidden="true"></span> Works at <?php echo $userDetail['compName']?>
				</div>
				<div class="city full" title="Current City">
					<span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span> <?php echo $userDetail['cname']?>
				</div>
			</div>
			<h4>Options</h4>
			<div class="options">
				<div class="full active" data-target="timeline" data-skip="0">TimeLine</div>
				<div class="full" data-target="statistics">Statistics</div>
				<div class="full" data-target="rankings">Rankings</div>
			</div>
			<div class="options-new">
			</div>
		</div>
		<div class="col-sm-7 user-helper" id="response">
			<div class="preloader-wrapper small active">
			    <div class="spinner-layer spinner-blue-only">
			      <div class="circle-clipper left">
			        <div class="circle"></div>
			      </div><div class="gap-patch">
			        <div class="circle"></div>
			      </div><div class="circle-clipper right">
			        <div class="circle"></div>
			      </div>
			    </div>
			</div>
		</div>
		<div class="col-sm-2 user-edit-button">
			<a class="btn btn-danger" href="/profile.php?edit=1" id="edit">Edit Profile</a>
		</div>
	</div>
	<?php }else{?>
	<div class="container main">
		<div class="col-sm-3 user-detail">
			<div class="form-group">
				<div class="image full">
				<?php if($userDetail['profile'] == '')
					echo "<div class='img-responsive img-rounded image-inner'></div>";
				else
					echo "<div class='img-responsive img-rounded image-inner' style='background-image: url(".$userDetail['profile'].");'></div>"; ?>
					<form id="image-form">
						<div class="file-field input-field">
							<div class="btn btn-block">
								<span><i class='fa fa-camera'></i> Upload</span>
								<input type="file" name="image" id="image-file">
							</div>
					    </div>
					    <input type="submit" id="image-form-submit" class="hidden">
					</form>
				</div>
				<form id="userDetailform" method="POST" action="javascript: update()">
					<div class="form-group">
						<input type="text" class="form-control" name="name" id="name" placeholder="Your Name" value="<?php echo $userDetail['uname']?>" required />
					</div>
					<div class="form-group" title="Email Address">
						<input type="email" class="form-control" name="email" id="email" placeholder="Your Email" value="<?php echo $userDetail['email']?>" required />
					</div>
					<div class="form-group" title="Works At">
						<input type="text" class="form-control" name="college" id="college" placeholder="Your Office" value="<?php echo $userDetail['compName']?>" >
					</div>
					<div class="form-group" title="Current City">
						<input type="text" class="form-control" name="city" id="city" placeholder="Current City" value="<?php echo $userDetail['cname']?>" >
					</div>
					<input type="submit" class="hidden" id="editfinal_shadow">
				</form>
			</div>
		</div>
		<div class="col-sm-7 user-helper">
			<div class="boxmodified disabled">

			<div class="boxmodified disabled">
				
			</div>
		</div>
		<div class="col-sm-2 user-edit-button">
			<button class="btn btn-danger" id="editfinal">Done Editing</button>
			<a class="btn btn-info" href="/profile.php">Cancel Editing</a>
		</div>
	</div>
	<?php }?>

	<!-- modal -->

	<div class="modal fade" id="bug-container" tabindex="-1" role="dialog" aria-labelledby="bugsubmit" aria-hidden="true">
		<div class="modal-dialog">
		  <div class="modal-content">
		    <div class="modal-header">
		      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		      <h4 class="modal-title" id="bugmodal">Please fill in the details about problem you faced</h4>
		    </div>
		    <div class="modal-body">
		        <div class="form-group">
		          <label for="recipient-name" class="control-label">Enter your Email Address:</label>
		          <input type="email" class="form-control" id="bugmail" required="required" placeholder="Email address">
		        </div>
		        <div class="form-group">
		          <label for="recipient-name" class="control-label">Subject: </label>
		          <input type="text" class="form-control" id="bug" required="required" placeholder="Subject">
		        </div>
		        <div class="form-group">
		          <label for="recipient-name" class="control-label">Enter Details about bug you faced: </label>
		          <textarea type="text" class="form-control" id="bugbody" required="required" placeholder="Detailed description of Bug ." data-toggle="tooltip" data-placement="bottom" data-tooltip="As of now we don't have support for submission of other media types so please try to explain it in detailed description"></textarea>
		        </div>
		    </div>
		    <div class="modal-footer">
		      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		      <button type="button" id="bug-active" class="btn btn-primary">Submit Report</button>
		    </div>
		  </div>
		</div>
	</div>
	<div class="modal fade" id="pass-mod" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
		<div class="modal-dialog">
			<form class="modal-content" action="javascript: reset();">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="">Please fill in the details about problem you faced</h4>
				</div>
				<div class="modal-body">
				    <div class="form-group">
						<label for="recipient-name" class="control-label">Enter Current Password:</label>
						<input type="password" class="form-control" id="pass-o" required="required" placeholder="Current Password">
				    </div>
				    <div class="form-group">
						<label for="recipient-name" class="control-label">Enter New Password: </label>
						<input type="password" class="form-control" id="pass-n" required="required" placeholder="New Password" data-toggle="tooltip" data-placement="bottom" data-tooltip="Password should be atleast 5 characters long.">
				    </div>
				    <div class="form-group">
						<label for="recipient-name" class="control-label">Enter New Password Again: </label>
						<input type="password" class="form-control" id="pass-nr" required="required" placeholder="Enter New Password Again" data-toggle="tooltip" data-placement="bottom" data-tooltip="Re Enter new password for verification." />
				    </div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" id="bug-active" class="btn btn-primary">Change Password</button>
				</div>
			</form>
		</div>
	</div>
	<!-- modal ending -->
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
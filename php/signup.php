<?php
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
	require('connectdb.php');
	require('function.php');
	session_start();
	header("Content-type: text/xml");

	if(empty($_SESSION['captcha_code']) || strcasecmp($_SESSION['captcha_code'], $_REQUEST['captcha_code']) != 0){  
	    echo ("<user><error content='The Validation code does not match!' ></error></user>");
	    die();
	}
	if(isset($_SESSION['username'])){
		die("<user><error content='Another user is logged in. Please refresh the page or log out first.'></error></user>");
	}

	$connection=mysqli_connect ('localhost', $username, $password);
	if (!$connection) {
	  die('<user><error content="Not connected : ' . mysql_error().'"></error></user>');
	}

	$db_selected = mysqli_select_db($connection, $database);
	if (!$db_selected) {
	  die ('<user><error content="Can\'t use db : ' . mysql_error()).'"></error></user>';
	}

	$query = "SELECT * FROM user WHERE email='".$_REQUEST['email']."'";
	$result =mysqli_query($connection, $query) or die('<user><error content="Can\'t find email id :' .mysql_error().'"></error></user>');
	if(mysqli_num_rows($result) > 0){
		echo("<user><error content='Change the Email as it is already choosen'></error></user>" );
		die();
	}

	$a = $_REQUEST['uidai'];
	$b = $_REQUEST['name'];
	$c = $_REQUEST['city'];
	$d = $_REQUEST['pass'];
	$e = $_REQUEST['email'];
	$f = $_REQUEST['dob'];
	$g = $_REQUEST['gender'];
	$h = $_REQUEST['pin'];
	$i = $_REQUEST['username'];
	$i = str_replace('"', '\"', $i);
	$temp = explode("-", $f);
	$gNew = ($g = 1)?'male' : 'female';
	$fNew = $temp[0].$temp[1].$temp[2];
	$f = $temp[0]."-".$temp[1]."-".$temp[2];

	$url="https://ac.khoslalabs.com/hackgate/hackathon/auth/raw";
	$json=json_encode(array(
		"aadhaar-id"=>$a,
		"modality"=>"demo",
  		"device-id"=>"hp",
  		"certificate-type"=>"preprod",
  		"demographics"=>array(
    		"name"=>array(
      			"name-value"=>$b,
      		),
      		"dob"=>array(
      			"format"=>"YYYYMMDD",
      			"dob-value"=>$fNew,
      		),
      		"gender"=>$gNew,
      		"address-format"=>"structured",
      		"address-structured"=>array(
			    "pincode"=> $h,
    		)
   		),
  		"location"=>array(
    		"type"=>"pincode",
    		"pincode"=>$h,
  			)
		)
	);
	$options = array(
 		CURLOPT_RETURNTRANSFER => true,
	    CURLOPT_POST      => 1,    
	    CURLOPT_POSTFIELDS => $json,
	);
	$ch=curl_init($url);
	curl_setopt_array( $ch, $options );
	curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
   	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $content = curl_exec( $ch );
    curl_close( $ch );
    $response=json_decode($content,true);
    $response = str_replace('"', '', $response);
    // die($json);
    if($response['success'] != 1){
    	die("<user><error content='Aadhaar Authentication failed. Make sure your Pincode, Name, Gender, Date Of Birth and Aadhaar ID is yours only.'></error></user>");
    }

	// echo $f;
	$query = "INSERT INTO `user`( `name`, `email`, `password`, `aadhaarID`, `dateOfBirth`, `gender`, `pincode`, `city`, `dateOfJoin`, `username`) VALUES ('".$b."', '".$e."', '".md5($d)."', '".$a."', '".$f."', '".$g."', '".$h."', '".$c."', '".date('Y-m-d')."', '".$i."' )";
	// echo $query;
	$result = mysqli_query($connection, $query)
	or die("<user><error content='Cant Process Your Signup .Please try again after some time .'></error></user>");
	// echo $result;
	$query = "SELECT * FROM user WHERE email='".$e."' AND name='".$b."' ";
	$result = mysqli_query($connection, $query)
	or die("<user><error content='Can't perform login. But the user is registered. Please login from navigation bar.'></error></user>");
	$res = mysqli_fetch_array($result);

	$_SESSION["userid"] = $res["userid"];
	$_SESSION["mail"] = $res["email"];
	$_SESSION['username'] = $res['username'];

	echo "<user><success content='User logged in' ></success></user>";

	mysqli_close($connection);
}else{
	echo "You don't have permission to access this piece of information. Go to <a href='/'>home page</a>";
}
?>
<?php
  session_start();
  if(!isset($_SESSION['failedLogin'])){
      header('Location: /');
  }
  if(isset($_REQUEST['t'])){
    $type = $_REQUEST['t'];
  }else{
    header("Location: /loginattempt.php?t=1");
  }
?>
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="/favicon.png">
  <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
  <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
  <title> Login Attempt Failed | KSS Online </title>

  <!-- Bootstrap core CSS -->
  <link href="/css/bootstrap.min.css" rel="stylesheet">
  <link href="/css/bootstrap-theme.min.css" rel="stylesheet">
  <script src="js/jquery.min.js"></script>
  <script src="/js/ie-emulation-modes-warning.js"></script>
  <script src="/js/ie10-viewport-bug-workaround.js" ></script>
  <link rel="stylesheet" type="text/css" href="/css/minor.css">
  <link rel="stylesheet" type="text/css" href="/css/font-awesome.css">
</head>
<body>
  <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container-fluid">
      <div class="navbar-header">
        <a class="navbar-brand" href="/">
          KSS Online
        </a>
      </div>
    </div>
  </div>
  <div class="container">

    <form class="form-signin" role="form" method="POST" action="/php/newuser.php">
    <?php if($type == 1) { ?>
      <h3 class="form-signin-heading">Your email does not match any registered email id with us. Enter a valid email id or Create a new account.</h3>
      <input type="email" name="name" class="form-control" placeholder="Email address" required autofocus>
      <input type="password" name="pass" class="form-control" placeholder="Password" required>
    <?php }else if($type == 2) { ?>
      <h3 class="form-signin-heading">The password you have entered does not match.</h3>
      <input type="email" name="name" class="form-control" placeholder="Email address" value="<?php if(isset($_REQUEST['u'])) echo $_REQUEST['u']; if(!(isset($_REQUEST['u'])) or empty($_REQUEST['u'])) header("Location: /loginattempt.php?t=1"); ?>" required >
      <input type="password" name="pass" class="form-control" placeholder="Password" required autofocus>
    <?php } ?>
      <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
      <button class="btn btn-lg btn-info btn-block" id="signup">Want an account</button>
    </form>
  </div>
  <footer>
    <hr />
    <div class="container text-center">
      <div class="row">
        <div class="columns">
          <ul class="social-links text-center">
            <li>
              <a title="Follow us on Facebook" href="https://www.facebook.com/knowledgesharingsessions/" class="fa fa-facebook-square fa-lg fa-2x" rel="nofollow" target="_blank"></a>
            </li>
            <li>
              <a title="Follow us on Twitter" href="http://twitter.com/" class="fa fa-twitter-square fa-lg fa-2x" rel="nofollow" target="_blank"></a>
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

  <script type="text/javascript">
  $(document).ready(function(){
    if($(document).height() == $(window).height()){
      $('footer').css('bottom', '0px').css('position', 'absolute').css('width', '100%');
    }
    $('#signup').click(function(){
      window.location = '/';
    });
  });
  $(window).resize(function(){
    if($(document).height() == $(window).height()){
      $('footer').css('bottom', '0px').css('position', 'absolute').css('width', '100%');
    }else{
      $('footer').css('bottom', 'auto').css('position', 'relative').css('width', '100%');
    }
  });
  </script>
  <script src="/js/bootstrap.min.js"></script>
  <script src="/js/docs.min.js"></script>

</body>
</html>
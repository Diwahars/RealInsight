<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="utf-8" />
  <meta name="author" content="" />
  <?php if(!isset($_SESSION['username'])) {?>
  <title>Real Insight</title>
  <?php }else{ ?>
  <title> <?php echo $_SESSION['username'];?> | Real Insight </title>
  <?php } ?>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta name="description" content="">
  <link href="css/materialize.min.css" rel="stylesheet">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <meta name="keywords" content=""/>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" type="text/css" href="css/bootstrap-theme.min.css">
  <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href='https://fonts.googleapis.com/css?family=Poiret+One' rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css?family=Architects+Daughter' rel='stylesheet' type='text/css'>
  <link href="css/style.css" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="/css/font-awesome.css">
</head>
<body>
  <?php if(!(isset($_SESSION['username']))){ ?>
  <div class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-main">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#">Real Insight</a>
      </div>
      <div class="collapse navbar-collapse" id="navbar-collapse-main">
        <ul class="nav navbar-nav navbar-right">
          <li><a class="anime" data-target="#services">About Us</a></li>
          <li><a class="anime" data-target="#reviews">Contact us</a></li>
          <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="modal" href="#form-signup">Log In/Sign Up<span class="caret"></span></a>
          </li>
        </ul>
      </div>
    </div>
  </div>
  <?php }else{ ?>
  <div class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-main">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#">Real Insight</a>
      </div>
      <div class="collapse navbar-collapse" id="navbar-collapse-main">
        <ul class="nav navbar-nav navbar-right">
          <li><a class="anime" data-target="#services">About Us</a></li>
          <li><a class="anime" data-target="#reviews">Contact us</a></li>
          <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">My Account<span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li>
                  <a href="/profile.php">
                    <i class="fa fa-user fa-fw"></i> Profile
                  </a>
                </li>
                <li class="divider"></li>
                <li>
                  <a id="logout" style="cursor:pointer;">
                    <i class="fa fa-lock fa-fw"></i> Log Out
                  </a>
                </li>
              </ul>
          </li>
        </ul>
      </div>
    </div>
  </div>
  <?php } ?>

  <!-- first section - Home -->
  <?php if(isset($_REQUEST['city']) and !(empty($_REQUEST['city']))){ ?>
    <!-- <div id="home" class="home" style="background-image: url(); "> -->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
      <div id="myCarousel" data-city="<?php echo $_REQUEST['city']; ?>" class="carousel slide" data-ride="carousel" data-interval="3000">
        <div class="change">
          <a href='/'>Change City</a>
        </div>
        <!-- Indicators -->
        <ol class="carousel-indicators">
          <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
          <li data-target="#myCarousel" data-slide-to="1"></li>
        </ol>
        <div class="carousel-inner">
          <div class="item active">
            <div id="curve_chart"></div>
            <div class="container">
              <div class="carousel-caption">
              </div>
            </div>
          </div>
          <div class="item">
            <div id="ranking"></div>
            <div class="container">
              <div class="carousel-caption">
              </div>
            </div>
          </div>
        </div>
      </div>
  <?php }else{ ?>
    <div id="home" class="home" style="background-image: url(../images/story.jpg); background-repeat: no-repeat; background-position: center top; background-size: cover;">
      <div class="text-vcenter">
        <div class="container">
          <div class="special-elem col-sm-12">
            <h1>Real Insight</h1>
            <div class="input-field col-sm-4 col-sm-offset-4 text-center">
              <select class="browser-default">
                <option value="" disabled selected>Choose Your City</option>
                <option value="1">Delhi-NCR</option>
                <option value="2">Bangalore</option>
              </select>
            </div>
          </div>
        </div>
      </div>
      <div class="bottom signal">
        <a class="fa fa-angle-down"></a>
      </div>
    </div>
  <?php } ?>
  <!-- /first section -->
  
  <div class="main">

    <!-- third section - Services -->
    <div id="services" class="pad-section">
      <div class="container">
        <div class="page-header text-center">
          <h2>Our Services</h2>
        </div>
        <div class="row text-center">
          <div class="col-sm-3 col-xs-6">
            <i class="fa fa-user-plus fa-3x"> </i>
            <h4>Create Account</h4>
            <p>Create your account using AADHAR Number and make sure your email registered with us is company email and you will have access to reviews for every company.</p>
          </div>
          <div class="col-sm-3 col-xs-6">
            <i class="fa fa-phone fa-3x"> </i>
            <h4>Verify Your Company</h4>
            <p>Verification of company is done using your email address. So that only verified users can have access to reviewing system and massess get only valid user response.</p>
          </div>
          <div class="col-sm-3 col-xs-6">
            <i class="fa fa-suitcase fa-3x"> </i>
            <h4>Review Daily Work</h4>
            <p>Just fill up a daily form after you get off from work and we will compile it for you to make things go fast and accurate. This is only stuff you need to write to and we will even send you alerts for the review so that you don't miss a day.</p>
          </div>
          <div class="col-sm-3 col-xs-6">
            <i class="fa fa-arrow-up fa-3x"></i>
            <h4>Reach Top Spot</h4>
            <p>With every review your company will gain some points and addition of those points will make the company a real insight or a dull workplace.</p>
          </div>
        </div>
      </div>
    </div>
    <!-- /third section -->

    <!-- sixth section -->
    <div id="reviews" class="pad-section">
      <div class="container">
        <div class="row">
          <div class="page-header text-center">
            <h1>Contact Us</h1>
          </div>
          <div class="col-sm-6">
            <div class="center-text">
              <h1>Your reviews and feedbacks are most important to us.</h1>
            </div>
          </div>
          <div class="col-sm-6">
            <form role="form" id="footer-form" method="" action="javascript: mailme();">
              <div class="row">
                <div class="input-field col s12">
                  <input id="name2" type="text" name="name2" class="validate">
                  <label for="name2">Name</label>
                </div>
              </div>
              <div class="row">
                <div class="input-field col s12">
                  <input id="email2" type="email" name="email2" class="validate">
                  <label for="email2">Email Address</label>
                </div>
              </div>
              <div class="row">
                <div class="input-field col s12">
                  <input id="subject2" name="subject2" type="text" class="validate">
                  <label for="subject2">Subject</label>
                </div>
              </div>
              <div class="row">
                <div class="input-field col s12">
                  <textarea id="message2" name="message2" class="materialize-textarea"></textarea>
                  <label for="subject2">Message</label>
                </div>
              </div>
              <input type="submit" id="submit-active" value="Submit feedback" class="btn btn-success">
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- /sixth section -->

  </div>

  <!-- modal starting -->
  <div class="modal fade" id="recover-container" tabindex="-1" role="dialog" aria-labelledby="recoverymodal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="recoverymodal">Enter Your Email Address To Recover The Password</h4>
        </div>
        <div class="modal-body">
            <div class="input-field col s12">
              <input type="email" class="validate" id="recover" required="required">
              <label for="recover">Enter your Email Address</label>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" id="recover-active" class="btn btn-primary">Recover Password</button>
        </div>
      </div>
    </div>
  </div>
    
  <div class="modal fade" id="form-signup" tabindex="-1" role="dialog" aria-labelledby="signupLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <div class="btn-group btn-group-justified text-center">
            <div class="btn-group logsign log">Log In</div>
            <div class="btn-group active logsign sign">Sign Up</div>
          </div>
        </div>
        <div class="logsign-data">
          <form action="javascript: validate();" id="signup-form">
            <div class="modal-body">
              <div class="input-field col s12">
                <input class="validate tooltipped" data-position="bottom" data-delay="50" data-tooltip="Please Enter the same name as in your Aadhaar Card" type="text" name="sign-name" id="sign-name" required>
                <label for="sign-name">Your Name</label>
              </div>
              <div class="input-field col s12">
                <input class="validate tooltipped" data-position="bottom" data-delay="50" data-tooltip="Please Enter Your 12 digit Aadhaar ID" type="text" name="sign-aadhaar" id="sign-aadhaar" required>
                <label for="sign-aadhaar">Your Aadhaar ID</label>
              </div>
              <div class="input-field col s12">
                <input class="datepicker" data-position="bottom" data-delay="50" data-tooltip="Please Enter Your Date Of Birth as mentioned in Aadhaar Card" type="date" name="sign-dob" id="sign-dob" required>
                <label for="sign-dob">Your Birth Date</label>
              </div>
              <div class="input-field col s12">
                <select id="sign-gender">
                  <option value="" disabled selected>Choose your gender</option>
                  <option value="1">Male</option>
                  <option value="2">Female</option>
                </select>
                <label>Select Gender</label>
              </div>
              <div class="input-field col s12">
                <input class="validate" type="number" name="sign-pin" id="sign-pin" required>
                <label for="sign-pin">Pin Code</label>
              </div>
              <div class="input-field col s12">
                <input class="validate" type="email" name="sign-mail" id="sign-mail" title="This will be your login credential" required>
                <label for="sign-mail">Email Id</label>
              </div>
              <div class="input-field col s12">
                <input class="validate" type="text" name="sign-username" id="sign-username" required>
                <label for="sign-username">Choose A UserName</label>
              </div>
              <div class="input-field col s12">
                <input class="validate" type="password" name="sign-pass" id="sign-pass" title="Make sure your password is atleast 6 characters long" required>
                <label for="sign-pass">Password</label>
              </div>
              <div class="input-field col s12">
                <input class="validate" type="password" name="sign-pass1" id="sign-pass1" title="Make sure your password is atleast 6 characters long and same as above" required>
                <label for="sign-pass1">Reenter Password</label>
              </div>
              <div class="input-field col s12 ">
                <input class="validate" type="text" name="sign-city" id="sign-city" title="This is required for showing you events in your area." required>
                <label for="sign-city">Current City</label>
              </div>
              <div class="divider"></div>
              <img src="/php/captcha.php?rand=<?php echo rand();?>" id='captchaimg' style="max-width:150px" />
              <br><br>
              <div class="input-field col s12">
                <input type="text" id="captcha_code" name="captcha_code" maxlength="6" class="validate" title="This is to make sure that you are Human"/>
                <label for="captcha_code">Enter the above code</label>
              </div>
              Can't read the image? click <a href='javascript: Motion.refreshCaptcha();'>here</a> to refresh.
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <input type="submit" name="Submit" id="signup-active" class="btn btn-success" value="Create Account" />
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- modal ending -->

  <!-- footer -->
  <footer>
    <hr />
    <div class="container text-center">
      <div class="row">
        <div class="columns">
          <ul class="social-links text-center">
            <li>
              <a title="Follow us on Facebook" href="https://www.facebook.com/" class="fa fa-facebook-square fa-lg fa-2x" rel="nofollow" target="_blank"></a>
            </li>
            <li>
              <a title="Follow us on Twitter" href="https://twitter.com/" class="fa fa-twitter-square fa-lg fa-2x" rel="nofollow" target="_blank"></a>
            </li>
          </ul>
        </div>
      </div>
      <div class="row">
        <div class="columns">
          <p>Copyright &copy; Real Insight 2015</p>
        </div>
      </div>
    </div>
  </footer>
  <!-- /footer -->

  <!-- attach JavaScripts -->
  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/materialize.min.js"></script>
  <script src="js/validate.js"></script>
  <script src="js/main.js"></script>
  <script src="js/docs.min.js"></script>
  <script type="text/javascript" src="/js/chart.js"></script>
  <!-- javascript ending -->

</body>
</html>
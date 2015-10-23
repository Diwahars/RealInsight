<?php 
if(!(empty($_SERVER['HTTP_X_REQUESTED_WITH'])) and strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
	if(!(isset($_REQUEST['c']))){
		die("<div class='error'>Data is not valid.</div>");
	}
	if($_REQUEST['c'] == 2)
		echo('<form action="javascript: validate();" id="signup-form">
            <div class="modal-body">
              <div class="input-field col s12">
                <input class="validate tooltipped" data-position="bottom" data-delay="50" data-tooltip="Please Enter the same name as in your Aadhaar Card" type="text" name="sign-name" id="sign-name" required>
                <label for="sign-name">Your Name</label>
              </div>
              <div class="input-field col s12">
                <input class="validate tooltipped" data-position="bottom" data-delay="50" data-tooltip="Please Enter Your 12 digit Aadhaar ID" type="text" name="sign-aadhaar" id="sign-aadhaar" required>
                <label for="sign-aadhaar">Your Aadhaar ID</label>
              </div>
              <div class="input-field col 12">
                <span style="font-size: 15px;">Your Birth Date</span>
                <input data-position="bottom" data-delay="50" data-tooltip="Please Enter Your Date Of Birth as mentioned in Aadhaar Card" type="date" name="sign-dob" id="sign-dob" required>
              </div>
              <div class="input-field col s12">
                <select id="sign-gender" class="browser-default">
                  <option value="" disabled selected>Choose your gender</option>
                  <option value="1">Male</option>
                  <option value="2">Female</option>
                </select>
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
              <img src="/php/captcha.php?rand=<?php echo rand();?>" id=\'captchaimg\' style="max-width:150px" />
              <br><br>
              <div class="input-field col s12">
                <input type="text" id="captcha_code" name="captcha_code" maxlength="6" class="validate" title="This is to make sure that you are Human"/>
                <label for="captcha_code">Enter the above code</label>
              </div>
              Can\'t read the image? click <a href=\'javascript: Motion.refreshCaptcha();\'>here</a> to refresh.
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <input type="submit" name="Submit" id="signup-active" class="btn btn-success" value="Create Account" />
            </div>');
	else if($_REQUEST['c'] == 1)
		echo('<form class="navbar-form" role="form" id="login-form" action="/php/newuser.php" method="POST">
				<div class="modal-body">
                  <div class="input-field col s12">
                    <input type="text" id="logid" name="name" class="validate">
                    <label for="logid">Enter Email</label>
                  </div>
                  <div class="input-field col s12">
                    <input type="password" id="logpass" name="pass" class="validate">
                    <label for="logpass">Enter Password</label>
                  </div>
                  <label class="text" data-toggle="modal" data-target="#recover-container" id="forgot">Forgot Password ?</label>
                </div>
                <div class="modal-footer">
              	  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button type="submit" id="login" class="btn btn-primary">Sign In</button>
                </div>
                </form>');
}else{
	echo "Error !!";
}
?>
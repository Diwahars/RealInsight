$(document).ready(function(){
    $("html, body").animate({scrollTop: 0}, "slow");
	$(function () {
      $('[data-toggle="tooltip"]').tooltip();
    })
    $('#form-signup').on('shown.bs.modal', function () {
        $('#sign-name').focus()
    });
    $('#logout').click(function(){
    	setTimeout(function(){
    		window.location = '/php/error.php';
    	},100);
    });
    $('#recover-active').click(function(){
        var to = $('#recover').val();
        var email = Motion.testEmail('#recover', '#recover-container .modal-body');
        if(email){
        	$('#recover-active').attr('disabled', 'disabled');
            $.ajax({
                url: '/php/recovery.php?to='+to,
                success: function(data){
        			$('#recover-active').removeAttr('disabled');
                    $('#recover').parent().find('.glyphicon').remove();
                    $('#recover-container').find('.alert').remove();
                    if(data.documentElement.getElementsByTagName('success').length > 0){
                        $('#recover-container').find('.modal-body').prepend("<div class='alert alert-success alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><strong>hurray!</strong> We have send you your new password at your mail.</div>");
                    }else{
                        $('#recover-container').find('.modal-body').prepend("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><strong>Oh Snap!</strong> " + data.documentElement.getAttribute('content') + "</div>");
                    }
                }
            });
        }
    });
    if($(window).width() < '600' || $(window).height() < '400'){
        $(".bottom.signal").css('display', 'none');
    }else{
        $(".bottom.signal").css('display', 'table-row-group');
    }
    $('.bottom.signal').click(function(){
        $("html, body").animate({scrollTop: $('#services').offset().top}, "slow");
    });
    $('.nav .anime').click(function(){
        $("html, body").animate({scrollTop: $($(this).attr('data-target')).offset().top}, "slow");
    });
    $('.logsign').click(function(){
        if($(this).attr('class').indexOf('active') != -1)
            return;
        if($(this).html() == 'Log In'){
            $.ajax({
                url: '/php/getField.php?c=1',
                success: function(data){
                    $('.logsign-data').html(data);
                    $('.logsign').removeClass('active');
                    $('.log').addClass('active');
                }
            });
        }else if($(this).html() == 'Sign Up'){
            $.ajax({
                url: '/php/getField.php?c=2',
                success: function(data){
                    $('.logsign-data').html(data);
                    $('.logsign').removeClass('active');
                    $('.sign').addClass('active');
                }
            });
        }
    });
    $('select').material_select();
    $('.browser-default').change(function(){
        window.location = '?city='+$('.browser-default option:selected').attr('value');
    });
    $('.logsign-data').on('click', '#forgot', function(){
        $('.logsign-data .btn.btn-default').click();
    });
    $('.datepicker').pickadate({
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 50, // Creates a dropdown of 15 years to control year
        format: 'yyyy-mm-dd'
    });
});

$(window).resize(function(){
    if($(window).width() < '600' || $(window).height() < '400'){
        $(".bottom.signal").css('display', 'none');
    }else{
        $(".bottom.signal").css('display', 'table-row-group');
    }
});


function validate(){
    var name = false;
    var pass = false;
    var city = false;
    var email = false;
    var i;

    a = $('#sign-name').val();
    var arr = "~`@!#$%^&*+=-[]\\\';,/{}|\":<>?0123456789";
    if(a.length > 2){
        for(i=0; i<a.length; i++){
            if(arr.indexOf(a.charAt(i)) !== -1){break;}
        }
        if(i === a.length){
            name = true;
            $('#sign-name').parent().find('.glyphicon').remove();
            $('#sign-name').parent().append("<span class='glyphicon glyphicon-ok form-control-feedback green' aria-hidden='true'></span>");
        }else{
            $('#sign-name').parent().find('.glyphicon').remove();
            $('#sign-name').parent().append("<span class='glyphicon glyphicon-remove form-control-feedback red' aria-hidden='true'></span>");
            Motion.printmessage("Your name can't have special characters or numbers.", '#signup-form .modal-body', "", false, "#signup-form"); return;
        }
    }else{
        $('#sign-name').parent().find('.glyphicon').remove();
        $('#sign-name').parent().append("<span class='glyphicon glyphicon-remove form-control-feedback red' aria-hidden='true'></span>");
        Motion.printmessage("Your name should have atleast 3 charachters.", '#signup-form .modal-body', "", false, "#signup-form"); return;
    }
    var aadhaar = Motion.testExact('#sign-aadhaar', 'Aadhaar ID', '#form-signup .modal-body', 12);
    if(aadhaar){
        var dob = $('#sign-dob').val();
        if(dob){
            var gender = $('#sign-gender option:selected').attr('value') > 0 && $('#sign-gender option:selected').attr('value') < 3;
            if(gender){
                var pincode = Motion.testExact('#sign-pin', 'Pincode', '#form-signup .modal-body', 6);
                if(pincode){
                    var username = Motion.testLength('#sign-username', 'username', '#form-signup .modal-body', 6);
                }
            }else return;
        }else return;
    }else return;
    b = $('#sign-mail').val();
    var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if(!filter.test(b)){
        $('#sign-mail').parent().find('.glyphicon').remove();
        $('#sign-mail').parent().append("<span class='glyphicon glyphicon-remove form-control-feedback red' aria-hidden='true'></span>");
            
        Motion.printmessage("Your email soes not match a valid email string.",'#signup-form .modal-body', "", false, "#signup-form"); return;
    }else{
        email = true;
        $('#sign-mail').parent().find('.glyphicon').remove();
        $('#sign-mail').parent().append("<span class='glyphicon glyphicon-ok form-control-feedback green' aria-hidden='true'></span>");
    }

    c = $('#sign-pass').val();
    d = $('#sign-pass1').val();
    if(c.length < 6){
        Motion.printmessage("Password should be atleast 6 characters long.", '#signup-form .modal-body', "", false, "#signup-form"); return;
    }
    if(c===d && c.length>5){
        pass = true;
        $('#sign-pass1').parent().find('.glyphicon').remove();
        $('#sign-pass1').parent().append("<span class='glyphicon glyphicon-ok form-control-feedback green' aria-hidden='true'></span>");
    }else{
        $('#sign-pass1').parent().find('.glyphicon').remove();
        $('#sign-pass1').parent().append("<span class='glyphicon glyphicon-remove form-control-feedback red' aria-hidden='true'></span>");
        Motion.printmessage("Password does not match. Please check again. ", '#signup-form .modal-body', "", false, "#signup-form"); return;
    }

    f = $('#sign-city').val();
    var arr2 = "~`@!#$%^&*+=[]\\\';,-/{}|\":<>?";
    if(f.length > 2){
        for(i=0; i<f.length; i++){
            if(arr2.indexOf(f.charAt(i)) !== -1){break;}
        }
        if(i=== f.length){
            city = true;
            $('#sign-city').parent().find('.glyphicon').remove();
            $('#sign-city').parent().append("<span class='glyphicon glyphicon-ok form-control-feedback green' aria-hidden='true'></span>");
        }else{
            $('#sign-city').parent().find('.glyphicon').remove();
            $('#sign-city').parent().append("<span class='glyphicon glyphicon-remove form-control-feedback red' aria-hidden='true'></span>");
            Motion.printmessage("City name should be in english and can't have special characters.", '#signup-form .modal-body', "", false, "#signup-form"); return;
        }
    }else{
        $('#sign-city').parent().find('.glyphicon').remove();
        $('#sign-city').parent().append("<span class='glyphicon glyphicon-remove form-control-feedback red' aria-hidden='true'></span>");
        Motion.printmessage("City name should be atleast 3 characters long.", '#signup-form .modal-body', "", false, "#signup-form"); return;
    }


    if(name===true && pass===true && email==true && city==true && username){
        var payload = { "name":a, "uidai": $('#sign-aadhaar').val(), "dob": $('#sign-dob').val(), "gender": $('#sign-gender option:selected').attr('value'), "pin": $('#sign-pin').val(), "email":b, "username": $('#sign-username').val(), "pass":c, "city":f, "captcha_code": $('#captcha_code').val() };
        $('#signup-active').attr('disabled', 'disabled');
        console.log(payload);
    	$.ajax({
    		url: '/php/signup.php',
    		type: "POST",
    		data: payload,
        	success: function(data){
                console.log(data);
        		$('#signup-active').removeAttr('disabled');
	            if(data.documentElement.getElementsByTagName('success').length > 0){
	                $('#sign-college').val('');
	                $('#sign-name').val('');
	                $('#sign-mail').val('');
	                $('#sign-pass').val('');
	                $('#sign-pass1').val('');
	                $('#sign-city').val('');
	                $('#signup-form').find('.glyphicon').remove();
	                Motion.refreshCaptcha();
	                $('#captcha_code').val('');
	                setTimeout(function(){
	                	window.location = '/';
	                },200);
	            }else if(data.documentElement.getElementsByTagName('error').length > 0){
	            	var textData = data.documentElement.getElementsByTagName('error')[0].getAttribute('content');
	                $(window).scrollTop(0);
	                $('#signup-form .modal-body').find('.alert').remove();
	                $('#signup-form .modal-body').prepend("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><strong>Oh Snap!</strong>"+ textData +"</div>");
	                Motion.refreshCaptcha();
	                $('#captcha_code').val('');
	            }
	        }
	    });
    }
}

function mailme(){
	var name = false;
	var email = false;
	var subject = false;
	var mail = false;

    a = $('#name2').val();
    var arr = "~`@!#$%^&*+=-[]\\\';,/{}|\":<>?0123456789";
    if(a.length > 2){
        for(i=0; i<a.length; i++){
            if(arr.indexOf(a.charAt(i)) !== -1){break;}
        }
        if(i === a.length){
            name = true;
            $('#name2').parent().find('.glyphicon').remove();
            $('#name2').parent().append("<span class='glyphicon glyphicon-ok form-control-feedback green' aria-hidden='true'></span>");
        }else{
            $('#name2').parent().find('.glyphicon').remove();
            $('#name2').parent().append("<span class='glyphicon glyphicon-remove form-control-feedback red' aria-hidden='true'></span>");
            Motion.printmessage("Your name can't have special characters or numbers.", '.main', "", false, "#reviews"); return;
        }
    }else{
        $('#name2').parent().find('.glyphicon').remove();
        $('#name2').parent().append("<span class='glyphicon glyphicon-remove form-control-feedback red' aria-hidden='true'></span>");
        Motion.printmessage("Your name should have atleast 3 charachters.", '.main', "", false, "#reviews"); return;
    }

    b = $('#email2').val();
    var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if(!filter.test(b)){
        $('#email2').parent().find('.glyphicon').remove();
        $('#email2').parent().append("<span class='glyphicon glyphicon-remove form-control-feedback red' aria-hidden='true'></span>");
        Motion.printmessage("Your email soes not match a valid email string.", '.main', "", false, "#reviews"); return;
    }else{
        email = true;
        $('#email2').parent().find('.glyphicon').remove();
        $('#email2').parent().append("<span class='glyphicon glyphicon-ok form-control-feedback green' aria-hidden='true'></span>");
    }

    c = $('#subject2').val();
    if(c.length > 3){
    	subject = true;
    	$('#subject2').parent().find('.glyphicon').remove();
        $('#subject2').parent().append("<span class='glyphicon glyphicon-ok form-control-feedback green' aria-hidden='true'></span>");
    }else{
        $('#subject2').parent().find('.glyphicon').remove();
        $('#subject2').parent().append("<span class='glyphicon glyphicon-remove form-control-feedback red' aria-hidden='true'></span>");
        Motion.printmessage("Subject should be atleast 4 characters long.", '.main', "", false, "#reviews"); return;
    }

    d = $('#message2').val();
    if(d.length > 10){
    	mail = true;
    	$('#message2').parent().find('.glyphicon').remove();
        $('#message2').parent().append("<span class='glyphicon glyphicon-ok form-control-feedback green' aria-hidden='true'></span>");
    }else{
        $('#message2').parent().find('.glyphicon').remove();
        $('#message2').parent().append("<span class='glyphicon glyphicon-remove form-control-feedback red' aria-hidden='true'></span>");
        Motion.printmessage("Content should be atleast 11 characters long.", '.main', "", false, "#reviews"); return;
    }

    if(name && email && subject && mail){
    	$('#submit-active').attr('disabled', 'disabled');
    	$.ajax({
    		url: '/php/response.php',
    		type: "POST",
    		data: {'name': a, 'email': b, 'subject': c, 'mail': d, "t": "1"},
    		success: function(data){
    			$('#submit-active').removeAttr('disabled');
    			if(data.documentElement.getElementsByTagName('error').length > 0){
                    content = data.documentElement.getElementsByTagName('error')[0].getAttribute('content');
                    Motion.printmessage(content, '.main');
    			}else if(data.documentElement.getElementsByTagName('success').length > 0){
                    $('#footer-form').find('.glyphicon').remove();
                    Motion.printmessage("Your response has been sent.", ".main", "success");
    			}
    		}
    	});
    }
}

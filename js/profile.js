(function(){
	$(function () {
      $('[data-toggle="tooltip"]').tooltip();
    })
	if($(document).width()<'768'){
		$('#edit').addClass('btn-block');
	}else{
		$('#edit').removeClass('btn-block');
	}
	$('#logout').click(function(){
		setTimeout(function(){
			window.location = '/php/error.php';
		},200);
	});
	$('#bug-active').click(function(){
		var email = Motion.testEmail('#bugmail', '#bug-container .modal-body');
		if(email){
			var sub = Motion.testLength("#bug", "subject", "#bug-container .modal-body", 3);
			if(sub){
				var content = Motion.testLength("#bugbody", "content", "#bug-container .modal-body", 11);
			}
		}
		to = $('#bugmail').val();
		sub = $('#bug').val();
		b = $('#bugbody').val();
		if( content ){
			$.ajax({
				url: '/php/bugsubmit.php?to='+to+'&sub='+sub+'&b='+b,
				type: 'GET',
				success: function(data){
					$('#bugmail').parent().find('.glyphicon').remove();
					$('#bug-container').find('.alert').remove();
					if(data.documentElement.getElementsByTagName('success').length > 0){
						Motion.printmessage(" We have submitted your request and will try to resolve it as soon as possible.", '#bug-container .modal-header', "success");
						$('#bugmail').val('');
						$('#bug').val('');
						$('#bugbody').val('');
					}else{
						Motion.printmessage("Please check your Email Id or try after some time.", '#bug-container .modal-header');
					}
				}
			});
		}
	});
	if($('.image.full .image-inner').css('background-image') == 'url()' || $('.image.full .image-inner').css('background-image') == 'none'){
		$('.image.full .image-inner')
		.css('border-radius', '100%');
		$('.image.full')
		.css('background-color', '#2DADA8')
		.css('padding', '20px');
	}else{
		$('.image.full .image-inner')
		.css('border-radius', '5px');
		$('.image.full')
		.css('padding', '3px')
		.css('background-color', '#fff');
	}
	$('.container.main').css('min-height', $(window).height());
	$('#editfinal').click(function(){
		$('#editfinal_shadow').click();
	});
	$('#image-file').on('change', function(){
		if($(this).val()){
			$('#image-form').submit();
		}
	});
	$('#image-form').on('submit', (function(e){
		e.preventDefault();
		$.ajax({
			url: '/php/imageupload.php',
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
			success: function(data){
				if(data.documentElement.getElementsByTagName('error').length > 0){
					Motion.printmessage(data.documentElement.getElementsByTagName('error')[0].getAttribute('content'), '.main .col-sm-7');
				}else if(data.documentElement.getElementsByTagName('success').length > 0){
					Motion.printmessage('Profile picture changed successfully', '.main .col-sm-7', 'success');
					$('.image-inner').css('background-image', "url("+data.documentElement.getElementsByTagName('success')[0].getAttribute('content')+")" ).css('border-radius', '6px');
					$('.image.full').css('padding', '3px').css('background-color', '#fff');
				}
			}
		});
	}));
	$.ajax({
		url: '/php/quora.php?t=timeline',
		success: function(data){
			$('#response').html(data);
		}
	});
	$('.options .full').click(function(){
		if($(this).attr('class').indexOf('active') != -1){
			return;
		}
		$('#response').html('<div class="preloader-wrapper small active"><div class="spinner-layer spinner-blue-only"><div class="circle-clipper left"><div class="circle"></div></div><div class="gap-patch"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div>');
		var target = $(this).attr('data-target');
		var skip = $(this).attr('data-skip');
		$('.options .full').removeClass('active');
		$(this).addClass('active');
		$.ajax({
			url: '/php/quora.php?t='+target,
			success: function(data){
				$('#response').html(data);
			}
		});
		if($(this).attr('data-target') == 'rankings'){
			$.ajax({
				url: '/php/mini.php',
				success: function(data){
					$('.options-new').html(data);
				}
			});
		}else{
			$('.options-new').html('');
		}
	});
	$('.col-sm-7').on('click', '#post', function(){
		var data = $('#posting').val();
		$.ajax({
			url: '/php/quora.php?t=post&d='+data,
			success: function(data){
				$('#posting').val('');
				$('#response1').prepend(data);
			}
		});
	});
	$('.options-new').on('click', '.minor', function(){
		var url = $(this).attr('data-target');
		$('.minor').removeClass('active');
		$(this).addClass('active');
		$.ajax({
			url: '/php/quora.php?t=rankings&'+url,
			success: function(data){
				console.log(data);
				$('#response').html(data);
			}
		});
	});
	$('.col-sm-7').on('change', '#company-data', function(){
		if($(this).val() == 0){
			Motion.printmessage('Select At least one company.', '.main>.col-cm-7');
			return;
		}
		window.location = '/stats.php?t='+$(this).val();
	});
})();

$(window).resize(function(){
	if($(document).width()<'768'){
		$('#edit').addClass('btn-block');
	}else{
		$('#edit').removeClass('btn-block');
	}
	$('.container.main').css('min-height', $(window).height());
});

function update(){
	var name = Motion.testTextRigid("#name", "name", ".main");
	if(name){
		var email = Motion.testEmail("#email", ".main");
		if(email){
			var college = Motion.testText("#college", "college", ".main");
			if(college){
				var city = Motion.testText("#city", "city", ".main");
			}
		}
	}
	if( $('#status').val() ) {
		payload = {"name":$('#name').val(), "email":$('#email').val(), "college":$('#college').val(), "city":$('#city').val(), "status":$('#status').val()};
	}else{
		payload = {"name":$('#name').val(), "email":$('#email').val(), "college":$('#college').val(), "city":$('#city').val()};
	}

	if(city){
		$.ajax({
			url: '/php/update.php',
			type: 'POST',
			data: payload,
			success: function(data){
				if(data.documentElement.getElementsByTagName('error').length > 0){
					Motion.printmessage(data.documentElement.getElementsByTagName('error')[0].getAttribute('content'), ".main .col-sm-7");
				}else{
					window.location = "/profile.php";
				}
			}
		});
	}
}

function reset(){
	var pass = Motion.testLength('#pass-o', 'password', '#pass-mod .modal-body', 4);
	if(pass){
		var passNew = Motion.testLength('#pass-n', 'new password', '#pass-mod .modal-body', 4);
		if(passNew){
			var passNewR = Motion.testLength('#pass-nr', 're entered new password', '#pass-mod .modal-body', 4);
		}
	}
	if(passNewR){
		if($('#pass-n').val() != $('#pass-nr').val()){
			Motion.printmessage('New Password does not match re entered password.', '#pass-mod .modal-body');
			return;
		}
		$.ajax({
			url: '/php/reset.php',
			data: {'passo': $('#pass-o').val(), 'passn': $('#pass-n').val(), 'passnr': $('#pass-nr').val()},
			type: "POST",
            success: function(data){
            	if(data.documentElement.getElementsByTagName('error').length > 0){
            		Motion.printmessage(data.documentElement.getElementsByTagName('error')[0].getAttribute('content'), '#pass-mod .modal-body');
            	}else if(data.documentElement.getElementsByTagName('success').length > 0){
            		Motion.printmessage('Password change successful.', '#pass-mod .modal-body', 'success');
            		$('#pass-mod .modal-body input').val('');
            	}
            }
		});
	}
}
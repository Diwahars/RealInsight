$(document).ready(function(e){
    $('.collapsible').collapsible({
      accordion : false
    });
    $('.collection-item').click(function(){
    	if($(this).attr('class').indexOf('active') != -1)
    		return;
    	var target = $(this).html();
    	$('.collection-item').removeClass('active');
    	$(this).addClass('active');
    	$.ajax({
    		url: '/php/proxy.php',
    		data: {"q": target, "i": $('.main').attr('id')},
    		type: "POST",
    		success: function(data){
    			$('.data-carrier').html(data);
    		},
    		complete: function(){
		    	if(target == 'Photos'){
                    $('.image-holder-inner').each(function(){
                        $(this).css('max-height', $(this).width());
                    });
		    	}	
    		}
    	});
        if(target == 'Photos'){
            setTimeout(function(){
                $('.image-holder-inner').each(function(){
                    $(this).css('max-height', $(this).width());
                });
            },500);
        }
    });
    $('#logout').click(function(){
    	setTimeout(function(){
    		window.location = '/php/error.php';
    	},300);
    });
    $('.container.main').css('min-height', $(window).height() - '100' + 'px');
    $('.data-carrier').on('submit', '#image-cover', (function(e){
        e.preventDefault();
        $.ajax({
            url: "/php/upload.php",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            success: function(data){
                if(data.documentElement.getElementsByTagName('error').length > 0){
                    Motion.printmessage(data.documentElement.getElementsByTagName('error')[0].getAttribute('content'), '#image-cover');
                }else if(data.documentElement.getElementsByTagName('success').length > 0){
                    Motion.printmessage('Image upload successful.', '#image-cover', 'success');
                    $('#cover-data').val('');
                    $('.card-image').css('background-image', 'url('+data.documentElement.getElementsByTagName('success')[0].getAttribute('content')+')');
                    $.ajax({
                        url: '/php/proxy.php',
                        data: {"q": 'Photos', "i": $('.main').attr('id')},
                        type: "POST",
                        success: function(data){
                            $('.data-carrier').html(data);
                        },
                        complete: function(){
                            $('.image-holder-inner').each(function(){
                                $(this).css('max-height', $(this).width());
                            });
                        }
                    });
                    setTimeout(function(){
                        $('.image-holder-inner').each(function(){
                            $(this).css('max-height', $(this).width());
                        });
                    },500);
                }
            }
        });
    }));
    $('.data-carrier').on('submit', '#image-normal', (function(e){
        e.preventDefault();
        $.ajax({
            url: "/php/upload.php",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            success: function(data){
                if(data.documentElement.getElementsByTagName('error').length > 0){
                    Motion.printmessage(data.documentElement.getElementsByTagName('error')[0].getAttribute('content'), '#image-normal');
                }else if(data.documentElement.getElementsByTagName('success').length > 0){
                    Motion.printmessage('Image upload successful.', '#image-normal', 'success');
                    $('#normal-data').val('');
                    $.ajax({
                        url: '/php/proxy.php',
                        data: {"q": 'Photos', "i": $('.main').attr('id')},
                        type: "POST",
                        success: function(data){
                            $('.data-carrier').html(data);
                        },
                        complete: function(){
                            $('.image-holder-inner').each(function(){
                                $(this).css('max-height', $(this).width());
                            });
                        }
                    });
                    setTimeout(function(){
                        $('.image-holder-inner').each(function(){
                            $(this).css('max-height', $(this).width());
                        });
                    },500);
                }
            }
        });
    }));
});

$(window).resize(function(){
    $('.image-holder-inner').each(function(){
        $(this).css('max-height', $(this).width());
    });
    $('.container.main').css('min-height', $(window).height() - '100' + 'px');
});


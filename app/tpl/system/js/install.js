/**
 * RevolutionCMS Installation 
 */
 
/**
 * fieldsets
 */
var current_fs, next_fs, previous_fs;
var left, opacity, scale;
var animating; 

/**
 * Requirements
 */
$(".reg_next").click(function(){
	if(animating) return false;
	animating = true;
	
	current_fs = $(this).parent();
	next_fs = $(this).parent().next();
	
	//activate next step on progressbar using the index of next_fs
	$("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
	
	//show the next fieldset
	next_fs.show(); 
	//hide the current fieldset with style
	current_fs.animate({opacity: 0}, {
		step: function(now, mx) {
			//as the opacity of current_fs reduces to 0 - stored in "now"
			//1. scale current_fs down to 80%
			scale = 1 - (1 - now) * 0.2;
			//2. bring next_fs from the right(50%)
			left = (now * 50)+"%";
			//3. increase opacity of next_fs to 1 as it moves in
			opacity = 1 - now;
			current_fs.css({
        'transform': 'scale('+scale+')',
        'position': 'absolute'
      });
			next_fs.css({'left': left, 'opacity': opacity});
		}, 
		duration: 800, 
		complete: function(){
			current_fs.hide();
			animating = false;
		}, 
		//this comes from the custom easing plugin
		easing: 'easeInOutBack'
	});
});

$(".previous").click(function(){
	if(animating) return false;
	animating = true;
	
	current_fs = $(this).parent();
	previous_fs = $(this).parent().prev();
	
	//de-activate current step on progressbar
	$("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");
	
	//show the previous fieldset
	previous_fs.show(); 
	//hide the current fieldset with style
	current_fs.animate({opacity: 0}, {
		step: function(now, mx) {
			//as the opacity of current_fs reduces to 0 - stored in "now"
			//1. scale previous_fs from 80% to 100%
			scale = 0.8 + (1 - now) * 0.2;
			//2. take current_fs to the right(50%) - from 0%
			left = ((1-now) * 50)+"%";
			//3. increase opacity of previous_fs to 1 as it moves in
			opacity = 1 - now;
			current_fs.css({'left': left});
			previous_fs.css({'transform': 'scale('+scale+')', 'opacity': opacity});
		}, 
		duration: 800, 
		complete: function(){
			current_fs.hide();
			animating = false;
		}, 
		//this comes from the custom easing plugin
		easing: 'easeInOutBack'
	});
});

/**
 * Database
 */
$(".db_next").click(function(){
	if(animating) return false;
	animating = true;
	
	current_fs = $(this).parent();
	next_fs = $(this).parent().next();
	
	console.log('Step: Database');
	
	var test_hostname = $("input[name=db_hostname]").val();
	var test_username = $("input[name=db_username]").val();
	var test_password = $("input[name=db_password]").val();
	var test_database = $("input[name=db_database]").val();
	$.post("install.php", { action: 'db_test', db_hostname: test_hostname, db_username: test_username, db_password: test_password, db_database: test_database }, function(data) {
		// log response before parsing it for debugging
		console.log(data);
		
		data = $.parseJSON( data );
		if(data.success) {
			$(".db_next").removeClass('disabled');
			// continue with moving fieldsets 
			$("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
				
				//show the next fieldset
				next_fs.show(); 
				//hide the current fieldset with style
				current_fs.animate({opacity: 0}, {
					step: function(now, mx) {
						//as the opacity of current_fs reduces to 0 - stored in "now"
						//1. scale current_fs down to 80%
						scale = 1 - (1 - now) * 0.2;
						//2. bring next_fs from the right(50%)
						left = (now * 50)+"%";
						//3. increase opacity of next_fs to 1 as it moves in
						opacity = 1 - now;
						current_fs.css({
					'transform': 'scale('+scale+')',
					'position': 'absolute'
				  });
						next_fs.css({'left': left, 'opacity': opacity});
					}, 
					duration: 800, 
					complete: function(){
						current_fs.hide();
						animating = false;
					}, 
					//this comes from the custom easing plugin
					easing: 'easeInOutBack'
				});
		}
		else {
			console.log('Application Error: ' + JSON.stringify(data));
			$('.db-subtitle').html(data.content);
			animating = false;
		}
	});
});

/**
 * Hotel
 */
$(".hotel_next").click(function(){
	if(animating) return false;
	animating = true;
	
	current_fs = $(this).parent();
	next_fs = $(this).parent().next();
	
	var can_continue = false;
	
	console.log('Step: Hotel');
	
	var test_url = $("input[name=hotel_url]").val();
	var test_name = $("input[name=hotel_name]").val();
	var test_desc = $("input[name=hotel_desc]").val();
	var test_theme = $("input[name=hotel_theme]").val();
	$.post("install.php", { action: 'hotel_settings', hotel_url: test_url, hotel_name: test_name, hotel_desc: test_desc, hotel_theme: test_theme }, function(data) {
		// log response before parsing it for debugging
		console.log(data);
		
		data = $.parseJSON( data );
		if(data.success) {
			$(".db_next").removeClass('disabled');
			// continue with moving fieldsets 
			$("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
				
				//show the next fieldset
				next_fs.show(); 
				//hide the current fieldset with style
				current_fs.animate({opacity: 0}, {
					step: function(now, mx) {
						//as the opacity of current_fs reduces to 0 - stored in "now"
						//1. scale current_fs down to 80%
						scale = 1 - (1 - now) * 0.2;
						//2. bring next_fs from the right(50%)
						left = (now * 50)+"%";
						//3. increase opacity of next_fs to 1 as it moves in
						opacity = 1 - now;
						current_fs.css({
					'transform': 'scale('+scale+')',
					'position': 'absolute'
				  });
						next_fs.css({'left': left, 'opacity': opacity});
					}, 
					duration: 800, 
					complete: function(){
						current_fs.hide();
						animating = false;
					}, 
					//this comes from the custom easing plugin
					easing: 'easeInOutBack'
				});
		}
		else {
			$('.hotel-subtitle').html(data.content);
		}
	});
});

$(".submit").click(function(){
	console.log('Account Next Clicked');

	var acc_email		= $("input[name=acc_email]").val();
	var acc_username 	= $("input[name=acc_username]").val();
	var acc_password	= $("input[name=acc_password]").val();
	var acc_rpassword	= $("input[name=acc_rep_password]").val();
	
	$.post("install.php", { action: 'new_character', acc_email: acc_email, acc_username: acc_username, acc_password: acc_password, acc_rep_password: acc_rpassword }, function(data) {
		// log response before parsing it for debugging
		console.log(data);
		
		data = $.parseJSON( data );
		if(data.success) {
			window.location.href = '/index';
		}
		else {
			$('.hotel-subtitle').html(data.content);
		}
	});
	
	return false;
})

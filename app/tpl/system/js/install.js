/**
 * RevolutionCMS Installation Script
 */

$(function() {
	var install_current_step, install_next_step, install_previous_step;
	var left, opacity, scale;
	var animating;
	
    console.log("RevolutionCMS Installation Processes");
	
	/**
	 * Do Requirement Check
	 */
	$.post('do.php', { action: 'installer_requirements' }, function (data) {
		data = $.parseJSON(data);
		
		if(data.success == true)
		{
			console.log("Checking System Requirements...  PASSED");
			$('.requirement-subtitle').html(data.content);
			$('.requirement_next').removeClass('disabled');
			$('.requirement_next').prop("disabled", false);
		}
		else {
			console.log("Checking System Requirements...  FAILED");
			if(Array.isArray(data.content))
			{
				$.each(data.content, function (id, error) {
					console.log("Installation Error: " + error);
					$('.requirements-response').append('<div class="alert">' + error + '</div>');
				});
			}
			else {
				$('.requirements-response').html(data.content);
			}
		}
	});
	
	/**
	 * Requirements
	 */
	$('.requirement_next').click(function () {
		if(animating) return false;
		animating = true;
		
		install_current_step = $(this).parent();
		install_next_step = $(this).parent().next();
		
		// activate next step on progressbar using index of install_next_step
		$('#progressbar li').eq($('fieldset').index(install_next_step)).addClass('active');
		
		install_next_step.show();
		install_current_step.animate({opacity: 0}, {
			step: function(now, mx) {
				scale = 1 - (1 - now) * 0.2;
				left  = (now * 50)+"%";
				opacity = 1 - now;
				install_current_step.css({
					'transform': 'scale(' + scale + ')',
					'position': 'absolute'
				});
				install_next_step.css({'left': left, 'opacity': opacity});
			},
			duration: 800,
			complete: function() {
				install_current_step.hide();
				animating = false;
			},
			easing: 'easeInOutBack'
		});
	});
	
	/**
	 * Database
	 */
	$('.db_next').click(function () {
		if(animating) return false;
		animating = true;
		
		install_current_step = $(this).parent();
		install_next_step = $(this).parent().next();
		
		var db_hostname = $("input[name=db_hostname]").val();
		var db_username = $("input[name=db_username]").val();
		var db_password = $("input[name=db_password]").val();
		var db_database = $("input[name=db_database]").val();
		$.post('do.php', { action: 'installer_database', hostname: db_hostname, username: db_username, password: db_password, database: db_database }, function (data) {
			data = $.parseJSON(data);
		
			if(data.success == true)
			{
				console.log("Testing Database and Creating Config File... PASSED");
				$('.db-subtitle').html(data.content);
				
				// activate next step on progressbar using index of install_next_step
				$('#progressbar li').eq($('fieldset').index(install_next_step)).addClass('active');
				
				install_next_step.show();
				install_current_step.animate({opacity: 0}, {
					step: function(now, mx) {
						scale = 1 - (1 - now) * 0.2;
						left  = (now * 50)+"%";
						opacity = 1 - now;
						install_current_step.css({
							'transform': 'scale(' + scale + ')',
							'position': 'absolute'
						});
						install_next_step.css({'left': left, 'opacity': opacity});
					},
					duration: 800,
					complete: function() {
						install_current_step.hide();
						animating = false;
					},
					easing: 'easeInOutBack'
				});
			}
			else {
				console.log("Testing Database and Creating Config File... FAILED");
				$('.db-subtitle').html(data.content);
				animating = false;
			}
		});
	});
	
	/**
	 * Hotel
	 */
	$('.hotel_next').click(function () {
		if(animating) return false;
		animating = true;
		
		install_current_step = $(this).parent();
		install_next_step = $(this).parent().next();
		
		var h_url = $("input[name=url]").val();
		var h_name = $("input[name=name]").val();
		var h_desc = $("input[name=desc]").val();
		var h_theme = $("input[name=theme]").val();
		$.post('do.php', { action: 'installer_hotel', url: h_url, name: h_name, desc: h_desc, theme: h_theme }, function (data) {
			data = $.parseJSON(data);
		
			if(data.success == true)
			{
				console.log("Updating Hotel Configuration... PASSED");
				$('.hotel-subtitle').html(data.content);
				
				// activate next step on progressbar using index of install_next_step
				$('#progressbar li').eq($('fieldset').index(install_next_step)).addClass('active');
				
				install_next_step.show();
				install_current_step.animate({opacity: 0}, {
					step: function(now, mx) {
						scale = 1 - (1 - now) * 0.2;
						left  = (now * 50)+"%";
						opacity = 1 - now;
						install_current_step.css({
							'transform': 'scale(' + scale + ')',
							'position': 'absolute'
						});
						install_next_step.css({'left': left, 'opacity': opacity});
					},
					duration: 800,
					complete: function() {
						install_current_step.hide();
						animating = false;
					},
					easing: 'easeInOutBack'
				});
			}
			else {
				console.log("Updating Hotel Configuration... FAILED");
				$('.hotel-subtitle').html(data.content);
				animating = false;
			}
		});
	});
	
	/**
	 * Account
	 */
	$('.done').click(function () {
		if(animating) return false;
		animating = true;
		
		install_current_step = $(this).parent();
		install_next_step = $(this).parent().next();
		
		var email = $("input[name=reg_email]").val();
		var username = $("input[name=reg_username]").val();
		var password = $("input[name=reg_password]").val();
		var repassword = $("input[name=reg_rep_password]").val();
		$.post('do.php', { action: 'account_add', register: true, reg_email: email, reg_username: username, reg_password: password, reg_rep_password: repassword, rank: 7 }, function (data) {
			data = $.parseJSON(data);
		
			if(data.success == true)
			{
				console.log("Added Administrator Account");
				
				$.post('do.php', { action: 'settings_get', key: 'hotel_url' }, function (data)
					{
						data = $.parseJSON(data);
						
						if(data.success)
						{
							window.location.href = data.content + '/me';
						}
						else {
							console.log('RevolutionCMS couldn\'t finish the installation');
							return false;
						}
					});
			}
			else {
				console.log("Adding Administrator Account Failed, Reason: " + data.content);
				$('.fs-subtitle').html(data.content);
				animating = false;
			}
		});
		
		return false;
	});
	
	$(".previous").click(function(){
		if(animating) return false;
		animating = true;
		
		install_current_step  = $(this).parent();
		install_previous_step = $(this).parent().prev();
		
		$("#progressbar li").eq($("fieldset").index(install_current_step)).removeClass("active");
		
		install_previous_step.show();
		install_current_step.animate({opacity: 0}, {
			step: function(now, mx) {
				scale = 0.8 + (1 - now) * 0.2;
				left = ((1-now) * 50)+"%";
				opacity = 1 - now;
				install_current_step.css({'left': left});
				install_previous_step.css({'transform': 'scale('+scale+')', 'opacity': opacity});
			}, 
			duration: 800, 
			complete: function(){
				install_current_step.hide();
				animating = false;
			},
			easing: 'easeInOutBack'
		});
	});
});

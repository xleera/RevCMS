$(document).ready(function () {
	setTimeout(function () {
		$.post('/api', { action: 'online' }, function (data) {
			data = $.parseJSON(data);
			
			if(data.success) {
				$('.online-count').html(data.content);
			}
			else {
				$('.online-count').html(0);
			}
		});
	}, 10000);
});

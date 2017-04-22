(function($) {
    $.QueryString = (function(a) {
        if (a == "") return {};
        var b = {};
        for (var i = 0; i < a.length; ++i)
        {
            var p=a[i].split('=', 2);
            if (p.length != 2) continue;
            b[p[0]] = decodeURIComponent(p[1].replace(/\+/g, " "));
        }
        return b;
    })(window.location.search.substr(1).split('&'));
	
	var action = $.QueryString.action;
	switch(action)
	{
		case 'dashboard':
		default:
			$("#page-wrapper").load("/app/tpl/system/partial/dashboard.html");
			
			$.post("/api", {action: 'ase_dashboard'}, function (data) {
				data = $.parseJSON(data);
				
				$(".revcms-uptime").html(data.content.uptime);
				$(".revcms-online").html(data.content.online);
				$(".revcms-registered").html(data.content.registered);
			});
			break;
		case 'account':
			var task = $.QueryString.task;
			console.log("Task: " + task);
			switch(task)
			{
				case 'edit':
					$("#page-wrapper").load("/app/tpl/system/partial/account_edit.html");
					
					var acc_id = $.QueryString.id;
					$.post('/api', {action: 'ase_account_view', id: acc_id}, function (data) {
						data = $.parseJSON(data);
						
						$(".account-username").html(data.content.username);
						$(".account-look").html("<img src=\"http://www.habbo.nl/habbo-imaging/avatarimage?figure=" + data.content.look + "&direction=2&head_direction=3&gesture=sml&size=m\" />");
						var content = "";
						$.each(data.content, function(key, value) {
							content += "<div class=\"form-group\"><label>" + key + "</label><input class=\"form-control\" placeholder=\"" + value + "\"></div>";
						});
						
						content += "<button type=\"submit\" class=\"btn btn-default pull-right\">Update</button>";
						
						$(".account-data").html(content);
					});
					
					break;
				case 'list':
				default:
					$("#page-wrapper").load("/app/tpl/system/partial/account_list.html");
				
					$.post('/api', {action: 'ase_account_list'}, function (data) {
						data = $.parseJSON(data);
						
						var content;
						$.each(data.content, function(iter, user) {
							content += "<tr><td><a href=\"ase.php?action=account&task=edit&id=" + user.id + "\">" + user.id + "</a></td><td>" + user.username  + "</td><td>" + user.mail + "</td><td>" + user.rank + "</td><td>" + user.account_created + "</td><td>" + user.last_online + "</td></tr>";
						});
						
						$(".account-data").html(content);
					});
					break;
			}
			break;
	}
})(jQuery);
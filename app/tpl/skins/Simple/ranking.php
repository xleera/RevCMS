<?php
/**
 * RevolutionCMS
 *
 * @author	Kryptos
 * @author	GarettM
 * @version	0.0.1
 */

global $template, $core, $engine, $users;
?>
<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8"/>
		<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1"/>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<base href="{url}" />

		<title>{hotelName} - Ranking</title>
		<link rel="stylesheet" type="text/css" href="{url}/app/tpl/skins/Simple/css/main.css?rand={rand}" />
		<meta name="description" content="{hotelDesc}"/>
	</head>
	<body>
		<nav>
			<ul>
				<li onclick="location.href='{url}/me'">Home</li>
				<li onclick="location.href='{url}/profile'">{username}</li>
                <li onclick="location.href='{url}/ranking'"><strong>Ranking</strong></li>
				<li onclick="location.href='{url}/team'">Team</li>
                <li onclick="location.href='{url}/news'">News</li>
				<li onclick="window.open('{url}/client')">Enter</li>
				<li onclick="location.href='{url}/logout'">Sign Out</li>
			</ul>
        </nav>
        
        <header>
            <table width="100%">
                <tr>
                    <td width="25%" style="vertical-align: bottom;"><img src="{url}/app/tpl/skins/Simple/img/logo.png"/></td>
					<td width="50%" rowspan="2">
						<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
						<!-- responsive2 -->
						<ins class="adsbygoogle"
							 style="display:block"
							 data-ad-client="ca-pub-9760911072415608"
							 data-ad-slot="1350769466"
							 data-ad-format="auto"></ins>
						<script>
						(adsbygoogle = window.adsbygoogle || []).push({});
						</script>		
					</td>
					<td width="25%" style="vertical-align: bottom; text-align: right"><a href="{url}/client" target="_blank" class="btn green">Enter {hotelname} Hotel</a></td>
				</tr>
                <tr>
                    <td style="vertical-align: top; text-shadow: 0 0 3px #000;">{hoteldesc}</td>
                    <td style="vertical-align: top; text-align: right"><span class="online online_users"><span class="online-count">{online}</span> online</span></td>
                </tr>
            </table>
        </header>
        
        <main>
            <div class="col col-3 bg">
                <span class="hl"><span>User</span> <span style="float: right;">Credits</span></span>
                <table border="0" class="inner" cellpadding="3" cellspacing="0" width="100%">
					<?php
						$users = $engine->query("SELECT id, username, look, credits FROM users WHERE `rank` < '5' ORDER BY `credits` DESC LIMIT 10");
						foreach($users as $user):
					?>	
					<tr>
						<td style="height: 60px; width: 30%; background: url('http://www.habbo.nl/habbo-imaging/avatarimage?figure=<?php echo $user['look']; ?>&direction=2&head_direction=2&size=m&headonly=1') center no-repeat;"></td>
						<td width="60%"><a href="index.php?url=profile&id=<?php echo $user['id'];?>"><?php echo $user['username']; ?></a></td>
						<td align="right" style="color: #E9B024;"><?php echo $user['credits']; ?></td>
					</tr>
					<?php endforeach; ?>
				</table>
			</div>
			
			<div class="col col-3 bg">
                <span class="hl">
                    <span>User</span>
                    <span style="float: right;">Pixels</span>
                </span>
                <table border="0" class="inner" cellpadding="3" cellspacing="0" width="100%">
					<?php
						$users = $engine->query("SELECT id, username, look, activity_points FROM users WHERE `rank` < '5' ORDER BY `activity_points` DESC LIMIT 10");
						foreach($users as $user):
					?>
					<tr>
						<td style="height: 60px; width: 30%; background: url('http://www.habbo.nl/habbo-imaging/avatarimage?figure=<?php echo $user['look']; ?>&direction=2&head_direction=2&size=m&headonly=1') center no-repeat;"></td>
						<td width="60%"><a href="index.php?url=profile&id=<?php echo $user['id'];?>"><?php echo $user['username']; ?></a></td>
						<td align="right" style="color: #E9B024;"><?php echo $user['activity_points']; ?></td>
					</tr>
					<?php endforeach; ?>
				</table>
			</div>
			<div class="col col-1 bg">
				<div class="inner footer">
					<span>Copyright &copy; 2017 <a href="{url}">{hotelname}</a>.</span><br>
					<span>Powered by <a href="https://github.com/GarettMcCarty/RevCMS">RevCMS</a>.</span>
				</div>
			</div>
		</main>
		<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
		<script src="{url}/app/tpl/skins/Simple/js/online.js"></script>
	</body>
</html>
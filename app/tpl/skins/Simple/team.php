<?php
/**
 * RevolutionCMS
 *
 * @author	Kryptos
 * @author	GarettM
 * @version	0.8.1
 */

global $template, $core, $engine, $users;
?>
<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8"/>
		<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1"/>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<base href="{hotel.url}" />

		<title>{hotel.name} - Team</title>
		<link rel="stylesheet" type="text/css" href="{hotel.url}/app/tpl/skins/Simple/css/main.css?rand={rand}" />
		<meta name="description" content="{hotel.desc}"/>
	</head>
	<body>
		<nav>
			<ul>
				<li onclick="location.href='{hotel.url}/me'">Home</li>
				<li onclick="location.href='{hotel.url}/profile'">{account.username}</li>
                <li onclick="location.href='{hotel.url}/ranking'">Ranking</li>
				<li onclick="location.href='{hotel.url}/team'"><strong>Team</strong></li>
                <li onclick="location.href='{hotel.url}/news'">News</li>
				<li onclick="window.open('{hotel.url}/client')">Enter</li>
				<li onclick="location.href='{hotel.url}/logout'">Sign Out</li>
			</ul>
        </nav>
        
        <header>
            <table width="100%">
                <tr>
                    <td width="25%" style="vertical-align: bottom;"><img src="{hotel.url}/app/tpl/skins/Simple/img/logo.png"/></td>
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
					<td width="25%" style="vertical-align: bottom; text-align: right"><a href="{hotel.url}/client" target="_blank" class="btn green">Enter {hotel.name} Hotel</a></td>
				</tr>
                <tr>
                    <td style="vertical-align: top; text-shadow: 0 0 3px #000;">{hotel.desc}</td>
                    <td style="vertical-align: top; text-align: right"><span class="online online_users"><span class="online-count">{hotel.online}</span> online</span></td>
                </tr>
            </table>
        </header>
        
        <main>
		<?php
			$users = $engine->query('SELECT id, username, motto, rank, online, last_online, look FROM users WHERE rank > 3 ORDER BY rank DESC');
			foreach($users as $user):
				$online = sprintf('<span style="display: inline-block; background: url({hotel.url}/app/tpl/skins/Habbo/img/%s.gif) left center no-repeat; width: 40px; height: 16px;"></span>', ($user['online'] == 1) ? 'online' : 'offline');
				
				$rank = $engine->select('cms_ranks', array('rank' => $user['rank']), array('name'))->fetch();
		?>
                    <table class="col col-3 bg" style="padding: 10px 0;">
                        <tr>
                            <td rowspan="4" style="background: url('http://www.habbo.nl/habbo-imaging/avatarimage?figure=<?php echo $user['look']; ?>&action=wav&direction=2&head_direction=3&gesture=sml&size=n') center no-repeat; height: 120px; width: 80px;"></td>
                            <td>Name</td>
                            <td><small><i><?php echo $user['username'] ?></i></small></td>
                        </tr>
                        <tr>
                            <td>Rank</td>
                            <td><small><i><?php echo $rank; ?></i></small></td>
                        </tr>
                        <tr>
                            <td>Motto</td>
                            <td><small><i><?php echo $user['motto']; ?></i></small></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <?php
									$badges = $engine->query("SELECT * FROM user_badges WHERE user_id = '" . $user['id'] . "' AND badge_slot >= 1 ORDER BY badge_slot DESC LIMIT 5");
									if(!$badges || empty($badges))
									{
										echo '<i>No active badges...</i>';
									}
									else {
										foreach($badges as $badge)
											echo sprintf('<span style="display: inline-block; background: url(%s/c_images/badges/%s.gif) center no-repeat; margin 0 14px; width: 50px; height: 40px;"></span>', $core::getSwfPath(), $badge['badge_id']);
									}
								?>
                            </td>
                        </tr>
                        <tr>
                        <th><?php echo $online ?></th>
                            <td>Last online</td>
                            <td><small><i><?php echo date("d/m/Y, H:i", $user['last_online']); ?></i></small></td>
                        </tr>
                    </table>
                <?php endforeach; ?>
			<div class="col col-1 bg">
				<div class="inner footer">
					<span>Copyright &copy; 2017 <a href="{hotel.url}">{hotel.name}</a>.</span><br>
					<span>Powered by <a href="https://github.com/GarettMcCarty/RevCMS">RevCMS</a>.</span>
				</div>
			</div>
		</main>
		<script src="{hotel.url}/app/tpl/skins/Simple/js/jquery-3.2.1.min.js"></script>
		<script src="{hotel.url}/app/tpl/skins/Simple/js/online.js"></script>
	</body>
</html>
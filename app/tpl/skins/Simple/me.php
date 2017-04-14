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

		<title>{hotelName} - Home</title>
		<link rel="stylesheet" type="text/css" href="{url}/app/tpl/skins/Simple/css/main.css?rand={rand}" />
		<meta name="description" content="{hotelDesc}"/>
	</head>
	<body>
		<nav>
			<ul>
				<li onclick="location.href='{url}/me'"><strong>Home</strong></li>
				<li onclick="location.href='{url}/profile'">{username}</li>
                <li onclick="location.href='{url}/ranking'">Ranking</li>
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
			<div class="col col-2-3 bg">
				<table class="inner" height="302px" width="100%" border="0">
					<tr>
						<td rowspan="6" height="220px" width="200px" style="background: url('{url}/app/tpl/skins/Simple/img/white_sofa.png') 45px 105px no-repeat;">
							<span style="display: block; background: url('http://www.habbo.nl/habbo-imaging/avatarimage?figure={figure}&direction=2&head_direction=2&gesture=sml&action=sit,crr=6&size=m') 80px 30px no-repeat; height: 220px;"></span>
						</td>
						<td style="border-bottom: 1px solid #d3d3d3;">
							<span style="background: url('{url}/app/tpl/skins/Simple/img/user.gif') 12px center no-repeat; padding-left: 30px;"><b>Username</b> <span style="float: right;"><i>{username}</i></span></span>
						</td>
					</tr>
					<tr>
						<td style="border-bottom: 1px solid #d3d3d3;">
							<span style="background: url('{url}/app/tpl/skins/Simple/img/motto.png') 10px center no-repeat; padding-left: 30px;"><b>Motto</b> <span style="float: right;"><i>{motto}</i></span></span>
						</td>
					</tr>
					<tr>
						<td style="border-bottom: 1px solid #d3d3d3;">
							<span style="background: url('{url}/app/tpl/skins/Simple/img/credit.gif') 10px center no-repeat; padding-left: 30px;"><b>Credits</b> <span style="float: right;"><i>{coins}</i></span></span>
						</td>
					</tr>
					<tr>
						<td style="border-bottom: 1px solid #d3d3d3;">
							<span style="background: url('{url}/app/tpl/skins/Simple/img/pixel.gif') 10px center no-repeat; padding-left: 30px;"><b>Pixels</b> <span style="float: right;"><i>{pixels}</i></span></span>
						</td>
					</tr>
					<tr>
						<td>
							<?php
								$badges = $engine->query("SELECT * FROM user_badges WHERE user_id = '" . $_SESSION['account']['id'] . "' AND badge_slot >= 1 ORDER BY badge_slot DESC LIMIT 5");
								
								if(empty($badges))
								{
									echo '<i>No active badges</i>';
								}
								else {
									foreach($badges as $badge)
										echo sprintf('<span style="display: inline-block; background: url(%s/c_images/badges/%s.gif) center no-repeat; margin 0 14px; width: 50px; height: 50px;"></span>', $core::getHotelSwfFolder(), $badge['badge_id']);
								}
							?>
						</td>
					</tr>
				</table>
			</div>
		
			<div class="col col-3 bg">
				<span class="hl">News</span>
				<div style="padding: 0 10px;">
					<?php
						$articles = $engine->select('cms_news', array(), array('*'), array('id' => 'DESC'), 3)->fetchAll();
						foreach($articles as $article):
					?>
					<a href="{url}/article/<?php echo $article['id'] ?>" style="text-decoration: none;">
						<div class="me-news">
							<div class="me-news-bg" style="background: url('http://image.hybridhotel.pw/c_images/Top_Story_Images/<?php echo $article['image'] ?>') center no-repeat;">
								<div style="padding: 5px;">
									<small style="text-shadow: 1px 1px #303030;"><?php echo $article['shortstory'] ?></small>
								</div>
								<div class="me-news-bot">
									<small class="me-news-bot-left"><?php echo $article['title'] ?></small>
									<small class="me-news-bot-right"><?php echo date("d/m/Y", $article['date']); ?></small>
								</div>
							</div>
						</div>
					</a>
					<?php endforeach; ?>
				</div>
			</div>
			
			<div class='col col-2 bg'>
				<span class='hl blue'>Friends online</span>
				<div class='inner'>
					<?php
						$friends = $engine->select('messenger_friendships', array('user_one_id' => $_SESSION['account']['id']))->fetchAll();
						
						$online = '';
						foreach($friends as $friend)
						{
							$online = $users->getInfo($friend['user_two_id'], 'online');
							
							if($online == '1' || $online == 1)
							{
								$online .= sprintf('%s, ', $users->getInfo($friend['user_two_id'], 'username'));
							}
						}
						
						echo ltrim($online, ', ');
					?>
				</div>
			</div>
			
			<div class="col col-2 bg">
				<span class="hl blue">Recent registered users</span>
				<div class="inner">
					<?php
						$new_accounts = $engine->select('users', array(), array('id', 'username', 'look'), array('id' => 'DESC'), 20)->fetchAll();
						foreach($new_accounts as $account)
							sprintf('<a href="%s/profile/%d" class="tooltip"><img src="http://www.habbo.nl/habbo-imaging/avatarimage?figure=%s&size=s"><span>%s</span></a>', $core::getHotelUrl(), $account['id'], $account['look'], $account['username']);
					?>
				</div>
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
<?php
/**
 * RevolutionCMS
 *
 * @author	Kryptos
 * @author	GarettM
 * @version	0.0.1
 */

global $template, $core, $engine, $users;

$input = array_merge($_GET, $_POST);
$input = array_map('Revolution\app\system\core::secure', $input);

$account = isset($input['user']) ? $input['user'] : $_SESSION['account']['id'];

if(!is_numeric($account))
	$account = $users->getId($account);

$username = $users->getInfo($account, 'username');
?>
<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8"/>
		<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1"/>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<base href="{url}" />

		<title>{hotelName} - <?php echo $username; ?></title>
		<link rel="stylesheet" type="text/css" href="{url}/app/tpl/skins/Simple/css/main.css?rand={rand}" />
		<meta name="description" content="{hotelDesc}"/>
	</head>
	<body>
		<nav>
			<ul>
				<li onclick="location.href='{url}/me'">Home</li>
				<li onclick="location.href='{url}/profile/<?php echo $account; ?>'"><?php echo ($account == $_SESSION['account']['id']) ? '<strong>' . $username . '</strong>' : $username; ?></li>
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
			<div class="col col-2 bg">
				<span class="hl blue"><?php echo $username; ?>'s Badges</span>
				<div class="inner">
				<?php
					$badges = $engine->query("SELECT * FROM user_badges WHERE user_id = '" . $account . "' AND badge_slot >= 1 ORDER BY badge_slot DESC LIMIT 5");
					
					if(empty($badges))
					{
						echo '<i>No active badges</i>';
					}
					else {
						foreach($badges as $badge)
							echo sprintf('<span style="display: inline-block; background: url(%s/c_images/badges/%s.gif) center no-repeat; margin 0 14px; width: 50px; height: 50px;"></span>', $core::getHotelSwfFolder(), $badge['badge_id']);
					}
				?>
				</div>
			</div>
			
			<div class="col col-2 bg" style="background: #fff url('{url}/app/tpl/skins/Simple/img/bg_right.png') right bottom no-repeat; border-bottom: 3px solid #06050C;">
				<span class="hl blue"><?php echo $username; ?>'s profile</span>
				<div class="inner">
					<table width="100%">
						<tr>
							<td width="30%"><b>Mission</b></td>
							<td width="50%" style="text-align: right; color: #fff; font-style: italic;"><?php echo $users->getInfo($account, 'motto'); ?></td>
						</tr>
						<tr>
							<td><b>Credits</b></td>
							<td style="text-align: right; color: #fff; font-style: italic;"><?php echo $users->getInfo($account, 'credits'); ?></td>
							<td rowspan="6"><img style="padding-left: 20px;" src="http://www.habbo.nl/habbo-imaging/avatarimage?figure=<?php echo $users->getInfo($account, 'look'); ?>&direction=3&head_direction=3" alt="<?php echo $username; ?>" /></td>
						</tr>
						<tr>
							<td><b>Pixels</b></td>
							<td style="text-align: right; color: #fff; font-style: italic;"><?php echo $users->getInfo($account, 'activity_points'); ?></td>
						</tr>
						<tr>
							<td><b>Respects received</b></td>
							<td style="text-align: right; color: #fff; font-style: italic;">cooming soon</td>
						</tr>
						<tr>
							<td><b>Gifts received</b></td>
							<td style="text-align: right; color: #fff; font-style: italic;">cooming soon</td>
						</tr>
						<tr>
							<td><b>Registered</b></td>
							<td style="text-align: right; color: #fff; font-style: italic;"><?php date('d/m/Y, H:i', $users->getInfo($account, 'account_created')); ?></td>
						</tr>
						<tr>
							<td><b>Last login</b></td>
							<td style="text-align: right; color: #fff; font-style: italic;"><?php date('d/m/Y, H:i', $users->getInfo($account, 'last_online')); ?></td>
							<td>??</td>
						</tr>
					</table>
				</div>
			</div>
				
			<div class="col col-2 bg" style="float: right;">
				<span class="hl blue"><?php echo $username; ?>'s friends</span>
				<div class="inner">
				<?php
					$friends = $engine->query("SELECT id, username, look FROM users WHERE `id` IN (SELECT `user_one_id` FROM `messenger_friendships` WHERE `user_two_id`='{$account}') ORDER BY id DESC");
					foreach($friends as $friend)
						echo sprintf('<a href="%s/profile/%d"><img src="http://www.habbo.nl/habbo-imaging/avatarimage?figure=%s&size=s" /></a>', $core::getHotelUrl(), $friend['id'], $friend['look']);
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
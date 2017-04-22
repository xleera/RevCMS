<?php
/**
 * RevolutionCMS
 *
 * @author	Kryptos
 * @author	GarettM
 * @version	0.8.1
 * @TODO
 *	Move logic to \Revolution\App\System\Template
 */

global $template, $core, $engine, $users;

$input = array_merge($_GET, $_POST);
$input = array_map('Revolution\app\system\core::secure', $input);

$account = isset($input['user']) ? $input['user'] : $_SESSION['account']['id'];

if(!is_numeric($account))
	$account = $users->getId($account);

if(!$account)
	$account = $_SESSION['account']['id'];

?>
<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8"/>
		<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1"/>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<base href="{hotel.url}" />

		<title>{hotel.name} - {profile.username}</title>
		<link rel="stylesheet" type="text/css" href="{hotel.url}/app/tpl/skins/Simple/css/main.css" />
		<meta name="description" content="{hotel.desc}"/>
	</head>
	<body>
		<nav>
			<ul>
				<li onclick="location.href='{hotel.url}/me'">Home</li>
				<li onclick="location.href='{hotel.url}/profile/{profile.id}'"><?php echo ($account == $_SESSION['account']['id']) ? '<strong>{profile.username}</strong>' : '{profile.username}'; ?></li>
                <li onclick="location.href='{hotel.url}/ranking'">Ranking</li>
				<li onclick="location.href='{hotel.url}/team'">Team</li>
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
			<div class="col col-2 bg">
				<span class="hl blue">{profile.username}'s Badges</span>
				<div class="inner">{profile.badges}</div>
			</div>
			
			<div class="col col-2 bg" style="background: #fff url('{hotel.url}/app/tpl/skins/Simple/img/bg_right.png') right bottom no-repeat; border-bottom: 3px solid #06050C;">
				<span class="hl blue">{profile.username}'s profile</span>
				<div class="inner">
					<table width="100%">
						<tr>
							<td width="30%"><b>Mission</b></td>
							<td width="50%" style="text-align: right; color: #fff; font-style: italic;">{profile.motto}</td>
						</tr>
						<tr>
							<td><b>Credits</b></td>
							<td style="text-align: right; color: #fff; font-style: italic;">{profile.credits}</td>
							<td rowspan="6"><img style="padding-left: 20px;" src="http://www.habbo.nl/habbo-imaging/avatarimage?figure={profile.look}&direction=3&head_direction=3" alt="{username}" /></td>
						</tr>
						<tr>
							<td><b>Pixels</b></td>
							<td style="text-align: right; color: #fff; font-style: italic;">{profile.activity_points}</td>
						</tr>
						<tr>
							<td><b>Respects received</b></td>
							<td style="text-align: right; color: #fff; font-style: italic;">coming soon</td>
						</tr>
						<tr>
							<td><b>Gifts received</b></td>
							<td style="text-align: right; color: #fff; font-style: italic;">coming soon</td>
						</tr>
						<tr>
							<td><b>Registered</b></td>
							<td style="text-align: right; color: #fff; font-style: italic;">{profile.account_created}</td>
						</tr>
						<tr>
							<td><b>Last login</b></td>
							<td style="text-align: right; color: #fff; font-style: italic;">{profile.last_online}</td>
							<td>??</td>
						</tr>
					</table>
				</div>
			</div>
				
			<div class="col col-2 bg" style="float: right;">
				<span class="hl blue">{profile.username}'s friends</span>
				<div class="inner">{profile.friends}</div>
			</div>
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
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
            <div class="col col-2">
                <span class="hl blue">Account settings</span>
                <form action="" method="post">
					<table border="0" width="100%" style="margin: 10px;">
						<?php
							if($template->form->isError())
								echo sprintf('<div id="message">%s</div>', $template->form->getError());
						?>
						<tr>
							<td width="50%"><strong>E-mail</strong></td>
							<td><input id="email" name="acc_email" class="textfield" type="text" value="{email}" /></td>
						</tr>
						<tr>
							<td width="45%"><strong>Mission</strong></td>
							<td><label for="motto"></label>
								<input id="motto" name="acc_motto" class="textfield" type="text" value="{motto}" />
							</td>
						</tr>
						<tr>
							<td width="50%"><strong>Current password</strong></td>
							<td><input id="password" name="acc_old_password" class="textfield" type="password" /></td>
						</tr>
						<tr>
							<td width="50%"><strong>New password</strong></td>
							<td><input id="confirm_password" name="acc_new_password" class="textfield" type="password" /></td>
						</tr>
						<tr>
							<td width="50%">&nbsp;</td>
							<td><input id="button" name="account" type="submit" value="Update informations" /></td>
						</tr>
					</table>
				</form>
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
<?php
/**
 * RevolutionCMS
 *
 * @author	Kryptos
 * @author	GarettM
 * @version	0.8.1
 */

global $template, $engine;
?>
<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8"/>
		<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1"/>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<base href="{hotel.url}"/>

		<title>{hotel.name} - Welcome</title>
		<link rel="stylesheet" type="text/css" href="{hotel.url}/app/tpl/skins/Simple/css/index.css?rand={rand}" />
		<meta name="description" content="{hotel.desc}"/>
	</head>
	<body>
		<?php
			/**
			 * TODO:
			 *	create regex markup {if(error.message)} <div class="msg">{error.message}</div> {endif}
			 */
			if($template->form->isError())
				echo sprintf('<div class="msg">%s</div>', $template->form->getError()); 
		?>
		<main>
			<div class="left">
				<div class="login-box">
					<table class="headline">
						<tr>
							<td align="left" width="50%"><span class="name"><a href="{hotel.url}">{hotel.name} Hotel</a></span></td>
							<td align="right" width="50%"><span class="online online_users"><span class="online-count">0</span> online</span></td>
						</tr>
					</table>
					<form action="index.php?url=index" method="post">
						<input id="username" name="log_username" class="textfield" type="text" placeholder="Username" />
						<input id="password" name="log_password" class="textfield" type="password" placeholder="Password" />
						<input class="btn register" value="Register for free!" onclick="location.href='register'" />
						<input id="button" name="login" class="btn login" type="submit" value="Sign In" />
						<div style="clear: both;"></div>
					</form>
					<div class="box">
						There are already {hotel.registered} registered and waiting for you!
					</div>
				</div>
			
				<footer>
					<span>Copyright &copy; 2017 <a href="{hotel.url}">{hotel.name}</a>.</span><br>
					<span>Powered by <a href="https://github.com/GarettMcCarty/RevCMS">RevCMS</a>.</span>
				</footer>
			</div>
			
			<div class="right">
				<div class="rec-users">
					<table style="width: 100%;">
					{registered.recent}
					</table>
				</div>
				
				<div class="rand-user">
					<table style="width: 100%;">
						<tr>
							<td style="font-size: 13px; text-align: center;">
								Random User
							</td>
						</tr>
						<tr>
							<td class="rec-list-user" style="background: url('http://www.habbo.com/habbo-imaging/avatarimage?figure={registered.random.look}&head_direction=3&gesture=sml&headonly=1') center no-repeat;">
							{registered.random.username}
							</td>
						</tr>
					</table>
				</div>
			</div>
		</main>
		<script src="{hotel.url}/app/tpl/skins/Simple/js/jquery-3.2.1.min.js"></script>
		<script src="{hotel.url}/app/tpl/skins/Simple/js/online.js"></script>
	</body>
</html>
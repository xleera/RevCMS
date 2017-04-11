<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8"/>
		<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1"/>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<base href="{url}"/>

		<title>{hotelName} - Welcome</title>
		<link rel="stylesheet" type="text/css" href="{url}/app/tpl/skins/Priv/styles/global.css?file={rand}" />
		<meta name="description" content="{hotelDesc}"/>
	</head>
	<body>
		<div class="center content round">
			<div class="head">
				<img src="app/tpl/skins/Priv/images/logo.png" alt="Logo" />
				<div class="online"><b>{online}</b> {hotelName}'s online now!</div>
			</div>
				
			<?php
				global $template;
				if($template->form->isError())
					$template->form->outputError();
			?>
			<br />
			<div class="clear"></div>
			<div class="wrapper">
				<div class="left login small round">
					<p class="title">Login to {HotelName}</p>
						
					<form action="index" method="post" autocomplete="off" >
						<p><label for="username">Username:</label><br />
						<input type="text" name="log_username" id="username"/></p>

						<p><label for="password">Password:</label><br />
						<input type="password" name="log_password" id="password"/></p>
							
						<input type="submit" name="login" class="button round" value="Sign in!" />
					</form>
				</div>
					
				<div class="right register green small round">
					<div class="wrapper-column">
					<p>New here?</p>
					<img src="app/tpl/skins/Priv/images/smallhotel.png" alt="hotel" />
					<p><a href="register">REGISTER FOR FREE!</a></p>
					</div>
				</div>
			</div>
				
			<div class="clear"></div>
		</div>
			
		<div class="center copyright">
			 Designed by <b>joopie</b> and coded by <b>Kryptos</b>
		</div>
	</body>
</html>
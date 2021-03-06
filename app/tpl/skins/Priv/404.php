<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8"/>
		<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1"/>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<base href="{url}"/>

		<title>{hotelName} - 404</title>
		<link rel="stylesheet" type="text/css" href="{url}/app/tpl/skins/Priv/styles/global.css" />
		<meta name="description" content="{hotelDesc}"/>
	</head>
	<body>
		<div class="center content round">
			<div class="head">
				<img src="app/tpl/skins/Priv/images/logo.png" alt="Logo" />
				<div class="online"><b>{online}</b> {hotelName}'s online now!</div>
			</div>

			<div class="menu round">
				<ul>
					<li><a href="me">Me</a></li>
					<li><a href="help">Help</a></li>
					<li><a href="credits">Credits</a></li>
					
					<li class="signout"><a href="logout">Logout</a></li>
					{housekeeping}
				</ul>
			</div>

			<?php
				global $template;
				if($template->form->isError())
					$template->form->outputError();
			?>
				
			<div class="left page round">
				<img src="app/tpl/skins/Priv/images/frank_help.gif" alt="Can I help!?" style="float: right" />
					
				<h3>404</h3>
				<p>The request: {last_uri} doesn't exist :(</p>
			</div>
				
			<div class="clear"></div>
		</div>
					
		<div class="center copyright">
			Designed by <b>joopie</b> and coded by <b>Kryptos</b>
		</div>
	</body>
</html>
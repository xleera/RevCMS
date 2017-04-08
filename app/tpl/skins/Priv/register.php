<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8"/>
		<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1"/>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<base href="{url}"/>

		<title>{hotelName} - Register</title>
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

			<form action="register" method="post">
				<div class="left page round">
					<p style="margin-bottom: 18px;">Check in and check it out! - Become a {hotelName}!</p>
					<div class="register">
						<div class="left small" style="z-index: 3">
							<p><label for="username">Username:</label><br />
							<input type="text" name="reg_username" id="username" value="<?php echo $template->form->input('reg_username'); ?>" /></p>

							<p class="help">Your name can contain lowercase and uppercase letters, numbers and characters -=?!@:.</p>
								
							<p><label for="email">Email:</label><br />
							<input type="text" name="reg_email" id="email" value="<?php echo $template->form->input('reg_email'); ?>" /></p>

							<p><label for="password">Password:</label><br />
							<input type="password" name="reg_password" id="password" /></p>

							<p><label for="retypenpassword">Retype password:</label><br />
							<input type="password" name="reg_rep_password" id="retypenpassword" /></p>
						</div>
						<div class="right small" style="z-index: 1">
							<p>Choose your gender:</p>
								
							<div id="boy_tab" class="tab-active"><img src="app/tpl/skins/Priv/images/icon_boy.png" alt="boy" /></div>
							<div id="girl_tab" class="tab"><img src="app/tpl/skins/Priv/images/icon_girl.png" alt="girl" /></div>

							<div class="look box round">
								<img id="look" src="app/tpl/skins/Priv/images/avatar_boy.png" alt="" />
							</div>
							<script type="text/javascript">
							$('#boy_tab').click(function() {
								this.className = 'tab-active';
								document.getElementById('girl_tab').className = 'tab';
								document.getElementById('look').src = 'app/tpl/skins/Priv/images/avatar_boy.png';
								document.getElementById('gender').value = 'm';
							});

							$('#girl_tab').click(function() {
								this.className = 'tab-active';
								document.getElementById('boy_tab').className = 'tab';
								document.getElementById('look').src = 'app/tpl/skins/Priv/images/avatar_girl.png';
								document.getElementById('gender').value = 'f';
							});
							</script>
								
							<input type="hidden" name="reg_gender" id="gender" value="m" />
						</div>
					</div>
				</div>
					
				<div class="bottom clear">
					<a href="index" class="cancel"><span>Cancel</span></a>
					<input type="submit" class="button round pos-right" name="register" value="Done" />
				</div>
			</form>
				
			<div class="clear"></div>
		</div>
					
		<div class="center copyright">
			 Designed by <b>Joopie</b> and coded by <b>Kryptos</b>
		</div>
		<script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>
	</body>
</html>
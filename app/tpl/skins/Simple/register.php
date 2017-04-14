<?php
/**
 * RevolutionCMS
 *
 * @author	Kryptos
 * @author	GarettM
 * @version	0.0.1
 */

global $template, $engine;
?>
<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8"/>
		<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1"/>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<base href="{url}"/>

		<title>{hotelName} - Welcome</title>
		<link rel="stylesheet" type="text/css" href="{url}/app/tpl/skins/Simple/css/register.css?rand={rand}" />
		<meta name="description" content="{hotelDesc}"/>
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
				<div class="register-box">
					<table class="headline">
						<tr>
							<td align="left" width="60%"><span class="name"><a href="{url}">{hotelname} Hotel</a></span></td>
							<td align="right" width="40%"><span class="online online_users"><span class="reload_users online-count">{online}</span> online</span></td>
						</tr>
					</table>
					
					<form action="{url}/register" method="post" style="clear: both;"> 
						<input type="text" name="reg_username" id="register" value="" class="textfield" placeholder="Username" />
						<input type="password" name="reg_password" id="register" class="textfield" placeholder="Password" />
						<input type="password" name="reg_rep_password" id="register" class="textfield" placeholder="Repeat Password" />
						<input type="text" name="reg_email" id="register" value="" class="textfield" placeholder="E-Mail"/>
						<a href="{url}"><input id="button" class="btn back" value="Back" /></a>
						<input type="submit" name="register" id="button" value="Register me now!" class="btn reg"/>
					</form>
					
					<div class="box">
						You recieve free credits and pixels!
					</div>
				</div>
				
				<footer>
					<span>Copyright &copy; 2017 <a href="{url}">{hotelname}</a>.</span><br>
					<span>Powered by <a href="https://github.com/GarettMcCarty/RevCMS">RevCMS</a>.</span>
				</footer>
			</div>
			
			
			<div class="right">
				<div class="rec-users">
					<table style="width: 100%;">
					<?php
						$direction = 2;
						$users = $engine->select('users', array(), array('username', 'look'), array('id' => 'DESC'), 3)->fetchAll();
						foreach($users as $user)
						{
							echo sprintf('<tr><td class="rec-list-user" style="background: url(http://www.habbo.nl/habbo-imaging/avatarimage?figure=%s&head_direction=%d&gesture=sml&headonly=1) top center no-repeat;">%s<hr /></td></tr>', $user['look'], $direction, $user['username']);
							$direction++;
						}
					?>
					</table>
				</div>
				
				<div class="rand-user">
					<table style="width: 100%;">
						<?php
							$random = $engine->select('users', array(), array('username', 'look'), array('RAND()' => ''), 1)->fetchAll();
							$random = array_shift($random);
						?>
						<tr>
							<td style="font-size: 13px; text-align: center;">
								Random User
							</td>
						</tr>
						<tr>
							<td class="rec-list-user" style="background: url('http://www.habbo.com/habbo-imaging/avatarimage?figure=<?php echo $random['look']; ?>&head_direction=3&gesture=sml&headonly=1') center no-repeat;">
								<?php echo $random['username']; ?>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</main>
		<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
		<script src="{url}/app/tpl/skins/Simple/js/online.js"></script>
	</body>
</html>
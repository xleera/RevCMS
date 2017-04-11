<?php
/**
 * RevolutionCMS
 *
 * @author	Kryptos
 * @author	GarettM
 * @version	0.0.1
 */

/**
 * Revolution namespace
 */
use Revolution as Rev;

/**
 * Revolution Autoloader
 */
require (dirname(__FILE__) . '/app/autoload.php');
spl_autoload_register (new Rev\App\Autoload(dirname(__FILE__)));

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>RevolutionCMS - Installation</title>

		<link rel="stylesheet" href="app/tpl/system/css/install.css?<?php echo rand(1, 99); ?>">

		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body>
		<form id="install">
		  <ul id="progressbar">
			<li class="active">Requirements</li>
			<li>Database</li>
			<li>Hotel</li>
			<li>Account</li>
		  </ul>
		  <fieldset>
			<h2 class="fs-title">Requirements</h2>
			<h3 class="fs-subtitle requirement-subtitle"></h3>
			<div class="requirements-response"></div>
			<input type="button" name="next" class="next requirement_next action-button disabled" value="Next" disabled />
		  </fieldset>
		  <fieldset>
			<h2 class="fs-title">Database</h2>
			<h3 class="fs-subtitle db-subtitle">Database Settings</h3>
			<input type="text" name="db_hostname" placeholder="MySQL Hostname" />
			<input type="text" name="db_username" placeholder="MySQL Username" />
			<input type="password" name="db_password" placeholder="MySQL Password" />
			<input type="text" name="db_database" placeholder="MySQL Database" />
			<input type="button" name="previous" class="previous action-button disabled" value="Previous" disabled />
			<input type="button" name="next" class="next db_next action-button" value="Next"/>
		  </fieldset>
		  <fieldset>
			<h2 class="fs-title">Hotel</h2>
			<h3 class="fs-subtitle hotel-subtitle">Hotel Settings</h3>
			<input type="text" name="url" placeholder="Hotel Url" value="<?php echo str_ireplace('/install.php', '', "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"); ?>" />
			<input type="text" name="name" placeholder="Hotel Name" />
			<input type="text" name="desc" placeholder="Hotel Description" />
			<input type="text" name="theme" list="themes" placeholder="Hotel Theme" value="<?php echo Rev\App\System\Core::getThemes()[0]; ?>">
			<datalist id="themes">
				<?php
					/**
					 * TODO: Figure out how to populate datalist with jquery
					 */
					foreach(Rev\App\System\Core::getThemes() as $theme)
						echo sprintf('<option value="%s">', $theme);
				?>
			</datalist>
			<input type="button" name="previous" class="previous action-button disabled" value="Previous" disabled />
			<input type="button" name="next" class="next hotel_next action-button" value="Next" />
		  </fieldset>
		  <fieldset>
			<h2 class="fs-title">Personal Details</h2>
			<h3 class="fs-subtitle">This is used to setup your character</h3>
			<input type="text" name="reg_email" placeholder="Email" />
			<input type="text" name="reg_username" placeholder="Username" />
			<input type="password" name="reg_password" placeholder="Password" />
			<input type="password" name="reg_rep_password" placeholder="Repeat Password" />
			<input type="button" name="previous" class="previous action-button disabled" value="Previous" disabled />
			<input type="submit" name="submit" class="done action-button" value="Submit" />
		  </fieldset>
		</form>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
		<script src="app/tpl/system/js/install.js?<?php echo sha1(rand(1, 99)); ?>"></script>
	</body>
</html>

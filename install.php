<?php
/**
 * RevolutionCMS
 *
 * @author	Kryptos
 * @author	GarettM
 * @version	0.8.1
 */

/**
 * Namespace 
 */
use Revolution as Rev;

/**
 * Very Simple Autoloader
 */
spl_autoload_register(function ($className) {
	$fileName = str_replace('\\', '/', substr($className, strlen('Revolution\\'))) . '.php';
    
	if(file_exists($fileName))
		require ($fileName);
});

/**
 * Session
 */
if(!session_id())
	session_start();
 
/**
 * Clean input 
 */
function secure($value)
{
	return trim(htmlspecialchars($value, ENT_QUOTES, 'UTF-8'));
}

/**
 * Test Database Connection
 * @return bool
 */
function test_data($hostname, $username, $password, $database)
{
	try {
		$connection = new PDO(sprintf('mysql:host=%s;dbname=%s', $hostname, $database), $username, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	} catch(PDOException $ex) {
		return false;
		$_SESSION['last_message'] = $ex->getMessage();
	}
	
	return true;
}

# Clean POST Data
$_POST = array_merge($_GET, $_POST);
$_POST = array_map('secure', $_POST);

$action = isset($_POST['action']) ? secure($_POST['action']) : null;
if(isset($action) && !is_null($action))
{	
	# Handle Ajax Request
	$response = array();
	switch($action)
	{
		case 'db_test':
			$success = test_data($_POST['db_hostname'], $_POST['db_username'], $_POST['db_password'], $_POST['db_database']);
			if($success) {
				/**
				 * Create a configuration file
				 */
				$config = fopen('app/management/config.php', 'w');
				$content = file_get_contents('app/management/example.config.php');
				fwrite($config, sprintf($content, $_POST['db_hostname'], $_POST['db_username'], $_POST['db_password'], $_POST['db_database']));
				fclose($config);
				
				$response = array('success' => true, 'content' => '');
			}
			else {
				$response = array('success' => false, 'content' => $_SESSION['last_message']);
			}
			break;
		case 'hotel_settings':
			$engine	= Rev\app\engine::getInstance();
			
			if(empty($_POST['hotel_url']) || empty($_POST['hotel_name']) || empty($_POST['hotel_desc']) || empty($_POST['hotel_theme']))
			{
				$response = array('success' => false, 'content' => 'empty fields');
				break;
			}
			
			$queries = require (dirname(__FILE__). '/app/management/schemes.php');
			foreach($queries as $sql)
			{
				$engine->execute($sql);
			}
			
			$engine->update('cms_settings', array('setting_value' => $_POST['hotel_url']), array('setting_key' => 'hotel_url'));
			$engine->update('cms_settings', array('setting_value' => $_POST['hotel_name']), array('setting_key' => 'hotel_name'));
			$engine->update('cms_settings', array('setting_value' => $_POST['hotel_desc']), array('setting_key' => 'hotel_desc'));
			$engine->update('cms_settings', array('setting_value' => $_POST['hotel_theme']), array('setting_key' => 'hotel_theme'));
			
			if(empty($response))
				$response = array('success' => true, 'content' => '');
			
			break;
		case 'new_character':
			$engine	= Rev\app\engine::getInstance();
			$users  = Rev\app\users::getInstance();
			$core   = Rev\app\core::getInstance();
			
			if(empty($_POST['acc_password']) || empty($_POST['acc_rep_password']) || empty($_POST['acc_email']) || empty($_POST['acc_username']))
			{
				$response = array('success' => false, 'content' => 'empty fields');
				break;
			}
			
			if(empty($_POST['acc_password']) !== empty($_POST['acc_rep_password']))
			{
				$response = array('success' => false, 'content' => 'passwords don\'t match.');
				break;
			}
			
			$id = $engine->insert('users', array(
				'username' => $_POST['acc_username'],
				'password' => $core->hashed($_POST['acc_password']),
				'mail' => $_POST['acc_email'],
				'motto' => '',
				'rank' => 7,
				'look' => '-',
				'gender' => 'M',
				'auth_ticket' => '',
				'credits' => 50000,
				'activity_points' => 50000
			));
			
			$users->authenticate($id);
			
			if(empty($response))
				$response = array('success' => true, 'content' => '');
			
			break;
		default:
			$response = array('success' => false, 'content' => "The action {$action} is not defined.");
			break;
	}
	echo json_encode($response, JSON_PRETTY_PRINT);
	exit;
}

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
			<?php
				$errors = array();
				
				if(!in_array('pdo_mysql', get_loaded_extensions()))
				{
					$errors[] = "Please enabled pdo_mysql extension.";
				}
				
				if (version_compare(phpversion(), '7.0.0', '<'))
				{
					$errors[] = "PHP 7 or higher is required.";
				}
			?>
			<h2 class="fs-title">Requirements</h2>
			<h3 class="fs-subtitle"><?php echo (!empty($errors)) ? 'FAILED' : 'PASSED'; ?></h3>
			<?php
				if(!empty($errors))
				{
					foreach($errors as $error)
					{
						echo sprintf('<div class="alert">%s</div>', $error);
					}
				}
			?>
			<input type="button" name="next" class="next reg_next action-button <?php if(!empty($errors)) { echo 'disabled'; } ?>" value="Next" <?php if(!empty($errors)) { echo 'disabled'; } ?> />
		  </fieldset>
		  <fieldset>
			<h2 class="fs-title">Database</h2>
			<h3 class="fs-subtitle db-subtitle">Database Settings</h3>
			<input type="text" name="db_hostname" placeholder="MySQL Hostname" />
			<input type="text" name="db_username" placeholder="MySQL Username" />
			<input type="password" name="db_password" placeholder="MySQL Password" />
			<input type="text" name="db_database" placeholder="MySQL Database" />
			<input type="button" name="previous" class="previous action-button" value="Previous" />
			<input type="button" name="next" class="next db_next action-button disabled" value="Next" />
		  </fieldset>
		  <fieldset>
			<h2 class="fs-title">Hotel</h2>
			<h3 class="fs-subtitle hotel-subtitle">Hotel Settings</h3>
			<input type="text" name="hotel_url" placeholder="Hotel Url" />
			<input type="text" name="hotel_name" placeholder="Hotel Name" />
			<input type="text" name="hotel_desc" placeholder="Hotel Description" />
			<input type="text" name="hotel_theme" list="themes" placeholder="Hotel Theme">
			<datalist id="themes">
				<?php
					$themes = array_filter(glob('app/tpl/skins/*'), 'is_dir');
					foreach($themes as $directory)
					{
						echo sprintf('<option value="%s">', substr($directory, strlen('app/tpl/skins/')));
					}
				?>
			</datalist>
			<input type="button" name="previous" class="previous action-button" value="Previous" />
			<input type="button" name="next" class="next hotel_next action-button disabled" value="Next" />
		  </fieldset>
		  <fieldset>
			<h2 class="fs-title">Personal Details</h2>
			<h3 class="fs-subtitle">This is used to setup your character</h3>
			<input type="text" name="acc_email" placeholder="Email" />
			<input type="text" name="acc_username" placeholder="Username" />
			<input type="text" name="acc_password" placeholder="Password" />
			<input type="text" name="acc_rep_password" placeholder="Repeat Password" />
			<input type="button" name="previous" class="previous action-button" value="Previous" />
			<input type="submit" name="submit" class="submit action-button" value="Submit" />
		  </fieldset>
		</form>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
		<script src="app/tpl/system/js/install.js?<?php echo sha1(rand(1, 99)); ?>"></script>
	</body>
</html>

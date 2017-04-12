<?php
/**
 * RevolutionCMS
 *
 * @author	Kryptos
 * @author	GarettM
 * @version	0.0.1
 */

/**
 * Revolution autoloader
 */
require (dirname(__FILE__) . '/app/autoload.php');
spl_autoload_register (new Revolution\App\Autoload(dirname(__FILE__)));

/**
 * Initialize the session
 */
if(!session_id())
	session_start();

/**
 * Do Request/API Call
 * @return string
 */
try {
	$secret = null;
	
	$input = array_merge($_GET, $_POST);
	$input = array_map('Revolution\App\System\Core::secure', $input);
	
	$response = array('action' => $input['action'], 'success' => false, 'content' => '');
	
	switch(@$input['action'])
	{
		case null:
		default:
			$response['content'] = sprintf('The action [%s] is not defined.', $input['action']);
			break;
		/**
		 * Account
		 */
		case 'account_add':
			$template	= Revolution\App\System\Template::getInstance();
			$engine		= Revolution\App\System\Engine::getInstance();
			$users		= Revolution\App\System\Users::getInstance();
			$core		= Revolution\App\System\Core::getInstance();
			
			$authenticate = true;
			if(isset($input['authenticate']))
				$authenticate = $input['authenticate'];
			
			$users->register(false, $authenticate);
			if($template->form->isError())
			{
				$response['content'] = $template->form->getError();
				break;
			}
			
			$username 	  = isset($_SESSION['account']['username']) ? $_SESSION['account']['username'] : null;
			if($users->isStaffMember($username) || isset($_SESSION['app.installation']))
			{	
				if(isset($input['rank']))
				{
					$users->updateUser($_SESSION['account']['id'], 'rank', $input['rank']);
				}
			}
			
			$response['success'] = true;
			
			break;
		case 'account_edit':
			$username = isset($_SESSION['account']['username']) ? $_SESSION['account']['username'] : null;
			if($users->isStaffMember($username) == true)
			{
				
			}
			else {
				$response['content'] = 'Action not authorized';
			}
			break;
		case 'account_delete':
			$username = isset($_SESSION['account']['username']) ? $_SESSION['account']['username'] : null;
			if($users->isStaffMember($username) == true)
			{
				
			}
			break;
		case 'account_view':
			$engine  = Revolution\App\System\Engine::getInstance();
			$account = isset($input['username']) ? $username : 
				isset($input['email']) ? $input['email'] : 
					isset($input['id']) ? $input['id'] :
						null;
					
			if(!is_null($account))
			{
				if(is_int($account))
					$account = $users->getInfo($account, 'mail');
				
				if(!$users->nameTaken($account) && !$users->emailTaken($account))
				{
					$response['content'] = 'No account exists';
					break;
				}
				
				if($users->validEmail($account))
				{
					$account = $users->getUsername($account);
				}
				
				$response['success'] = true;
				$response['content'] = $engine->select('users', array('username' => $account))->fetch();
			}
			else {
				$response['content'] = 'No account selected';
			}
			break;
			/**
			 * Installer
			 */
			case 'installer_requirements':
				if(file_exists(dirname(__FILE__) . '/app/management/config.php'))
				{
					$response['content'] = 'Please delete "app/management/config.php" before continuing.';
					break;
				}
				
				$requirements = array();
				
				if(!in_array('pdo_mysql', get_loaded_extensions()))
				{
					$requirements[] = 'Please install MySQL PDO Driver.';
				}
				
				if(version_compare(phpversion(), '7.0.0', '<'))
				{
					$requirements[] = 'Please install PHP 7 or higher.';
				}
				
				if(!empty($requirements))
				{
					$response['content'] = $requirements;
					break;
				}
				
				$_SESSION['app.installation'] = 1;
				
				$response['success'] = true;
				$response['content'] = 'PASSED';				
				break;
			case 'installer_database':
				if(file_exists(dirname(__FILE__) . '/app/management/config.php'))
				{
					$response['content'] = 'Please delete "app/management/config.php" before continuing.';
					break;
				}

				$hostname = $input['hostname'];
				$username = $input['username'];
				$password = $input['password'];
				$database = $input['database'];
				
				if(!isset($hostname, $username, $password, $database))
				{
					$response['content'] = 'Please fill out all fields';
					break;
				}
				
				$testdb = Revolution\App\System\Engine::test($hostname, $username, $password, $database);
				
				if(!$testdb)
				{
					$response['content'] = 'Invalid Database Credentials';
					break;
				}
				
				$config  = fopen(dirname(__FILE__) . '/app/management/config.php', 'w');
				$content = file_get_contents(dirname(__FILE__) . '/app/management/example.config.php');
				fwrite($config, sprintf($content, $hostname, $username, $password, $database));
				fclose($config);
				
				$_SESSION['app.installation'] = 2;
				
				$response['success'] = true;
				break;
			case 'installer_hotel':
				$engine	= Revolution\App\System\Engine::getInstance();
				
				$url   = isset($input['url'])	? $input['url']   : null;
				$name  = isset($input['name'])  ? $input['name']  : null;
				$desc  = isset($input['desc'])  ? $input['desc']  : null;
				$theme = isset($input['theme']) ? $input['theme'] : null;
				if(!in_array($theme, Revolution\App\System\Core::getThemes()))
				{
					// TODO: tell user theme is not installed.
					$theme = 'Priv';
				}
			
				if(!isset($url, $name, $desc, $theme))
				{
					$response['content'] = 'Please fill out all fields';
					break;
				}
				
				$queries = require (dirname(__FILE__). '/app/management/schemes.php');
				foreach($queries as $sql)
					$engine->execute($sql);
				
				$engine->update('cms_settings', array('setting_value' => $url),   array('setting_key' => 'hotel_url'));
				$engine->update('cms_settings', array('setting_value' => $name),  array('setting_key' => 'hotel_name'));
				$engine->update('cms_settings', array('setting_value' => $desc),  array('setting_key' => 'hotel_desc'));
				$engine->update('cms_settings', array('setting_value' => $theme), array('setting_key' => 'hotel_theme'));
				
				$_SESSION['app.installation'] = 3;
				
				$response['success'] = true;
				break;
			/**
			 * Articles/News
			 */
			case 'article_add':
				break;
			case 'article_edit':
				break;
			case 'article_delete':
				break;
			case 'article_view':
				break;
				
			/**
			 * Comments
			 */
			case 'comment_add':
				break;
			case 'comment_edit':
				break;
			case 'comment_delete':
				break;
			case 'comment_view':
				break;
			
			/**
			 * Hotel
			 */
			case 'online_count':
				break;
			case 'settings_set':
				break;
			case 'settings_get':
				$core = Revolution\App\System\Core::getInstance();
				
				if(!isset($input['key']))
				{
					$response['content'] = 'No settings found / No key supplied';
					break;
				}
				
				$result = $core->cms_settings($input['key'], null);
				
				if(is_null($result))
				{
					$response['content'] = 'No settings found for key ' . $input['key'];
					break;
				}
				
				$response['content'] = $result;
				$response['success'] = true;
				break;
	}
	
	echo json_encode($response, JSON_PRETTY_PRINT);
	
} catch(Exception $ex) {
	# Display any caught exceptions
	Revolution\App\System\Core::systemError('API', $ex);
}
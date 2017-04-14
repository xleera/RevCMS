<?php
/**
 * RevolutionCMS
 *
 * @author	Kryptos
 * @author	GarettM
 * @version	0.0.1
 */
 
namespace Revolution\App\System;
use Exception;

class Core
{
	/**
	 * @var self
	 */
	protected static $instance = null;
	
	/**
	 * Get instance of self
	 * @return &self
	 */
	public static function &getInstance()
	{
		if(!self::$instance instanceof self)
			self::$instance = new self;
		
		return self::$instance;
	}
	
	/**
	 * @var \Revolution\App\System\Engine
	 */
	protected $engine;
	
	/**
	 * @var \Revolution\App\System\Users
	 */
	protected $users;
	
	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->engine = engine::getInstance();
		$this->users  = users::getInstance();
	}
	
	/**
	 * Secure a variable
	 * @param string $variable
	 * @return string
	 */
	public static function secure($value)
	{
		return trim(htmlspecialchars($value, ENT_QUOTES, 'UTF-8'));
	}
	
	/**
	 * Get the ammount of users online
	 * @return int
	 */
	public static function getOnline()
	{
		$engine = Engine::getInstance();
		return $engine->select('server_status', array(), 'users_online')->fetch();
	}
	
	/**
	 * Displays an error page for revolution.
	 * @param string $component
	 * @param Exception $exception
	 */
	public static function systemError($component, $exception)
	{
		if(is_string($exception))
		{
			$exception = new Exception($exception);
		}
		
		$params  = array(
			'who'		 => $component,
			'ex.message' => $exception->getMessage(),
			'ex.code'	 => $exception->getCode(),
			'ex.file' 	 => $exception->getFile(),
			'ex.line' 	 => $exception->getLine(),
			'ex.trace'	 => json_encode($exception->getTrace(), JSON_PRETTY_PRINT)
		);
		
		ob_start();
		require (dirname(__FILE__) . '/../tpl/system/error.php');
		$content = ob_get_contents();
		ob_end_clean();
		
		foreach($params as $key => $value)
			$content = str_ireplace("{{$key}}", $value, $content);
		
		echo $content;
		exit();
	}
	
	/**
	 * Get a settings value by key
	 * @param string $key
	 * @return mixed|null
	 */
	public function cms_settings($key, $default = null)
	{
		$result = $this->engine->select('cms_settings', array('setting_key' => $key), 'setting_value')->fetch();
		return ($result) ? $result : $default;
	}
	
	/**
	 * Get the hotel name
	 * @return string
	 */
	public static function getHotelName()
	{
		$core = self::getInstance();
		return $core->cms_settings('hotel_name');
	}
	
	
	/**
	 * Get the hotel description
	 * @return string
	 */
	public static function getHotelDesc()
	{
		$core = self::getInstance();
		return $core->cms_settings('hotel_desc');
	}
	
	/**
	 * Get the hotel url
	 * @return string
	 */
	public static function getHotelUrl()
	{
		$core = self::getInstance();
		return $core->cms_settings('hotel_url');
	}
	
	/**
	 * Get the hotel theme
	 * @return string
	 */
	public static function getHotelTheme()
	{
		$core = self::getInstance();
		return $core->cms_settings('hotel_theme', 'Priv');
	}
	
	/**
	 * Get the hotel emulator address
	 * @return string
	 */
	public static function getServerAddress()
	{
		$core = self::getInstance();
		return $core->cms_settings('hotel_server_addr');
	}
	
	/**
	 * Get the hotel emulator port
	 * @return int
	 */
	public static function getServerPort()
	{
		$core = self::getInstance();
		return $core->cms_settings('hotel_server_port');
	}
	
	/**
	 * Get the hotel web build
	 * @return string
	 */
	public static function getHotelWebBuild()
	{
		$core = self::getInstance();
		return $core->cms_settings('hotel_build');
	}
	
	/**
	 * Get the hotel external variables file
	 * @return string
	 */
	public static function getHotelExternalVar()
	{
		$core = self::getInstance();
		return $core->cms_settings('hotel_external_vars');
	}
	
	/**
	 * Get the hotel external texts path
	 * @return string
	 */
	public static function getHotelExternalTxt()
	{
		$core = self::getInstance();
		return $core->cms_settings('hotel_external_texts');
	}
	
	/**
	 * Get the hotel swf folder
	 * @return string
	 */
	public static function getHotelSwfFolder()
	{
		$core = self::getInstance();
		return $core->cms_settings('hotel_swf_folder');
	}
	
	/**
	 * Get the ammount of users registered
	 * @return int
	 */
	public static function getRegisteredCount()
	{
		$engine = engine::getInstance();
		$result = $engine->query('SELECT count(*) FROM users');
	}
	
	/**
	 * Check if configuration file exist
	 * @return bool
	 */
	public static function configExist()
	{
		if(file_exists(dirname(__FILE__) . '/../management/config.php'))
			return true;
		return false;
	}
	
	/**
	 * Get available themes
	 * @return array
	 */
	public static function getThemes()
	{
		$themes = array();
		
		$themedir = dirname(__FILE__) . '/../tpl/skins/*';
		$data = array_filter(glob($themedir), 'is_dir');
		
		foreach($data as $x)
			$themes[] =  substr($x, strlen(dirname(__FILE__) . '/../tpl/skins/'));
		
		return $themes;
	}
	
	/**
	 * Handle URI requests
	 * @param string $uri 
	 *
	 * TODO: Instead of switch($uri) use Routes
	 */
	public function handle($uri)
	{
		$maintenance = $this->cms_settings('hotel_maintenance');
		
		if($maintenance === 'true')
		{
			$this->redirect('/maintenance');
			exit;
		}
		
		if($this->users->isLogged())
		{
			switch($uri)
			{
				case 'index':
				case 'register':
				case null:
					$this->redirect('/me');
					break;
				case 'account':
					$this->users->updateAccount();
					break;
				default:
				case 'help':
				case 'forgot':
					break;
			}
		}
		else {
			switch($uri)
			{
				case 'index':
				case null:
					$this->users->login();
					break;
				case 'register':
					$this->users->register();
					break;
				default:
					$this->redirect('/index');
					exit;
					break;
			}
		}
	}
	
	/**
	 * Hash a password with a random salt
	 * @param string $password
	 * @return string
	 */
	public static function hash($password)
	{
		return password_hash($password, PASSWORD_DEFAULT);
	}
	
	/**
	 * Redirect to another page
	 * @param string $uri
	 * @param bool $external
	 */
	public static function redirect($uri, $external = false)
	{
		if($external)
			$location = sprintf('Location: %s', $uri);
		else
			$location = sprintf('Location: %s%s', core::getHotelUrl(), $uri);
		
		header($location);
		exit;
	}
}
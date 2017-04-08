<?php
/**
 * RevolutionCMS
 *
 * @author	Kryptos
 * @author	GarettM
 * @version	0.8.1
 */
 
namespace Revolution\app;
use Exception;

class core
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
	 * @var \Revolution\app\engine
	 */
	protected $engine;
	
	/**
	 * @var \Revolution\app\users
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
	public function secure($value)
	{
		return trim(htmlspecialchars($value, ENT_QUOTES, 'UTF-8'));
	}
	
	/**
	 * Get hotel online count
	 * @return int
	 */
	public function getOnline()
	{
		return $this->engine->select('server_status', array(), 'users_online')->fetch();
	}
	
	/**
	 * Get hotel status
	 * @return string
	 */
	public function getStatus()
	{
		#return $this->engine->result('SELECT status FROM server_status');
	}
	
	/**
	 * Displays an error page for revolution.
	 * @param string $who
	 * @param Exception $ex 
	 */
	public static function systemError($who, $ex)
	{
		if(is_string($ex))
		{
			$ex = new Exception($ex);
		}
		
		$params  = array(
			'who' => $who,
			'ex.message' => $ex->getMessage(),
			'ex.code' => $ex->getCode(),
			'ex.file' => $ex->getFile(),
			'ex.line' => $ex->getLine(),
			'ex.trace' => json_encode($ex->getTrace(), JSON_PRETTY_PRINT)
		);
		ob_start();
		require (dirname(__FILE__) . '/tpl/system/error.php');
		$content = ob_get_contents();
		ob_end_clean();
		
		foreach($params as $key => $value)
			$content = str_ireplace("{{$key}}", $value, $content);
		
		echo $content;
		exit;
	}
	
	/**
	 * Get Hotel Settings
	 * @param $key
	 */
	public function getSetting($key)
	{
		$result = $this->engine->select('cms_settings', array('setting_key' => $key), 'setting_value')->fetch();
		if(is_array($result))
			$result = array_shift($result);
		return $result;
	}
	
	/**
	 * Get hotel name
	 * @return string
	 */
	public function getHotelName()
	{
		return $this->getSetting('hotel_name');
	}
	
	
	/**
	 * Get hotel description
	 * @return string
	 */
	public function getHotelDesc()
	{
		return $this->getSetting('hotel_desc');
	}
	
	/**
	 * Get hotel url
	 * @return string
	 */
	public function getHotelUrl()
	{
		return $this->getSetting('hotel_url');
	}
	
	/**
	 * Get hotel theme
	 */
	public function getHotelTheme()
	{
		return $this->getSetting('hotel_theme');
	}
	
	/**
	 * Get hotel web build
	 * @return string
	 */
	public function getHotelWebBuild()
	{
		return $this->getSetting('hotel_build');
	}
	
	/**
	 * Get hotel external variables file
	 * @return string
	 */
	public function getHotelExternalVars()
	{
		return $this->getSetting('hotel_external_vars');
	}
	
	/**
	 * Get hotel external texts file
	 * @return string
	 */
	public function getHotelExternalTexts()
	{
		return $this->getSetting('hotel_external_texts');
	}
	
	/**
	 * Get hotel swf folder
	 * @return string
	 */
	public function getHotelSwfFolder()
	{
		return $this->getSetting('hotel_swf_folder');
	}
	
	/**
	 * Handle URI 
	 * @param string $uri 
	 *
	 * TODO: Instead of switch($uri) use Routes
	 */
	public function handleCall($uri)
	{
		global $_CONFIG;
		$maintence = $this->getSetting('hotel_maintence');
		
		if($maintence === 'true')
		{
			$this->redirect('/maintence');
			exit;
		}
		
		# Replace with routing
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
	
	public function hashed($password)
	{
		return password_hash($password, PASSWORD_DEFAULT);
	}
	
	public function redirect($uri, $external = false)
	{
		if($external == true)
		{
			header(sprintf('Location: %s', $uri));
		}
		else {
			header(sprintf('Location: %s%s', $this->getHotelUrl(), $uri));
		}
		exit;
	}
}
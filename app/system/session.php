<?php
/**
 * RevolutionCMS
 *
 * @author	Kryptos
 * @author	GarettM
 * @version	0.0.1
 */
 
namespace Revolution\App\System;

class Session
{
	/**
	 * @var string
	 */
	protected static $name;
	
	/**
	 * @var int
	 */
	protected static $lifetime;
	
	/**
	 * @var string
	 */
	protected static $path;
	
	/**
	 * @var bool
	 */
	protected static $secure;
	
	
	/**
	 * Initialize a new session if one doesn't exist.
	 */
	public static function init()
	{
		if(!self::sessionId())
			self::create(sha1('RevSession-%s-%d', 'Should Probably Randomize This More' . rand(1,33)), microtime());
	}
	
	/**
	 * Create a new session
	 * @param string $name
	 * @param string $domain
	 * @param string $path
	 * @param int $lifetime
	 * @param bool $secure
	 */
	public static function create($name, $domain = null, $lifetime = false, $path = false, $secure = false)
	{
		self::$name		= $name;
		self::$lifetime = isset($lifetime) ? $lifetime : ini_get('session.gc_maxlifetime');
		self::$path		= isset($path) ? $path : ini_get('session.save_path');
		$domain = !is_null($domain) ? $domain : Core::getHotelUrl();
		self::$secure	= $secure;
		
		session_set_cookie_params($lifetime, $path, $domain, $secure, true);
		session_name($name);
		session_start();
	}
	
	/**
	 * Get the session identifier
	 * @return int
	 */
	public static function sessionId()
	{
		return session_id();
	}
	
	/**
	 * Return all parameters in session data
	 * @return array|null
	 */
	public static function all()
	{
		if(isset($_SESSION))
			return $_SESSION;
		
		return null;
	}
	
	/**
	 * Read a parameter from session data
	 * @param string $key 
	 * @return mixed|null
	 */
	public static function read($key)
	{
		if(isset($_SESSION[$key]))
			return $_SESSION[$key];
		return null;
	}
	
	/**
	 * Write a new parameter to session data
	 * @param string $key
	 * @param mixed $value
	 */
	public static function write($key, $value)
	{
		$_SESSION[$key] = $value;
	}
	
	/**
	 * Destroy the current session
	 */
	public static function destroy()
	{
		session_destroy();
		unset($_SESSION);
	}
}
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
 * Revolution autoloader
 */
require (dirname(__FILE__) . '/app/autoload.php');
spl_autoload_register (new Rev\App\Autoload(dirname(__FILE__)));

/**
 * Initialize the session
 */
if(!session_id())
	session_start();

/**
 * Check if a configuration file exists.
 */
if(!Rev\App\System\Core::configExist())
{
	$request = isset($_GET['url'][0]) ? Rev\App\System\Core::secure($_GET['url']) : 'index';
	header(sprintf('Location: %s/install.php', str_ireplace($request, '', "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]")));
	exit;
}

/**
 * Revolution Objects
 */
$core		= Rev\App\System\Core::getInstance();
$engine		= Rev\App\System\Engine::getInstance();
$users 		= Rev\App\System\Users::getInstance();
$template	= Rev\App\System\Template::getInstance();

/**
 * Run Application
 */
try {
	/**
	 * Clean and set $request 
	 */
	$request = isset($_GET['url'][0]) ? $core::secure($_GET['url']) : 'index';
	
	
	/**
	 * Handle Functions for $request
	 */
	$core->handle($request);

	/**
	 * Get and Display $request Template
	 */
	$template->html->get($request);
	$template->output();
} 
catch(Exception $ex) {
	/**
	 * Display Application Exceptions
	 */
	$core::systemError('System', $ex);
}
<?php
/**
 * RevolutionCMS
 *
 * @author	Kryptos
 * @author	GarettM
 * @version	0.8.1
 */

use Revolution as Rev;

/**
 * Very Simple Autoloader
 */
spl_autoload_register(function ($className) {
	$fileName = str_replace('\\', '/', substr($className, strlen('Revolution\\'))) . '.php';
    require ($fileName);
});

/**
 * Start Session
 */
if(!session_id())
	session_start();

/**
 * Revolution Config
 */
if(file_exists(dirname(__FILE__) . '/app/management/config.php'))
{
	require (dirname(__FILE__) . '/app/management/config.php');
}
else {
	header('Location: /install.php');
	exit;
}

/**
 * Global Revolution Objects
 */
$core		= Rev\app\core::getInstance();
$engine		= Rev\app\engine::getInstance();
$users 		= Rev\app\users::getInstance();
$template	= Rev\app\template::getInstance();

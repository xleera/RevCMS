<?php
/**
 * RevolutionCMS
 *
 * @author	Kryptos
 * @author	GarettM
 * @version	0.8.1
 */

require (dirname(__FILE__) . '/global.php');

try {
	/**
	 * Get URI Request 
	 */
	$request = $core->secure(@$_GET['url']) ?: 'index';

	/**
	 * Handle URI Request
	 */
	$core->handleCall($request);

	/**
	 * Display URI Page
	 */
	$template->html->get($request);
	$template->outputTPL();
} catch(Exception $ex) {
	$core::systemError('Syste', $ex);
}
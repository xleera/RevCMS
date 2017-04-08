<?php
/**
 * RevolutionCMS
 *
 * @author	Kryptos
 * @author	GarettM
 * @version	0.8.1
 */

# Include rev globals
require (dirname(__FILE__) . '/global.php');
 
try {
	# Get URI Request and clean it.
	$request = $core->secure(@$_GET['url']) ?: 'index';

	# Handle URI Request
	$core->handleCall($request);

	# Display URI Page
	$template->html->get($request);
	$template->outputTPL();
} catch(Exception $ex) {
	# Display any caught exceptions
	$core::systemError('Syste', $ex);
}
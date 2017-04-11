<?php
/**
 * RevolutionCMS
 *
 * @author	Kryptos
 * @author	GarettM
 * @version	0.0.1
 */

require (dirname(__FILE__) . '/app/global.php');
 
try {
	var_dump($_GET);
} catch(Exception $ex) {
	# Display any caught exceptions
	$core::systemError('Syste', $ex);
}
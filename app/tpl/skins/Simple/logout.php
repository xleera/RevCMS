<?php
/**
 * RevolutionCMS
 *
 * @author	Kryptos
 * @author	GarettM
 * @version	0.0.1
 */
 
global $core;

if (session_id())
	session_destroy();

$core->redirect('/index');
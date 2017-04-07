<?php
/**
 * RevolutionCMS
 *
 * @author	Kryptos
 * @version	0.8.0
 */
 
global $core;

if (session_id())
	session_destroy();

$core->redirect('/index');
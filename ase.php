<?php
/**
 * RevolutionCMS
 * 
 * @author	Kryptos
 * @author	GarettM
 * @version 0.8.1
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
 * Revolution Objects
 */
$core		= Rev\App\System\Core::getInstance();
$engine		= Rev\App\System\Engine::getInstance();
$users 		= Rev\App\System\Users::getInstance();
$template	= Rev\App\System\Template::getInstance();

/**
 * ASE Objects
 */
$domain		= $core::getHotelUrl();
$sitename	= $core::getHotelName();
$input 		= array_merge($_GET, $_POST);
$input 		= array_map('Revolution\App\System\Core::secure', $input);
$action		= isset($input['action'][0]) ? $input['action'] : 'dashboard';
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title><?php echo $sitename; ?> - ASE</title>
		<link href="<?php echo $domain; ?>/app/tpl/system/css/bootstrap.min.css" rel="stylesheet">
		<link href="<?php echo $domain; ?>/app/tpl/system/css/sb-admin.css" rel="stylesheet">
		<link href="<?php echo $domain; ?>/app/tpl/system/css/plugins/morris.css" rel="stylesheet">
		<link href="<?php echo $domain; ?>/app/tpl/system/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body>
		<div id="wrapper">
			<!-- Navigation -->
			<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="<?php echo $domain; ?>"><?php echo $sitename; ?></a>
				</div>
				<!-- Top Menu Items -->
				<ul class="nav navbar-right top-nav">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-envelope"></i> <b class="caret"></b></a>
						<ul class="dropdown-menu message-dropdown">
							<!--li class="message-preview">
								<a href="#">
									<div class="media">
										<span class="pull-left">
											<img class="media-object" src="http://placehold.it/50x50" alt="">
										</span>
										<div class="media-body">
											<h5 class="media-heading"><strong>{message.username}</strong>
											</h5>
											<p class="small text-muted"><i class="fa fa-clock-o"></i> {message.datetime}</p>
											<p>substr({message.content}, 0, 255) ...</p>
										</div>
									</div>
								</a>
							</li>
							<li class="message-footer">
								<a href="#">Read All New Messages</a>
							</li-->
						</ul>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $_SESSION['account']['username']; ?><b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li>
								<a href="<?php echo $domain; ?>/ase.php?action=account&task=edit&id=<?php echo $_SESSION['account']['id']; ?>"><i class="fa fa-fw fa-user"></i> Profile</a>
							</li>
							<li>
								<a href="<?php echo $domain; ?>/ase.php?action=tickets"><i class="fa fa-fw fa-envelope"></i> Inbox</a>
							</li>
							<li>
								<a href="<?php echo $domain; ?>/ase.php?action=settings"><i class="fa fa-fw fa-gear"></i> Settings</a>
							</li>
							<li class="divider"></li>
							<li>
								<a href="<?php echo $domain; ?>/logout"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
							</li>
						</ul>
					</li>
				</ul>
				<div class="collapse navbar-collapse navbar-ex1-collapse">
					<ul class="nav navbar-nav side-nav">
						<li <?php echo ($action == 'dashboard') ? 'class="active"' : ''; ?>>
							<a href="<?php echo $domain; ?>/ase.php?action=dashboard"><i class="fa fa-fw fa-dashboard"></i>&nbsp;&nbsp;Dashboard</a>
						</li>
						<li <?php echo ($action == 'accounts') ? 'class="active"' : ''; ?>>
							<a href="<?php echo $domain; ?>/ase.php?action=account"><i class="fa fa-fw fa-edit"></i>&nbsp;&nbsp;Accounts</a>
						</li>
						<li <?php echo ($action == 'articles') ? 'class="active"' : ''; ?>>
							<a href="<?php echo $domain; ?>/ase.php?action=articles"><i class="fa fa-newspaper-o"></i>&nbsp;&nbsp;Articles</a>
						</li>
					</ul>
				</div>
			</nav>
			<div id="page-wrapper">
			</div>
		</div>
		<script src="<?php echo $domain; ?>/app/tpl/system/js/jquery.js"></script>
		<script src="<?php echo $domain; ?>/app/tpl/system/js/bootstrap.min.js"></script>
		<script src="<?php echo $domain; ?>/app/tpl/system/js/ase.js"></script>
		<script src="<?php echo $domain; ?>/app/tpl/system/js/plugins/morris/raphael.min.js"></script>
		<script src="<?php echo $domain; ?>/app/tpl/system/js/plugins/morris/morris.min.js"></script>
	</body>
</html>


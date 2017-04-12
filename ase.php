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
							<li class="message-preview">
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
							</li>
						</ul>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $_SESSION['account']['username']; ?><b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li>
								<a href="<?php echo $domain; ?>/ase.php?action=account&user=<?php echo $_SESSION['account']['id']; ?>"><i class="fa fa-fw fa-user"></i> Profile</a>
							</li>
							<li>
								<a href="<?php echo $domain; ?>/ase/"><i class="fa fa-fw fa-envelope"></i> Inbox</a>
							</li>
							<li>
								<a href="<?php echo $domain; ?>/ase/settings"><i class="fa fa-fw fa-gear"></i> Settings</a>
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
							<a href="<?php echo $domain; ?>/ase"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
						</li>
						<li <?php echo ($action == 'accounts') ? 'class="active"' : ''; ?>>
							<a href="<?php echo $domain; ?>/ase/accounts"><i class="fa fa-fw fa-edit"></i> Accounts</a>
						</li>
						<li <?php echo ($action == 'emulator') ? 'class="active"' : ''; ?>>
							<a href="<?php echo $domain; ?>/ase/emulator"><i class="fa fa-fw fa-desktop"></i> Emulator</a>
						</li>
						<li <?php echo ($action == 'settings') ? 'class="active"' : ''; ?>>
							<a href="<?php echo $domain; ?>/ase/settings"><i class="fa fa-fw fa-wrench"></i> Hotel Settings</a>
						</li>
					</ul>
				</div>
			</nav>
			<?php
			/**
			 * Blank Page
			 */
			if(is_null($action) || !in_array($action, array('dashboard', 'account', 'accounts', 'emulator', 'settings'))):
			?>
			<div id="page-wrapper">
			</div>
			<?php
			endif;
			/**
			 * TODO: Move to partial use jQuery or Angular.
			 * RevolutionCMS ASE Accounts
			 */
			if($action == 'accounts'):
			?>
			<div id="page-wrapper">
				<div class="container-fluid">
					<!-- Page Heading -->
					<div class="row">
						<div class="col-lg-12">
							<h1 class="page-header">Accounts</h1>
							<ol class="breadcrumb">
								<li><i class="fa fa-dashboard"></i>  <a href="<?php echo $domain; ?>/ase/dashboard">Dashboard</a></li>
								<li class="active"><i class="fa fa-table"></i> Accounts</li>
							</ol>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-12">
							<div class="table-responsive">
								<table class="table table-bordered table-hover table-striped">
									<thead>
										<tr>
											<th>ID</th>
											<th>Username</th>
											<th>Email</th>
											<th>Rank</th>
											<th>Created</th>
											<th>Last Online</th>
										</tr>
									</thead>
									<tbody>
										<?php
											$result = $engine->select('users')->fetchAll();
											foreach($result as $account)
											{
												echo sprintf('<tr><td><a href="%s/ase.php?action=account&user=%d">%d</a></td><td>%s</td><td>%s</td><td>%d</td><td>%s</td><td>%s</td></tr>', $domain, $account['id'], $account['id'], $account['username'], $account['mail'], $account['rank'], $account['account_created'], $account['last_online']) . PHP_EOL;
											}
										?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php
			/**
			 * END: Accounts
			 */
			endif;
			/**
			 * TODO: Move to partial use jQuery or Angular.
			 * RevolutionCMS ASE Account
			 */
			if($action == 'account'):
				$account_id = isset($input['user']) ? $input['user'] : null;
				if(is_null($account_id))
				{
					$core::redirect('/ase/accounts');
				}
			?>
			<div id="page-wrapper">
				<div class="container-fluid">
					<div class="row">
						<div class="col-lg-12">
							<h1 class="page-header">
								Accounts
							</h1>
							<ol class="breadcrumb">
								<li><i class="fa fa-dashboard"></i>  <a href="<?php echo $domain; ?>/ase/dashboard">Dashboard</a></li>
								<li><i class="fa fa-table"></i> <a href="<?php echo $domain; ?>/ase/accounts">Accounts</a></li>
								<li class="active"><i class="fa fa-user"></i> <?php echo $users->getInfo($account_id, 'username'); ?></li>
							</ol>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-10">
							<form role="form">
								<div class="form-group">
									<label>Username</label>
									<input class="form-control" value="<?php echo $users->getInfo($account_id, 'username'); ?>">
								</div>
								<div class="form-group">
									<label>Email</label>
									<input class="form-control" value="<?php echo $users->getInfo($account_id, 'mail'); ?>">
								</div>
								<div class="form-group">
									<label>Rank</label>
									<input class="form-control" value="<?php echo $users->getInfo($account_id, 'rank'); ?>">
								</div>
								<div class="form-group">
									<label>Credits</label>
									<input class="form-control" value="<?php echo $users->getInfo($account_id, 'credits'); ?>">
								</div>
								<div class="form-group">
									<label>Pixels</label>
									<input class="form-control" value="<?php echo $users->getInfo($account_id, 'activity_points'); ?>">
								</div>
								<div class="form-group">
									<label>Figure</label>
									<input class="form-control" value="<?php echo $users->getInfo($account_id, 'look'); ?>">
								</div>
								<div class="form-group">
									<?php
										$gender = $users->getInfo($account_id, 'gender');
									?>
									<label>Gender</label>
									<label class="radio-inline">
										<input type="radio" name="acc_gender" id="accountGenderRadioMale" value="M" <?php echo (strtoupper($gender)) == 'M' ? 'checked' : ''; ?>>Male
									</label>
									<label class="radio-inline">
										<input type="radio" name="acc_gender" id="accountGenderRadioFemale" value="F" <?php echo (strtoupper($gender)) == 'F' ? 'checked' : ''; ?>>Female
									</label>
								</div>
								<div class="form-group">
									<label>Motto</label>
									<input class="form-control" value="<?php echo $users->getInfo($account_id, 'motto'); ?>">
								</div>
								<div class="form-group">
                                    <label for="disabledSelect">Auth Ticket</label>
                                    <input class="form-control" type="text" value="<?php echo $users->getInfo($account_id, 'auth_ticket'); ?>" disabled>
                                </div>
								<div class="form-group">
                                    <label for="disabledSelect">Regular IP</label>
                                    <input class="form-control" type="text" value="<?php echo $users->getInfo($account_id, 'ip_reg'); ?>" disabled>
                                </div>
								<div class="form-group">
                                    <label for="disabledSelect">Last IP</label>
                                    <input class="form-control" type="text" value="<?php echo $users->getInfo($account_id, 'ip_last'); ?>" disabled>
                                </div>
								<button type="submit" class="btn btn-default">Submit</button>
							</form>
						</div>
					</div>
				</div>
			</div>
			<?php
			endif;
			?>
		</div>
		<script src="<?php echo $domain; ?>/app/tpl/system/js/jquery.js"></script>
		<script src="<?php echo $domain; ?>/app/tpl/system/js/bootstrap.min.js"></script>
		<script src="<?php echo $domain; ?>/app/tpl/system/js/plugins/morris/raphael.min.js"></script>
		<script src="<?php echo $domain; ?>/app/tpl/system/js/plugins/morris/morris.min.js"></script>
		<script src="<?php echo $domain; ?>/app/tpl/system/js/plugins/morris/morris-data.js"></script>
	</body>
</html>


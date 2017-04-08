<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>{hotelName}</title>
        <meta name="description" content="{hotelDesc}">
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.4/css/bootstrap.min.css" rel="stylesheet">
        <style type="text/css">
			body.login {
				min-height: 75rem;
				padding-top: 4.5rem;
			}
		</style>
    </head>
    <body class="login">
		<nav class="navbar navbar-toggleable-md navbar-inverse fixed-top bg-inverse">
			<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<a class="navbar-brand" href="#"><img src='{url}/app/tpl/skins/Default/images/icon.ico'></a>
			<div class="collapse navbar-collapse" id="navbarCollapse">
				<form class="form-inline mt-2 mt-md-0" method="post" autocomplete="off">
					<input type="text" name="log_username" class="form-control mr-sm-2" placeholder="Username" />
					<input type="password" name="log_password" class="form-control mr-sm-2" placeholder="Password" />
					<button type="submit" name="login" class="btn btn-primary">Login</button>
				</form>
				<p class="navbar-text navbar-right"><strong>{online} members online</strong></p>
			</div>
		</nav>
		<div class="clearfix"></div>
		<div class="container">
			<div class="row">
				<div class="col-md-4">
					<div class="card text-xs-center">
					  <div class="card-header danger-header">
						Featured
					  </div>
					  <div class="card-block">
						<h4 class="card-title">Special title treatment</h4>
						<p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
						<a href="#" class="btn btn-primary">Go somewhere</a>
					  </div>
					  <div class="card-footer text-muted">
						2 days ago
					  </div>
					</div>
				</div>
				
				<div class="col-md-4">		
					<div class="card text-xs-center">
					  <div class="card-header danger-header">
						Featured
					  </div>
					  <div class="card-block">
						<h4 class="card-title">Special title treatment</h4>
						<p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
						<a href="#" class="btn btn-primary">Go somewhere</a>
					  </div>
					  <div class="card-footer text-muted">
						2 days ago
					  </div>
					</div>
				</div>
				
				<div class="col-md-4">		
					<div class="card text-xs-center">
					  <div class="card-header danger-header">
						Featured
					  </div>
					  <div class="card-block">
						<h4 class="card-title">Special title treatment</h4>
						<p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
						<a href="#" class="btn btn-primary">Go somewhere</a>
					  </div>
					  <div class="card-footer text-muted">
						2 days ago
					  </div>
					</div>
				</div>
			</div>
		</div>

		<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    </body>
</html>
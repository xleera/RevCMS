<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8"/>
		<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1"/>
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>RevolutionCMS - System Error</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="app/tpl/system/css/error.css?123" />
	</head>
	<body>
		<div id="block_error">
			<div class="wrapper">
				<h2>Rev - {who}</h2>
				<p>
				Revolution has encountered a system error and had to stop executing, more information about the error can be viewed below.<br /><br />
				</p>
				<div class="panel panel-default">
				  <div class="panel-heading">{ex.file}:{ex.line}</div>
				  <div class="panel-body">
					<strong>Exception Message:</strong><br />
					<code>
					{ex.message}
					</code>
					<br /><br /><strong>Exception Trace:</strong><br />
					<pre>
					{ex.trace}
					</pre>
				  </div>
				</div>
			</div>
		</div>
		<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	</body>
</html>
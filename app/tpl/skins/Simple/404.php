<?php
/**
 * RevolutionCMS
 *
 * @author	Kryptos
 * @author	GarettM
 * @version	0.0.1
 */

global $template, $core, $engine, $users;
?>
<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8"/>
		<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1"/>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<base href="{hotel.url}" />

		<title>{hotel.name} - 404</title>
		<link rel="stylesheet" type="text/css" href="{hotel.url}/app/tpl/skins/Simple/css/main.css" />
		<meta name="description" content="{hotel.desc}"/>
	</head>
	<body>
		<nav>
			<ul>
				<li onclick="location.href='{hotel.url}/me'">Home</li>
				<li onclick="location.href='{hotel.url}/profile'">{account.username}</li>
                <li onclick="location.href='{hotel.url}/ranking'">Ranking</li>
				<li onclick="location.href='{hotel.url}/team'">Team</li>
                <li onclick="location.href='{hotel.url}/news'">News</li>
				<li onclick="window.open('{hotel.url}/client')">Enter</li>
				<li onclick="location.href='{hotel.url}/logout'">Sign Out</li>
			</ul>
        </nav>
        
        <header>
            <table width="100%">
                <tr>
                    <td width="25%" style="vertical-align: bottom;"><img src="{hotel.url}/app/tpl/skins/Simple/img/logo.png"/></td>
					<td width="50%" rowspan="2">
						<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
						<!-- responsive2 -->
						<ins class="adsbygoogle"
							 style="display:block"
							 data-ad-client="ca-pub-9760911072415608"
							 data-ad-slot="1350769466"
							 data-ad-format="auto"></ins>
						<script>
						(adsbygoogle = window.adsbygoogle || []).push({});
						</script>		
					</td>
					<td width="25%" style="vertical-align: bottom; text-align: right"><a href="{hotel.url}/client" target="_blank" class="btn green">Enter {hotel.name} Hotel</a></td>
				</tr>
                <tr>
                    <td style="vertical-align: top; text-shadow: 0 0 3px #000;">{hotel.desc}</td>
                    <td style="vertical-align: top; text-align: right"><span class="online online_users"><span class="online-count">{hotel.online}</span> online</span></td>
                </tr>
            </table>
        </header>
        
        <main>
			<div class="col col-1 bg">
				<span class="hl blue">{hotel.name} - PAGE NOT FOUND</span>
				<div class="inner">
                    <table width="100%">
                        <tr>
                            <td style="background: url('{hotel.url}/app/tpl/skins/Simple/img/frank_01.gif') center no-repeat; width: 25%; height: 120px;"></td>
                            <td width="50%">Sorry but the page "{hotel.uri}" could not be found :(</td>
                            <td style="background: url('{hotel.url}/app/tpl/skins/Simple/img/error.gif') center no-repeat; width: 25%; height: 120px;"></td>
                        </tr>
                    </table>
                </div>
            </div>
			<div class="col col-1 bg">
				<div class="inner footer">
					<span>Copyright &copy; 2017 <a href="{hotel.url}">{hotel.name}</a>.</span><br>
					<span>Powered by <a href="https://github.com/GarettMcCarty/RevCMS">RevCMS</a>.</span>
				</div>
			</div>
		</main>
		<script src="{hotel.url}/app/tpl/skins/Simple/js/jquery-3.2.1.min.js"></script>
		<script src="{hotel.url}/app/tpl/skins/Simple/js/online.js"></script>
	</body>
</html>
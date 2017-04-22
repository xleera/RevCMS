<!DOCTYPE HTML>
<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
		<title>{hotel.name} - Client</title>

		<script type="text/javascript">
            var andSoItBegins = (new Date()).getTime();
        </script>
		<link rel="stylesheet" type="text/css" href="{hotel.url}/app/tpl/skins/Simple/css/hotel.css">
		<!--link rel="stylesheet" href="https://boon.pw/habboweb/web-gallery/static/styles/common.css" type="text/css"/ -->
		<script type="text/javascript" src="{hotel.url}/app/tpl/skins/Simple/js/flash_detect_min.js"></script>
		<script type="text/javascript" src="{hotel.url}/app/tpl/skins/Simple/js/jquery-3.2.1.min.js"></script>
		<script type="text/javascript" src="{hotel.url}/app/tpl/skins/Simple/js/online.js"></script>
		<script type="text/javascript" src="{hotel.url}/app/tpl/skins/Simple/js/swfobject.js"></script>
		<script type="text/javascript">
            var flashvars = {
                "connection.info.host": "{emu.address}",
                "connection.info.port": "{emu.port}",
                "client.reload.url": "{hotel.url}/me",
                "client.fatal.error.url": "{hotel.url}/disconnect?reason=fatal",
                "client.connection.failed.url": "{hotel.url}/disconnect?reason=connection",
                "logout.url": "{hotel.url}/logout",
                "logout.disconnect.url": "{hotel.url}/disconnect?reason=logout",               
                "url.prefix": "{hotel.url}",
                "client.starting": "Please wait! {hotel.name} is starting up.",
                "has.identity": "1",
                "client.starting.revolving": "For science, you monster\/Loading funny message\u2026please wait.\/Would you like fries with that?\/Follow the yellow duck.\/Time is just an illusion.\/Are we there yet?!\/I like your t-shirt.\/Look left. Look right. Blink twice. Ta da!\/It\'s not you, it\'s me.\/Shhh! I\'m trying to think here.\/Loading pixel universe.",
                "spaweb": "1",
                "client.notify.cross.domain": "0",
                "unique_habbo_id": "hhus-415532",
                "client.allow.cross.domain": "1",
                "nux.lobbies.enabled": "true",
                "flash.client.origin": "popup",
                "processlog.enabled": "1",
                "sso.ticket": "{account.auth_ticket}",
                "account_id": "{account.id}",
                "avatareditor.promohabbos":"https:\/\/www.habbo.com\/api\/public\/lists\/hotlooks",
                "productdata.load.url": "{swf.path}/gamedata/productdata",
                "furnidata.load.url":"{swf.path}/gamedata/furnidata_xml",
                "external.texts.txt":"{swf.path}/gamedata/external_flash_texts",
                "external.variables.txt":"{swf.path}/gamedata/external_variables",
                "external.figurepartlist.txt":"{swf.path}/gamedata/figuredata",
                "external.override.texts.txt":"{swf.path}/gamedata/override/external_flash_override_texts",
                "external.override.variables.txt":"{swf.path}/gamedata/override/external_override_variables",
                "flash.client.url":"{swf.path}/gordon/{swf.build}/",
            };
        </script>
		<script type="text/javascript" src="{hotel.url}/app/tpl/skins/Simple/js/habboapi.js"></script>
		<script type="text/javascript">
            var params = {
                "base" : "{swf.path}/gordon/{swf.build}/",
                "allowScriptAccess" : "always",
                "menu" : "false",
                "wmode": "opaque"
            };
            swfobject.embedSWF('{swf.path}/gordon/{swf.build}/Habbo.swf', 'flash-container', '100%', '100%', '11.1.0', '{swf.path}/gordon/{swf.build}/expressInstall.swf', flashvars, params, null, null);
        </script>
	</head>
	<body id="client" class="flashclient">
		<h6 style="z-index: 8; width: 200px; line-height: 20px; height: 20px; font-family: Arial, sans-serif; border-radius: 0 0 5px 5px; margin: 0 auto; left: 50%; right: 50%; background: rgba(28, 28, 26, 0.75); text-align: center; color: #fff; position: fixed; top: 0; font-weight: bold; border: 2px solid rgba(65, 64, 61, 0.75); border-top: 0;">
			<span class="online_users"><span id="reload_users" class="reload_users online-count">{hotel.online}</span> {hotel.name}'s online</span>
		</h6>
		<div id="client-ui">
			<div id="flash-wrapper">
				<div id="flash-container">
					<div id="content" style="width: 400px; margin: 20px auto 0 auto; display: none">
						<h2>Flash Disabled/Not Installed</h2>
						<div class="box-content">
							<p>You must enable/install Flash to play {hotel.name}.<br><a href="{hotel.url}/help/flash-player">Click here to find out how to do this</a>.</p>
						</div>
					</div>
					<script type="text/javascript">
						$('#content').show();
					</script>
				</div>
			</div>
			<div id="content" class="client-content"></div>
		</div>
	</body>
</html>
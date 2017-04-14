<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8">
        <title>{hotelName} - Client</title>
        <link rel="stylesheet" href="{url}/app/tpl/skins/Simple/client/client.css" type="text/css">
        <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
		<script src="{url}/app/tpl/skins/Simple/js/online.js"></script>
		<script type="text/javascript" src="{url}/app/tpl/skins/Simple/client/habboflashclient.js"></script>
        <script type="text/javascript">
            var BaseUrl = "{client.swf_folder}";
            var flashvars =
            {
                "client.starting" : "Please wait, {hotelName} is loading...",
                "client.allow.cross.domain" : "1",
                "client.notify.cross.domain" : "0",
                "connection.info.host" : "{server.address}",
                "connection.info.port" : "{server.port}",
                "site.url" : "{url}",
                "url.prefix" : "{url}",
                "client.reload.url" : "{url}/client",
                "client.fatal.error.url" : "{url}/client",
                "client.connection.failed.url" : "{url}/client",
                "external.variables.txt" : "{client.swf_folder}/gamedata/external_variables.txt",
                "external.texts.txt" : "{client.swf_folder}/gamedata/external_flash_texts.txt",
                "productdata.load.url" : "{client.swf_folder}/gamedata/productdata.txt",
                "furnidata.load.url" : "{client.swf_folder}/gamedata/furnidata.xml",
                "use.sso.ticket" : "1",
                "sso.ticket" : "{sso}",
                "processlog.enabled" : "0",
                "flash.client.url" : "{client.swf_folder}",
                "flash.client.origin" : "popup",
                "nux.lobbies.enabled" : "true"
            };
            var params =
            {
                "base" : BaseUrl + "/",
                "allowScriptAccess" : "always",
                "menu" : "false"
            };
            swfobject.embedSWF(BaseUrl + "/gordon/{client.build}/Habbo.swf", "client", "100%", "100%", "10.0.0", "{client.swf_folder}/gordon/{client.build}/expressInstall.swf", flashvars, params, null);
        </script>
    </head>
    <body>
		<h6 style="width: 200px; line-height: 20px; height: 20px; font-family: Arial, sans-serif; border-radius: 0 0 5px 5px; margin: 0 auto; background: rgba(28, 28, 26, 0.75); text-align: center; color: #fff; position: fixed; top: 0; font-weight: bold; border: 2px solid rgba(65, 64, 61, 0.75); border-top: 0;">
            <span class="online_users"><span id="reload_users" class="reload_users online-count">{online}</span> {hotelName}'s online</span>
        </h6>
        <div id="client"></div>
    </body>
</html>

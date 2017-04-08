<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>{hotelName} - {username}</title>
        <meta name="description" content="{hotelDesc}">
        <link rel="stylesheet" href="{url}/app/tpl/skins/Default/stylesheets/reset.css">
        <link rel="stylesheet" href="{url}/app/tpl/skins/Default/stylesheets/content.css">
    </head>
    <body>
         <div id="wrapper">
             <div id="header">
                <div class="logo"></div>
                <div id="navigation">
                    <ul class="menu">
                        <li>
                            <a href="{url}/me">{username}</a>
                        </li>
                        <li>
                            <a href="{url}/community">Community</a>
                        </li>
                        <li>
                            <a href="{url}/news">News</a>
                        </li>
                        <li class="pull-right">
                            <a href="{url}/client">Play Now</a>
                        </li>
                    </ul>
                </div>
             </div>
             <div id="navigation-bottom">
                <ul class="menu">
                    <li>
                        <a href="/me">Home</a>
                    </li>
                    <li>
                        <a href="/me">My Page</a>
                    </li>
                    <li>
                        <a href="/me">Account Settings</a>
                    </li>
					<li class="pull-right">
						<a href="{url}/logout">Logout</a>
					</li>
                </ul>
             </div>
             <!-- the content -->
             <div id="content">
               <!-- Me Stats -->
                 <section class="me_stats">
                     <div class="me_avatar">
                        <img src="http://www.habbo.nl/habbo-imaging/avatarimage?hb=img&user=Crowley&direction=3&head_direction=2" />
                     </div>
                 </section>
             </div>
             <!-- the footer -->
             <div id="footer">
                <p>2014 &copy; {hotelName}, Powered By <i>RevCMS</i>.</p>
                <p>Skin Designed by <b>Mega</b>.</p>
             </div>
        </div>
    </body>
</html>
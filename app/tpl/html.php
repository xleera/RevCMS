<?php
/**
 * RevolutionCMS
 *
 * @author	Kryptos
 * @author	GarettM
 * @version	0.0.1
 */
 
namespace Revolution\App\Tpl;
use Revolution\App\System\Core;

class Html
{
	protected $content;
	
	public function get($fileName)
	{
		$file = sprintf('%s/skins/%s/%s.php', dirname(__FILE__), Core::getHotelTheme(), $fileName);
		
		if(file_exists($file))
		{
			ob_start();
			require ($file);
			$this->content = ob_get_contents();
			ob_end_clean();
		}
		else {
			$_SESSION['last_uri'] = $fileName;
			$this->get('404');
		}
	}
	
	public function getContent()
	{
		return $this->content;
	}
}
<?php
/**
 * RevolutionCMS
 *
 * @author	Kryptos
 * @author	GarettM
 * @version	0.8.1
 */
 
namespace Revolution\app\tpl;
use Revolution\app\core;

class html
{
	protected $content;
	
	public function get($fileName)
	{
		$core = core::getInstance();
		$file = sprintf('%s/skins/%s/%s.php', dirname(__FILE__), $core->getHotelTheme(), $fileName);
		
		if(file_exists($file))
		{
			ob_start();
			require ($file);
			$this->content = ob_get_contents();
			ob_end_clean();
		}
		else {
			$_SESSION['last_uri'] = $fileName;
			echo 'File ' . $file . ' does not exist.';
			//$this->get('404');
		}
	}
	
	public function getContent()
	{
		return $this->content;
	}
}
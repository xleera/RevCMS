<?php
/**
 * RevolutionCMS
 * 
 * @author	Kryptos
 * @author	GarettM
 * @version 0.8.1
 */
 
namespace Revolution\App\Tpl;
use Revolution\App\System\Core;

class Js
{
	/**
	 * @var string[]
	 */
	protected $scripts = array();
	
	public function all()
	{
		$content = '';
		foreach($this->scripts as $script)
		{
			if($script['external'] == true)
			{
				$content .= sprintf('<script src="%s"></script>', $script['src']);
			} else {
				$content .= sprintf('<script src="%s/app/tpl/skins/%s/js/%s"></script>', Core::getHotelUrl(), Core::getHotelTheme(), $script['src']);
			}
			$content .= PHP_EOL;
		}
	}
	
	public function add($src, $external = false)
	{
		$this->scripts[] = array('src' => $src, 'external' => $external);
	}
}
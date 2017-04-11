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

class Css
{
	/**
	 * @var string[]
	 */
	protected $sources = array();
	
	public function all()
	{
		$content = '';
		foreach($this->sources as $src)
		{
			if($src['external'] == true)
			{
				$content .= sprintf('<link rel="stylesheet" type="text/css" href="%s"/>', $src['src']);
			} else {
				$content .= sprintf('<link rel="stylesheet" type="text/css" href="%s/app/tpl/skins/%s/js/%s" />', Core::getHotelUrl(), Core::getHotelTheme(), $src['src']);
			}
			$content .= PHP_EOL;
		}
	}
	
	public function add($src, $external = false)
	{
		$this->sources[] = array('src' => $src, 'external' => $external);
	}
}
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

class css
{
	/**
	 * @var string[]
	 */
	protected $sources = array();
	
	public function all()
	{
		$core = core::getInstance();
		
		$content = '';
		foreach($this->sources as $src)
		{
			if($src['external'] == true)
			{
				$content .= sprintf('<link rel="stylesheet" type="text/css" href="%s"/>', $src['src']);
			} else {
				$content .= sprintf('<link rel="stylesheet" type="text/css" href="%s/app/tpl/skins/%s/js/%s" />', $core->getHotelUrl(), $core->getHotelTheme(), $src['src']);
			}
			$content .= PHP_EOL;
		}
	}
	
	public function add($src, $external = false)
	{
		$this->sources[] = array('src' => $src, 'external' => $external);
	}
}
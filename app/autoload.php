<?php
/**
 * RevolutionCMS
 * 
 * @author	Kryptos
 * @author	GarettM
 * @version 0.8.1
 */
 
namespace Revolution\App;

/**
 * Simple Autoloader
 */
class Autoload
{
	/**
	 * @var string 
	 */
	protected $path;
	
	public function __construct($path)
	{
		$this->path = $this->strip($path);
	}
	
	/**
	 * Trim slashes
	 * @param string $path
	 * @return string
	 */
	private function strip($path)
	{
		return trim($path, ' /\\');
	}
	
	/**
	 * @param string $className
	 * @return bool|string 
	 */
	public function __invoke($className)
	{	
		if (strncmp('Revolution\\', $className, 11) !== 0)
			return;
		
		$fileName = sprintf('%s/%s.php', $this->path, strtolower(str_replace('\\', '/', substr($className, 11))));
		
		if(file_exists($fileName))
		{
			require ($fileName);
			return $fileName;
		}
		
		return false;
	}
}
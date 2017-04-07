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
use Revolution\app\engine;

class form
{
	/**
	 * @var string
	 */
	protected $error;
	
	/**
	 * @var array
	 */
	protected $data = array();
	
	/**
	 * Set form data
	 */
	public function setData()
	{
		$engine = engine::getInstance();
		$core   = core::getInstance();
		
		unset($this->error);
		foreach($_POST as $key => $value)
		{
			$this->data[$key] = $core->secure($value) ?: null;
		}
	}
	
	/**
	 * Check if form data exists
	 * @param string $key 
	 * @return bool
	 */
	public function assert($key)
	{
		if(array_key_exists($key, $this->data) && !is_null($this->data[$key]))
			return true;
		return false;
	}
	
	/**
	 * Get form data
	 * @param string $key 
	 * @return mixed
	 */
	public function input($key)
	{
		if($this->assert($key))
			return $this->data[$key];
		
		return null;
	}
	
	/**
	 * Set error message
	 * @param string $error
	 */
	public function error($error)
	{
		$this->error = $error;
	}
	
	/**
	 * Check if error is set
	 * @return bool
	 */
	public function isError()
	{
		return isset($this->error) ? true : false;
	}
	
	/**
	 * Display error message 
	 * @return string
	 */
	public function outputError($id = 'message', $class = '')
	{
		if(isset($this->error))
			echo sprintf('<div id="%s" class="%s">%s</div>', $id, $class, $this->error);
	}
}
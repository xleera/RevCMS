<?php
/**
 * RevolutionCMS
 *
 * @author	Kryptos
 * @author	GarettM
 * @version	0.0.1
 */
 
namespace Revolution\App\Tpl;

class Form
{
	/**
	 * @var string
	 */
	protected $error = false;
	
	/**
	 * @var array
	 */
	protected $data = array();
	
	/**
	 * Set form data
	 */
	public function setData()
	{
		$this->error = false;
		
		$this->data = array_merge($_GET, $_POST);
		$this->data = array_map('\Revolution\App\System\Core::secure', $this->data);
	}
	
	/**
	 * Check if form data exists
	 * @param string $key 
	 * @return bool
	 */
	public function isset($key)
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
		if($this->isset($key))
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
		return is_string($this->error) && strlen($this->error) > 0 ? true : false;
	}
	
	/**
	 * Get error message
	 * @return string
	 */
	public function getError()
	{
		return $this->error;
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
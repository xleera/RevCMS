<?php
/**
 * RevolutionCMS
 *
 * @author	Kryptos
 * @author	GarettM
 * @version	0.0.1
 */
 
namespace Revolution\App\System;
use PDO;
use PDOException;
use Exception;

class Engine
{
	/**
	 * @var self
	 */
	protected static $instance = null;
	
	/**
	 * Get instance of self
	 * @return &self
	 */
	public static function &getInstance()
	{
		if(!self::$instance instanceof self)
			self::$instance = new self();
		
		return self::$instance;
	}
	
	/**
	 * @var PDO
	 */
	protected $pdo;
	
	/**
	 * @var PDOStatement
	 */
	protected $statement;
	
	/**
	 * @var array
	 */
	protected $params = array();
	
	/**
	 * @var string
	 */
	protected $debug;
	
	public function __construct()
	{
		/**
		 * Only Connect to database if a configuration file exists.
		 */
		if(Core::configExist()) {
			require (dirname(__FILE__) . '/../management/config.php');
			
			if(!$this->pdo instanceof PDO)
				$this->create($_CONFIG['mysql']['hostname'], $_CONFIG['mysql']['username'], $_CONFIG['mysql']['password'], $_CONFIG['mysql']['database']);
		}
	}
	
	/**
	 * Test a database connection
	 * @param string $hostname
	 * @param string $username
	 * @param string $password
	 * @param string $database
	 * @param array $options
	 * @return bool
	 */
	public static function test($hostname, $username, $password, $database, $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION))
	{
		try {
			$dns = sprintf('mysql:host=%s;dbname=%s', $hostname, $database);
			$pdo = new PDO($dns, $username, $password, $options);
		} catch(PDOException $ex) {
			return false;
		}
		
		return true;
	}
	
	/**
	 * Create a new database object
	 * @param string $hostname
	 * @param string $username
	 * @param string $password
	 * @param string $database
	 * @param array $options
	 * @return bool
	 */
	public function create($hostname, $username, $password, $database, $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION))
	{
		try {
			$dns = sprintf('mysql:host=%s;dbname=%s', $hostname, $database);
			$this->pdo = new PDO($dns, $username, $password, $options);
		} catch(PDOException $ex) {
			Core::systemError('Engine', $ex);
		}
		
		return true;
	}
	
	/**
	 * Execute and fetch results from database
	 * @param string $query
	 * @param array $params
	 * @return array|bool
	 */
	public function query($query, array $params = array())
	{
		$this->statement = $this->pdo->prepare($query);
		$this->params = $params;
		
		foreach ((array)$params as $key => $value)	
			$this->statement->bindValue($this->toParamKey($key), $value);
		
		if($this->statement->execute())
			return $this->statement->fetchAll(PDO::FETCH_ASSOC);
		
		return false;
	}
	
	/**
	 * Execute a query on the database
	 * @param string $query
	 * @param array $params 
	 */
	public function execute($query, array $params = array())
	{
		$this->statement = $this->pdo->prepare($query);
		$this->params = $params;
		
		foreach ((array)$params as $key => $value)	
			$this->statement->bindValue($this->toParamKey($key), $value);
		
		$this->statement->execute();
	}
	
	/**
	 * Get the executed query
	 * @param bool $set
	 * @return string
	 */
	public function debug($set = false)
	{
		if($set)
		{
			ob_start();
			$this->statement->debugDumpParams();
			$this->debug = ob_get_contents();
			ob_end_clean();
		}
		else {
			return $this->debug;
		}
	}
	
	/**
	 * Get the statement parameters
	 * @return array
	 */
	public function getParams()
	{
		return $this->params;
	}
	
	/**
	 * Fetch results from database
	 * @param int? $mode
	 * @return mixed|false
	 */
	public function fetch($mode = PDO::FETCH_NUM)
	{
		$result = $this->statement->fetch($mode);
		
		if(is_array($result))
			$result = array_shift($result);
		
		return $result;
	}
	
	/**
	 * Fetch ALL results from database
	 * @param int? $mode
	 * @return array|false
	 */
	public function fetchAll($mode = PDO::FETCH_ASSOC)
	{
		return $this->statement->fetchAll($mode);
	}
	
	/**
	 * Select values from database table
	 * @param string $table
	 * @param array $conditions
	 * @param string[] $fields
	 * @param array $order
	 * @param int $limit
	 * @param int $offset
	 */
	public function select($table, $conditions = array(), $fields = array('*'), $order = array(), $limit = null, $offset = null)
	{
		if(is_array($fields) && !empty($fields)) {
			$fields = ltrim(implode(',', $fields), ',');
		}
		
		$query = sprintf('SELECT %s FROM %s', $fields, $table);
		
		if(!empty($conditions))
		{
			$query .= ' WHERE ';
			
			$i = 0;
			foreach($conditions as $key => $value)
			{
				if($i != 0)
					$query .= ' AND ';
				
				$query .= sprintf('%s=%s', $key, $this->toParamKey($key));
				$i++;
			}
		}
		
		if(!empty($order))
		{
			$query .= ' ORDER BY';
			
			$x = 0;
			foreach($order as $column => $value)
			{
				if($x != 0)
					$query .= ', ';
				
				$query .= sprintf(' %s %s', $column, $value);
				$x++;
			}
		}
		
		if(!is_null($limit))
			$query .= ' LIMIT ' . $limit;
		
		if(!is_null($offset))
			$query .= ' OFFSET ' . $offset;
		
		$this->execute($query, $conditions);
		return $this;
	}
	
	/**
	 * Insert data into a database table
	 * @param string $table
	 * @param array $data
	 * @return int
	 */
	public function insert($table, array $data = array())
	{
		$values = array_map(array($this, 'quote'), array_values($data));
		$query = sprintf('INSERT INTO %s (%s) VALUES (%s)', $table, ltrim(implode(', ', array_keys($data)), ', '), ltrim(implode(', ', $values), ', '));

		$this->execute($query);
		return $this->getInsertId();
	}
	
	/**
	 * Update data into a database table
	 * @param string $table
	 * @param array $data
	 * @param $conditions
	 */
	public function update($table, array $data = array(), $conditions = array())
	{
		$i = 0;
		$vars = '';
		foreach($data as $key => $value)
		{
			if($i != 0)
				$vars .= ', ';
			
			$vars .= sprintf('%s = %s', $key, $this->toParamKey($key));
			$i++;
		}
		
		$where = '';
		if(!empty($conditions))
		{
			$where .= 'WHERE ';
			
			$i = 0;
			foreach($conditions as $key => $value)
			{
				if($i != 0)
					$where .= ' AND ';
				
				$where .= sprintf('%s=%s', $key, $this->quote($value));
				$i++;
			}
		}
		
		$query = sprintf('UPDATE %s SET %s %s', $table, $vars, $where);
		$this->execute($query, $data);
		return $this->getAffectedRows();
	}
	
	/**
	 * Delete records from database
	 * @param string $table
	 * @param array $conditions
	 */
	public function delete($table, array $conditions)
	{
		$query = sprintf('DELETE FROM %s WHERE ', $table);
		
		$i = 0;
		foreach($conditions as $key => $value)
		{
			if($i != 0)
				$query .= ' AND ';
			$query .= sprintf('%s = %s', $key, $this->toParam($key));
			$i++;
		}
		
		$this->execute($query, $conditions);
		return $this->getAffectedRows();
	}
	
	/**
	 * Get last inserted id
	 * @return int
	 */
	public function getInsertId()
	{
		return $this->pdo->lastInsertId();
	}
	
	/**
	 * Get execution returned rows count
	 * @return int
	 */
	public function countRows()
	{
		return $this->statement->rowCount();
	}
	
	/**
	 * Get affected rows
	 * @return int
	 */
	public function getAffectedRows()
	{
		return $this->statement->rowCount();
	}
	
	/**
	 * Convert a parameter key to :key and quote
	 * @param string $value
	 * @return string
	 */
	public function toParam($value)
	{
		return $this->quote(sprintf(':%s', $value));
	}
	
	/**
	 * Convert a parameter key to :key
	 * @param string $key
	 * @return string
	 */
	public function toParamKey($key)
	{
		return sprintf(':%s', $key);
	}
	
	/**
	 * Quote a string
	 * @param string $value
	 * @return string
	 */
	public function quote($value)
	{
		return sprintf("'%s'", $value);
	}
	
	/**
	 * Destroy the database object
	 */
	public function __destruct()
	{
		$this->pdo = null;
	}
}
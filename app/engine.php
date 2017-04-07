<?php
/**
 * RevolutionCMS
 *
 * @author	Kryptos
 * @author	GarettM
 * @version	0.8.1
 */
 
namespace Revolution\app;
use PDO;
use PDOException;

class engine
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
			self::$instance = new self;
		
		return self::$instance;
	}
	
	/**
	 * Default Functions
	 */
	protected $pdo;
	protected $statement;
	
	public function __construct()
	{
		global $_CONFIG;
		if(!$this->pdo instanceof PDO)
		{
			try {
				$this->pdo = new PDO(sprintf('mysql:dbname=%s;host=%s', $_CONFIG['mysql']['database'], $_CONFIG['mysql']['hostname']), $_CONFIG['mysql']['username'], $_CONFIG['mysql']['password'], array(
					PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
					PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
					PDO::ATTR_EMULATE_PREPARES => FALSE
				));
			} catch(PDOException $ex) {
				core::systemError('Engine', $ex);
			}
		}
	}
	
	/**
	 * Disconnect from the database.
	 */
	public function __destruct()
	{
		$this->pdo = null;
	}
	
	/**
	 * Execute and fetch results from database.
	 *
	 * @param string $query
	 * @param array $params
	 * @return mixed
	 */
	public function query($query, array $params = array())
	{
		$statement = $this->pdo->prepare($query);
		
		foreach((array)$params as $key => $value)
		{
			$statement->bindValue($key, $value);
		}
		
		$statement->execute();
		
		return $statement->fetchAll(PDO::FETCH_ASSOC);
	}
	
	/**
	 * Execute a query on the database
	 *
	 * @param string $query
	 * @param array $params 
	 */
	public function execute($query, array $params = array())
	{
		$this->statement = $this->pdo->prepare($query);
		
		foreach($params as $key => $value)
		{
			if(is_array($value))
				$value = array_shift($value);
			
			$this->statement->bindValue(":{$key}", $value);
		}
		
		$this->statement->execute();
	}
	
	/**
	 * Fetch results from database.
	 * 
	 * @param int? $mode
	 * @return array
	 */
	public function fetch($mode = PDO::FETCH_ASSOC)
	{
		return $this->statement->fetch($mode);
	}
	
	/**
	 * Fetch ALL results from database
	 * 
	 * @param int? $mode
	 * @return array
	 */
	public function fetchAll($mode = PDO::FETCH_ASSOC)
	{
		return $this->statement->fetchAll($mode);
	}
	
	/**
	 * Select values from database table.
	 * 
	 * @param string $table
	 * @param array $conditions
	 * @param string[] $fields
	 * @param array $order
	 * @param int $limit
	 * @param int $offset
	 */
	public function select($table, $conditions = array(), $fields = array(), $order = array(), $limit = null, $offset = null)
	{
		if(is_array($fields) && !empty($fields))
			$fields = ltrim(implode(',', $fields), ',');
		
		$query  = 'SELECT ' . $fields . ' FROM ' . $table;
		
		if(!empty($conditions))
		{
			$query .= ' WHERE ';
			
			$i = 0;
			foreach($conditions as $key => $value)
			{
				if($i != 0)
					$query .= ' AND ';
				
				$query .= "{$key} = :{$key}";
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
				
				$query .= "{$column} {$value}";
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
	 * Insert data into a database table.
	 *
	 * @param string $table
	 * @param array $data
	 * @return int
	 */
	public function insert($table, array $data = array())
	{
		$values = array_map(array($this, 'qoute'), array_values($data));
		
		$query = sprintf(
			'INSERT INTO %s (%s) VALUES (%s)', 
			$table, 
			ltrim(implode(', ', array_keys($data)), ', '),
			ltrim(
				implode(', ', $values),
			', ')
		);

		$this->execute($query);
		
		return $this->getInsertId();
	}
	
	/**
	 * Update data into a database table
	 *
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
			
			$vars .= "{$key} = :{$key}";
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
				$where .= "{$key}={$value}";
				$i++;
			}
		}
		
		$query = sprintf('UPDATE %s SET %s %s', $table, $vars, $where);
		$this->execute($query, $data);
		
		return $this->getAffectedRows();
	}
	
	/**
	 * Delete records from database.
	 * 
	 * @param string $table
	 * @param array $conditions
	 */
	public function delete($table, array $conditions)
	{
		$query = 'DELETE FROM ' . $table . ' WHERE ';
		
		$i = 0;
		foreach($conditions as $key => $value)
		{
			if($i != 0)
				$query .= ' AND ';
			$query .= "{$key} = :{$key}";
			$i++;
		}
		
		$this->execute($query, $conditions);
		return $this->getAffectedRows();
	}
	
	/**
	 * Get last inserted id.
	 * 
	 * @return int
	 */
	public function getInsertId()
	{
		return $this->pdo->lastInsertId();
	}
	
	/**
	 * Get execution returned rows count.
	 *
	 * @return int
	 */
	public function countRows()
	{
		return $this->statement->rowCount();
	}
	
	/**
	 * Get affected rows.
	 *
	 * @return int
	 */
	public function getAffectedRows()
	{
		return $this->statement->rowCount();
	}
	
	/**
	 * Convert a parameter key to :key and qoute.
	 * 
	 * @param string $value
	 * @return string
	 */
	public function toParam($value)
	{
		return "':${value}'";
	}
	
	public function qoute($value)
	{
		return "'${value}'";
	}
}
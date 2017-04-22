<?php
/**
 * RevolutionCMS
 * 
 * @author	Kryptos
 * @author	GarettM
 * @version 0.8.1
 */
 
namespace Revolution\App\System;
use PDO;

class Users
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
	 * @var \Revolution\App\System\Engine
	 */
	protected $engine = null;
	
	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->engine = Engine::getInstance();
	}
	
	/**
	 * Check if an account is logged in.
	 * @return bool
	 */
	public function isLogged()
	{
		if(isset($_SESSION['account'], $_SESSION['account']['id']))
			return true;
		return false;
	}
	
	/**
	 * Check if username is valid
	 * @param string $username
	 * @return bool
	 */
	public function validName($username)
	{
		return (strlen($username) <= 25 && ctype_alnum($username)) ? true : false;
	}
	
	/**
	 * Check if email is valid
	 * @param string $email
	 * @return bool
	 */
	public function validEmail($email)
	{
		return filter_var($email, FILTER_VALIDATE_EMAIL) ? true : false;
	}
	
	/**
	 * Check if a username is taken
	 * @param string $username
	 * @return bool
	 */
	public function nameTaken($username)
	{
		$this->engine->execute('SELECT * FROM users WHERE username = :username', array('username' => $username));
		return ($this->engine->countRows() > 0) ? true : false;
	}
	
	/** 
	 * Check if a email is taken
	 * @param string $email
	 * @return bool
	 */
	public function emailTaken($email)
	{
		$this->engine->execute('SELECT * FROM users WHERE mail = :mail', array('mail' => $email));
		return ($this->engine->countRows() > 0) ? true : false;
	}
	
	/**
	 * Validate user account
	 * @param string $username
	 * @param string $password 
	 * @return bool
	 */
	public function userValidation($username, $password)
	{
		$hash = $this->engine->select('users', array('username' => $username), 'password')->fetch();
		return password_verify($password, $hash) ? true : false;
	}
	
	/**
	 * Check if account is banned
	 * @param string $user - The username or email.
	 * @return bool
	 */
	public function isBanned($user)
	{
		$this->engine->execute('SELECT * FROM users WHERE (username = :username OR mail = :email)', array('username' => $user, 'email' => $user)); 
		return ($this->engine->countRows() > 0) ? true : false;
	}
	
	/**
	 * Register an account
	 * @param bool $redirect
	 * @param bool $authenticate
	 */
	public function register($redirect = true, $authenticate = true)
	{
		$template = Template::getInstance();
		$core     = Core::getInstance();
		
		$template->form->setData();
		
		if(!is_null($template->form->input('register')))
		{
			if(!$this->validName($template->form->input('reg_username')))
			{
				$template->form->error('The username is not valid.');
				return;
			}
			
			if($this->nameTaken($template->form->input('reg_username')))
			{
				$template->form->error('The username is taken.');
				return;
			}
			
			//if(!$this->validEmail($template->form->input('reg_email')))
			//{
			//	$template->form->error('The email is not valid.');
			//	return;
			//}
			
			if($this->emailTaken($template->form->input('reg_email')))
			{
				$template->form->error('The email is taken.');
				return;
			}
			
			if(strlen($template->form->input('reg_password')) < 4)
			{
				$template->form->error('The password is to short.');
				return;
			}
			
			if($template->form->input('reg_password') !== $template->form->input('reg_rep_password'))
			{
				$template->form->error('The passwords don\'t match.');
				return;
			}
			
			$gender = $template->form->isset('reg_gender') ? $template->form->input('reg_gender') : 'M';
			
			$credits = $core->cms_settings('default_credits', 5000);
			$pixels  = $core->cms_settings('default_pixels', 10000);
			$motto	 = $core->cms_settings('default_motto', 'I <3 RevCMS');
			$figure	 = $core->cms_settings('default_looks', '-');
			$ip = isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
			
			$id = $this->engine->insert('users', array(
				// Username
				'username'	=> $template->form->input('reg_username'),
				// Password
				'password'	=> $core::hash($template->form->input('reg_password')),
				// Email
				'mail' 		=> $template->form->input('reg_email'),
				// Motto
				'motto' 	=> $motto,
				// Rank
				'rank' 		=> 1,
				// Figure
				'look' 		=> $figure,
				// Gender
				'gender' 	=> $gender,
				// IP Last
				'ip_last' 	=> $ip,
				// IP Regular
				'ip_reg' 	=> $ip,
				// Auth Ticket
				'auth_ticket' => '',
				// Credits
				'credits' 	=> $credits,
				// Pixels
				'activity_points' => $pixels
			));
			
			if(!$id)
				$template->form->error('Couldn\'t insert record into database');
			
			if($authenticate)
				$this->authenticate($id);
			
			if($redirect)
				$core->redirect('/me');
		}
	}
	
	/**
	 * Login an account
	 */
	public function login($redirect = true)
	{
		$template = Template::getInstance();
		$engine   = Engine::getInstance();
		$core 	  = Core::getInstance();
		
		$template->form->setData();
		
		if(!is_null($template->form->input('log_username')))
		{
			if(!$this->nameTaken($template->form->input('log_username')))
			{
				$template->form->error('Invalid credentials.');
				return;
			}
			
			if(!$this->userValidation($template->form->input('log_username'), $template->form->input('log_password')))
			{
				$template->form->error('Invalid credentials.');
				return;
			}
			
			$this->authenticate($engine->select('users', array('username' => $template->form->input('log_username')), 'id')->fetch());
			$ip = isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
			$this->updateUser($_SESSION['account']['id'], 'ip_last', $ip);
			
			if($redirect)
				$core->redirect('/me');
		}
	}
	
	/**
	 * Check if is staff member
	 * @param string $user - Username or Email
	 * @return bool
	 */
	public function isStaffMember($user)
	{
		if(is_null($user))
			return false;
		
		$result = $this->engine->query('SELECT rank FROM users WHERE (username = :uname OR mail = :umail) LIMIT 1', array('uname' => $user, 'umail' => $user));
		
		if(!$result)
			return false;
		
		return ($result[0]['rank'] > 2) ? true : false;
	}

	/**
	 * Authenticate an user by id
	 * @param string $id
	 */
	public function authenticate($id)
	{
		$data = $this->engine->select('users', array('id' => $id))->fetchAll();
		$data = $data[0];
		unset($data['password']);
		
		$data['auth_ticket'] = $ticket = password_hash(sprintf('RevTicket-%d-%s', $data['id'], session_id()), PASSWORD_BCRYPT, array('cost' => 12));
		
		$_SESSION['account'] = array();
		foreach($data as $key => $value)
			$_SESSION['account'][$key] = $value;
		
		$this->updateUser($data['id'], 'auth_ticket', $ticket);
	}
	
	/**
	 * Update account information 
	 */
	public function updateAccount()
	{
		$template = Template::getInstance();
		$core     = Core::getInstance();
		
		$template->form->setData();
		
		if(!is_null($template->form->input('account')))
		{
			$updated = false;
			
			/**
			 * Update Account Motto
			 */
			if($template->form->isset('acc_motto') && $template->form->input('acc_motto') != $this->getInfo($_SESSION['account']['id'], 'motto'))
			{
				$this->updateUser($_SESSION['account']['id'], 'motto', $template->form->input('acc_motto'));
				$updated = true;
			}
			
			/**
			 * Update Account Email 
			 */
			if($template->form->isset('acc_email') && $template->form->input('acc_email') != $this->getInfo($_SESSION['account']['id'], 'mail'))
			{
				if($this->validEmail($template->form->input('acc_email')))
				{
					$template->form->error('The email is not valid.');
					return;
				}
				
				$this->updateUser($_SESSION['account']['id'], 'mail', $template->form->input('acc_email'));
				$updated = true;
			}
			
			/**
			 * Update Account Password
			 *
			 * The only way i can tell if password has changed from there previous password is try to validate it with the hash, it should fail.
			 */
			if($template->form->isset('acc_old_password') && $template->form->isset('acc_new_password') && !$this->userValidation($_SESSION['account']['username'], $template->form->input('acc_new_password')))
			{
				if($template->form->input('acc_new_password') !== $template->form->input('acc_new_rep_password'))
				{
					$template->form->error('The passwords don\'t match.');
					return;
				}
				
				if(strlen($template->form->input('acc_new_password')) < 5)
				{
					$template->form->error('The password is too short.');
					return;
				}
				
				$this->updateUser($_SESSION['account']['id'], 'password', $core::hash($template->form->input('acc_new_password')));
				$updated = true;
			}
			
			if($updated)
			{
				$core->redirect('/me');
			}
		}
	}
	
	/**
	 * Update user information
	 * @param int $id 
	 * @param string $key 
	 * @param string $value
	 */
	public function updateUser($id, $key, $value)
	{	
		$this->engine->update('users', array($key => $value), array('id' => $id));
		
		if($_SESSION['account']['id'] == $id)
		{
			$_SESSION['account'][$key] = $value;
		}
	}
	
	/**
	 * Get user information
	 * @param int $id
	 * @param string $key 
	 * @return mixed
	 */
	public function getInfo($id, $key)
	{
		$result = $this->engine->select('users', array('id' => $id), $key, array(), 1)->fetch();
		
		if($_SESSION['account']['id'] == $id)
		{
			$_SESSION['account'][$key] = $result;
		}
		
		return $result;
	}
	
	/**
	 * Get id by username
	 * @param string $username
	 * @return int
	 */
	public function getID($username)
	{
		$id = $this->engine->select('users', array('username' => $username), 'id', array(), 1)->fetch();
		return !is_null($id) ? (int)$id : 0;
	}
	
	/**
	 * Get username by id or email
	 * @param int id|string
	 * @return string 
	 */
	public function getUsername($id)
	{
		if(is_int($id))
			$result = $this->engine->select('users', array('id' => $id), 'username', array(), 1)->fetch();
		else
			$this->engine->select('users', array('mail' => $id), 'username', array(), 1)->fetch();
		
		return $result;
	}
}

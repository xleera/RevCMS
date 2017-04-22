<?php
/**
 * RevolutionCMS
 * 
 * @author	Kryptos
 * @author	GarettM
 * @version 0.8.1
 */
 
namespace Revolution\App\System;
use Revolution\App\Tpl\Form as tpl_form;
use Revolution\App\Tpl\Html as tpl_html;
use Revolution\App\Tpl\Css	as tpl_css;
use Revolution\App\Tpl\Js 	as tpl_js;

class Template
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
	 * @var tpl\form
	 */
	public $form;
	
	/**
	 * @var tpl\html 
	 */
	public $html;
	
	/**
	 * @var tpl\css
	 */
	public $css;
	
	/**
	 * @var tpl\js
	 */
	public $js;
	
	/**
	 * @var string
	 */
	protected $content;
	
	/**
	 * @var array
	 */
	protected $params = array();
	
	/**
	 * Template Constructor
	 */
	public function __construct()
	{
		$this->form = new tpl_form;
		$this->html = new tpl_html;
		$this->css	= new tpl_css;
		$this->js	= new tpl_js;
		
		$engine = Engine::getInstance();
		$users	= Users::getInstance();
		$core   = Core::getInstance();
		
		$this->setParams('hotel.name',			$core::getHotelName());
		$this->setParams('hotel.desc',			$core::getHotelDescription());
		$this->setParams('hotel.url',			$core::getHotelUrl());
		$this->setParams('hotel.online',		$core::getOnlineCount());
		$this->setParams('hotel.registered',	$core::getRegisteredCount());
		$this->setParams('hotel.uri',			isset($_GET['url']) ? $core::secure($_GET['url']) : '');
		
		$this->setParams('emu.address',			$core::getEmulatorAddress());
		$this->setParams('emu.port',			$core::getEmulatorPort());
		
		$this->setParams('swf.build',			$core::getSwfBuild());
		$this->setParams('swf.path',			$core::getSwfPath());
		
		if($users->isLogged())
		{
			foreach($_SESSION['account'] as $key => $value)
			{
				$this->setParams("account.{$key}", $users->getInfo($_SESSION['account']['id'], $key));
			}
			
			$this->setParams('housekeeping', '');
			
			if($users->isStaffMember($_SESSION['account']['username']))
			{
				$this->setParams('housekeeping', '<li><a href="{hotel.url}/ase" class="ase-portal">Housekeeping</a></li>');
			}
		}
		
		$direction = 2;
		$xusers = $engine->select('users', array(), array('username', 'look'), array('id' => 'DESC'), 3)->fetchAll();
	
		foreach($xusers as $user)
		{
			$this->setParams('registered.recent', sprintf('<tr><td class="rec-list-user" style="background: url(http://www.habbo.nl/habbo-imaging/avatarimage?figure=%s&head_direction=%d&gesture=sml&headonly=1) top center no-repeat;">%s<hr /></td></tr>', $user['look'], $direction, $user['username']));
			$direction++;
		}
		
		$random = $engine->select('users', array(), array('username', 'look'), array('RAND()' => ''), 1)->fetchAll()[0];
		$this->setParams('registered.random.username',	$random['username']);
		$this->setParams('registered.random.look', 		$random['look']);
		
		$request = isset($_GET['url']) ? $core::secure($_GET['url']) : 'index';
		
		if(in_array($request, array('article', 'news')))
		{
			$default = $engine->select('cms_news', array(), array('*'), array('id' => 'DESC'), 1)->fetch();
			$id = isset($_GET['article']) ? intval($_GET['article']) : $default;
		
			$articles = $engine->query('SELECT title, id FROM cms_news WHERE id != :id LIMIT 10', array('id' => $id));
			$this->setParams('newsList', '');
			foreach($articles as $article)
				$this->setParams('newsList', sprintf('<a href="%s/article/%d">%s</a><br />', $core::getHotelUrl(), $article['id'], $article['title']));
			
			$current = $engine->select('cms_news', array('id' => $id))->fetchAll();
			$current = array_shift($current);
			
			$this->setParams('article.title',		$current['title']);
			$this->setParams('article.content', 	$current['longstory']);
			$this->setParams('article.author.id',	!is_numeric($current['author']) ? $users->getId($current['author']) : $current['author']);
			$this->setParams('article.author.name', $users->getInfo($this->params['article.author.id'], 'username'));
			$this->setParams('article.author.look', $users->getInfo($this->params['article.author.id'], 'look'));
			$this->setParams('article.published', 	date("d/m/Y", $current['published']));
		}
		
		if(in_array($request, array('me', 'account', 'home', 'settings')))
		{
			$i = 0;
			$articles = $engine->select('cms_news', array(), array('*'), array('id' => 'DESC'), 5)->fetchAll();
			
			if(isset($articles[0]))
			{
				foreach($articles as $article)
				{
					$i++;
					$this->setParams(sprintf('newsTitle-%d', $i),	$article['title']);
					$this->setParams(sprintf('newsID-%d', $i), 		$article['id']);
					$this->setParams(sprintf('newsDate-%d', $i), 	$article['published']);
					$this->setParams(sprintf('newsCaption-%d', $i), $article['shortstory']);
					$this->setParams(sprintf('newsIMG-%d', $i), 	$article['image']);
				}
			}
		}
		
		if(in_array($request, array('profile')))
		{
			$account = isset($_GET['user']) ? $core::secure($_GET['user']) : $_SESSION['account']['id'];
			
			if(isset($_GET['id']))
				$account = intval($core::secure($_GET['id']));
			
			if(!is_numeric($account))
				$account = $users->getId($account);
			
			$this->setParams('profile.id',				$account);
			$this->setParams('profile.username',		$users->getInfo($account, 'username'));
			$this->setParams('profile.mail',			$users->getInfo($account, 'mail'));
			$this->setParams('profile.rank',			$users->getInfo($account, 'rank'));
			$this->setParams('profile.credits',			$users->getInfo($account, 'credits'));
			$this->setParams('profile.activity_points', $users->getInfo($account, 'activity_points'));
			$this->setParams('profile.look',			$users->getInfo($account, 'look'));
			$this->setParams('profile.gender',			$users->getInfo($account, 'gender'));
			$this->setParams('profile.motto',			$users->getInfo($account, 'motto'));
			$this->setParams('profile.account_created', date('d/m/Y', $users->getInfo($account, 'account_created')));
			$this->setParams('profile.last_online',		date('d/m/Y, H:i', $users->getInfo($account, 'last_online')));
			
			$badges = $engine->query("SELECT * FROM user_badges WHERE user_id = '" . $account . "' AND badge_slot >= 1 ORDER BY badge_slot DESC LIMIT 5");
			if(empty($badges) || !$badges)
			{
				$this->setParams('profile.badges', '<i>No active badges');
			}
			else {
				foreach($badges as $badge)
					$this->setParams('profile.badges', sprintf('<span style="display: inline-block; background: url(%s/c_images/badges/%s.gif) center no-repeat; margin 0 14px; width: 50px; height: 50px;"></span>', $core::getSwfPath(), $badge['badge_id']));
			}
			
			$friends = $engine->query("SELECT id, username, look FROM users WHERE `id` IN (SELECT `user_one_id` FROM `messenger_friendships` WHERE `user_two_id`='{$account}') ORDER BY id DESC");
			if(empty($friends) || !$friends)
			{
				$this->setParams('profile.friends', '<i>No friends :(</i>');
			}
			else {
				foreach($friends as $friend)
					$this->setParams('profile.friends', sprintf('<a href="{hotel.url}/profile/%d"><img src="http://www.habbo.nl/habbo-imaging/avatarimage?figure=%s&size=s" /></a>', $friend['id'], $friend['look']));
			}
		}
	}
	
	/**
	 * Set a template parameter
	 * @param string $key
	 * @param mixed $value
	 */
	public function setParams($key, $value)
	{
		if(isset($this->params[$key])) {
			$this->params[$key] .= $value;
		}
		else {
			$this->params[$key] = $value;
		}
	}
	
	/**
	 * Filter parameters on content
	 * @param string $content
	 * @return string
	 */
	public function filterParams($content)
	{
		foreach($this->params as $key => $value)
		{
			if(is_array($value))
				$value = json_encode($value);
			
			if(strpos($key, '{') !== false && strpos($key, '}') !== false)
				$key = str_ireplace("{{$key}}", $value, $key);
			
			$content = str_ireplace("{{$key}}", $value, $content);
		}
		
		return $content;
	}
	
	/**
	 * Set the template content
	 * @param string $content
	 */
	public function setContent($content)
	{
		$this->content .= $content;
	}
	
	/**
	 * Get the template content
	 * @return string
	 */
	public function getContent()
	{
		return (string)$this->content;
	}
	
	/**
	 * Display the parsed template
	 */
	public function output()
	{
		$this->setContent($this->html->getContent());
		echo $this->filterParams($this->content);
	}
}
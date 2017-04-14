<?php
/**
 * RevolutionCMS
 *
 * @author	Kryptos
 * @author	GarettM
 * @version	0.0.1
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
		
		$this->setParams('hotelName',		$core::getHotelName());
		$this->setParams('hotelDesc',		$core::getHotelDesc());
		$this->setParams('url', 			$core::getHotelUrl());
		$this->setParams('online', 			$core::getOnline());
		
		$this->setParams('server.address',			$core::getServerAddress());
		$this->setParams('server.port',				$core::getServerPort());
		$this->setParams('client.build',			$core::getHotelWebBuild());
		$this->setParams('client.external_vars',	$core::getHotelExternalVar());
		$this->setParams('client.external_texts',	$core::getHotelExternalTxt());
		$this->setParams('client.swf_folder',		$core::getHotelSwfFolder());
		
		$this->setParams('last_uri',		isset($_GET['url']) ? $core::secure($_GET['url']) : '');
		
		$this->setParams('users.registered', $core::getRegisteredCount());
		
		if(defined('REV_DEVELOPMENT'))
			$this->setParams('rand', sha1(rand(2, 888)));
		
		if($users->isLogged())
		{
			$this->setParams('username',	 $users->getInfo($_SESSION['account']['id'], 'username'));
			$this->setParams('rank',		 $users->getInfo($_SESSION['account']['id'], 'rank'));
			$this->setParams('motto',		 $users->getInfo($_SESSION['account']['id'], 'motto'));
			$this->setParams('email', 		 $users->getInfo($_SESSION['account']['id'], 'mail'));
			$this->setParams('sso',			 $users->getInfo($_SESSION['account']['id'], 'auth_ticket'));
			$this->setParams('coins',		 $users->getInfo($_SESSION['account']['id'], 'credits'));
			$this->setParams('pixels',		 $users->getInfo($_SESSION['account']['id'], 'activity_points'));
			$this->setParams('figure',		 $users->getInfo($_SESSION['account']['id'], 'look'));
			$this->setParams('housekeeping', '');
			
			if($users->isStaffMember($_SESSION['account']['username']))
			{
				$this->setParams('housekeeping', '<li><a href="' . $this->params['url'] . '/ase" class="ase-portal">Housekeeping</a></li>');
			}
		}
		
		$request = isset($_GET['url']) ? $core::secure($_GET['url']) : 'index';
		if(in_array($request, array('article', 'news')))
		{
			$default = $engine->select('cms_news', array(), array('*'), array('id' => 'DESC'), 1)->fetch();
			$id = isset($_GET['article']) ? intval($_GET['article']) : $default;
		
			$articles = $engine->query('SELECT title, id FROM cms_news WHERE id != :id LIMIT 10', array('id' => $id));
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
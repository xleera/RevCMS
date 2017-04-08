<?php
/**
 * RevolutionCMS
 *
 * @author	Kryptos
 * @author	GarettM
 * @version	0.8.1
 */
 
namespace Revolution\app;

class template
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
	protected $template;
	
	/**
	 * @var array
	 */
	protected $params = array();
	
	/**
	 * Template Constructor
	 */
	public function __construct()
	{
		/**
		 * Sub Objects
		 */
		$this->form = new tpl\form;
		$this->html = new tpl\html;
		$this->css	= new tpl\css;
		$this->js	= new tpl\js;
		
		$engine = engine::getInstance();
		$users	= users::getInstance();
		$core   = core::getInstance();
		
		$this->setParams('hotelName',	$core->getHotelName());
		$this->setParams('hotelDesc',	$core->getHotelDesc());
		$this->setParams('url', 		$core->getHotelUrl());
		$this->setParams('online', 		$core->getOnline());
		$this->setParams('status',		$core->getStatus());
		$this->setParams('web_build',	$core->getHotelWebBuild());
		$this->setParams('external_vars',	$core->getHotelExternalVars());
		$this->setParams('external_texts',	$core->getHotelExternalTexts());
		$this->setParams('swf_folder',	$core->getHotelSwfFolder());
		
		/**
		 * This is to make sure css is not cached, when developing
		 */
		$this->setParams('rand', sha1(rand(2, 888)));
		
		if($users->isLogged())
		{
			$this->setParams('username',	$users->getInfo($_SESSION['account']['id'], 'username'));
			$this->setParams('rank',		$users->getInfo($_SESSION['account']['id'], 'rank'));
			$this->setParams('motto',		$users->getInfo($_SESSION['account']['id'], 'motto'));
			$this->setParams('email', 		$users->getInfo($_SESSION['account']['id'], 'mail'));
			$this->setParams('sso',			$users->getInfo($_SESSION['account']['id'], 'auth_ticket'));
			$this->setParams('coins',		$users->getInfo($_SESSION['account']['id'], 'credits'));
			$this->setParams('pixels',		$users->getInfo($_SESSION['account']['id'], 'activity_points'));
			$this->setParams('figure',		$users->getInfo($_SESSION['account']['id'], 'look'));
			$this->setParams('housekeeping', '');
			
			if($this->params['rank'] > 3)
			{
				$this->setParams('housekeeping', '<li><a href="' . $this->params['url'] . 'ase/">Housekeeping</a></li>');
			}
		}
		
		$request = $core->secure(@$_GET['url']) ?: 'index';
		if(in_array($request, array('me', 'account', 'home', 'settings')))
		{
			$options = array('options' => array('default' => '1'));
			$id = filter_var(@$_GET['id'], FILTER_VALIDATE_INT, $options);
		
			$articles = $engine->query('SELECT title, id FROM cms_news WHERE id != :id LIMIT 10', array(':id' => $id));
			foreach($articles as $article)
				$this->setParams('newsList', sprintf('<a href="%s/index.php?url=news&id=%d">%s</a><br />', $core->getHotelUrl(), $article['id']. $article['title']));
			
			$current = $engine->select('cms_news', array('id' => $id), '*', array(), 1)->fetch();
			$this->setParams('newsTitle', $current['title']);
			$this->setParams('newsContent', $current['longstory']);
			$this->setParams('newsAuthor', is_int($current['author']) ? $users->getUsername($current['author']) : $current['author']);
			$this->setParams('newsDate', $current['published']);
		}
		
		if(in_array($request, array('news', 'articles')))
		{
			$i = 0;
			$articles = $engine->select('cms_news', array(), '*', array('id' => 'DESC'), 5)->fetch();
			
			if(isset($articles[0]))
			{
				foreach($articles as $article)
				{
					$i++;
					$this->setParams(sprintf('newsTitle-%d', $i), $article['title']);
					$this->setParams(sprintf('newsID-%d', $i), $article['id']);
					$this->setParams(sprintf('newsDate-%d', $i), $article['published']);
					$this->setParams(sprintf('newsCaption-%d', $i), $article['shortstory']);
					$this->setParams(sprintf('newsIMG-%d', $i), $article['image']);
				}
			}
		}
	}
	
	public function getTemplate()
	{
		return $this->template;
	}
	
	public function setParams($key, $value)
	{
		if(isset($this->params[$key])) {
			$this->params[$key] .= $value;
		}
		else {
			$this->params[$key] = $value;
		}
	}
	
	public function filterParams($str)
	{
		foreach($this->params as $key => $value)
		{
			if(is_array($value))
				$value = array_shift($value);
			$str = str_ireplace("{{$key}}", $value, $str);
		}
		
		return $str;
	}
	
	public function write($str)
	{
		$this->template .= $str;
	}
	
	public function outputTPL()
	{
		$this->write($this->html->getContent());

		echo $this->filterParams($this->template);
		unset($this->template);
	}
}
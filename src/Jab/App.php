<?php

namespace Jab;

use Jab\Database\PDODatabase;
use Jab\Misc\Router\Router;
use Jab\Misc\Session\Session;
use Jab\Controller\ArticleController;
use Jab\Controller\TemplateController;
use Jab\Component\User\Controller\UserController;

class App
{

	protected $aConfig;
	protected $oRouter            = null;
	protected $oSession           = null;
	protected $articleController  = null;
	protected $templateController = null;
	protected $oDb                = null;
	protected $oComponent         = null;
	protected $oUserController     = null;
	
	private static $oInstance     = null;

	public function setConfig (array $aConfig)
	{
		$this->aConfig = $aConfig;
	}

	/**
	 * 
	 * @return App
	 */
	public static function get ()
	{
		if (self::$oInstance === null) {
			self::$oInstance = new App();
		}
		return self::$oInstance;
	}

	public function handle ()
	{
		$router      = $this->getRouter();
		$aRouteParts = $router->getRoute(); 
		if(isset($aRouteParts[0]) && $aRouteParts[0] == 'components') {
			$oComponent  = $this->getComponent($aRouteParts[1]);
			$sComponentRouterPath = 'Jab\\Component\\' . ucfirst($aRouteParts[1]) . '\\Router';
		} else {
			$oRoute      = $router->dispatch();
			$oComponent  = $this->getComponent($oRoute->component);
			$oComponent->set($oRoute->ref_id);
			$sComponentRouterPath = 'Jab\\Component\\' . $oRoute->component . '\\Router';
		}
		
		if (class_exists($sComponentRouterPath)) {
			$oComponentRouter = new $sComponentRouterPath;
			$oComponentRouter->trigger($oComponent, $aRouteParts);
		}

		$this->oComponent = $oComponent;

		$oTemplate = $this->getTemplateController();
		$oTemplate->display($oComponent);
	}

	/**
	 * 
	 * @param string $sComponent
	 * @return Component
	 */
	public function getComponent ($sComponent)
	{
		$sFullcomponent = 'Jab\\Component\\' . $sComponent . '\\Controller\\' . ucfirst($sComponent) . "Controller";
		$oComponent = new $sFullcomponent;
		if ($oComponent === null) {
			throw new Exception('Component ' . $sFullcomponent . ' not Found');
		}
		return $oComponent;
	}

	public function getDb ()
	{
		if (!$this->oDb) {
			$this->oDb = new PDODatabase(
					array(
				'driver' => $this->aConfig['db_driver'],
				'host' => $this->aConfig['db_host'],
				'db' => $this->aConfig['db_db'],
				'charset' => $this->aConfig['db_charset'],
				'user' => $this->aConfig['db_user'],
				'pw' => $this->aConfig['db_pw'],
				'options' => $this->aConfig['db_options']
					)
			);
		}
		return $this->oDb;
	}

	public function getArticleController ()
	{
		if (!$this->articleController) {
			$this->articleController = new ArticleController();
		}
		return $this->articleController;
	}

	public function getTemplateController ()
	{
		if (!$this->templateController) {
			$this->templateController = new TemplateController();
		}
		return $this->templateController;
	}

	public function getRouter ()
	{
		if (!$this->oRouter) {
			$this->oRouter = new Router();
		}
		return $this->oRouter;
	}

	public function getMailer ()
	{
		if (!$this->oMailer) {
			$sMailerClass = 'Jab/Misc/Mailer/' . $this->aConfig['mailer'] . 'Mailer';
			$this->oMailer = new $sMailerClass($this->aConfig['mailer_options']);
		}
		return $this->oMailer;
	}

	public function getInput ($method = INPUT_POST)
	{
		return filter_input_array($method);
	}

	public function api ()
	{
		try{
			$sTask       = filter_input(INPUT_GET, 'task');
			if(empty($sTask)){
				return;
			}
			$aTaskParts  = explode('.', $sTask);
			$sController = ucfirst($aTaskParts[0]);
			$sMethod     = (isset($aTaskParts[1]) ? $aTaskParts[1] : 'Default') . 'Method';
			$sApiClass = 'Jab\\Api\\' . ucfirst($sController) . "Api";

			$oApiClass = new $sApiClass();
			echo $oApiClass->$sMethod();
			http_response_code(200);
		}	catch (\Exception $e) {
			http_response_code(500);
		}
		die;
	}
	
	public function setIdentity($oUser) {
		$this->getSession()->identity = $oUser;
	}
	
	public function getIdentity(){
		$oIdentity =  $this->getSession()->identity;
		if(!$oIdentity){
			$this->getUserController()->login(null);
		}
		return $oIdentity;
	}
	
	public function getUserController() {
		if(!$this->oUserController) {
			$this->oUserController = new UserController();
		}
		return $this->oUserController;
	}
	
	public function getSession(){
		if(!$this->oSession){
			$this->oSession = new Session();
		}
		return $this->oSession;
	}

}

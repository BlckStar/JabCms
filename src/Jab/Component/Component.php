<?php

namespace Jab\Component;

use Jab\Misc\Auth\AbstractAcl;
use Jab\App;

abstract class Component {
    
    public abstract function set($mParam); 
	
	public abstract function get();
	
	protected $oACL;
	
	public function getACL() {
		if(!$this->oACL) {
			$this->oACL = new AbstractAcl(['read', 'write', 'delete']); 
		}
		return $this->oACL;
	}
	
	public function isAuthorized ($task)
	{
		$oUser = App::get()->getIdentity();
		$sComponent = $this->getComponentName();
		$iAccessLevel = isset($oUser->rights[$sComponent]) ? $oUser->rights[$sComponent] : 
			(isset($oUser->rights['*']) ? $oUser->rights['*'] : 0);
		return $this->getACL()->isAuthorized($task, $iAccessLevel);
	}
	
	public function getComponentName() {
		$aClassParts = preg_split('/(?=[A-Z])/', get_class($this), -1, PREG_SPLIT_NO_EMPTY);
		return $aClassParts[count($aClassParts) -2]; 
	}
	
	
	public function __get($sKey) {
		if(property_exists(get_class($this), $sKey)) {
			return $this->$sKey;
		}
		$obj = $this->get();

		if(is_object($obj) && property_exists(get_class($obj), $sKey)) {
			return $obj->$sKey;
		}
		return false;
	}
	
	public function __call ($name, $arguments)
	{
		$app = App::get();
		if(method_exists($app, $name)){
			return call_user_func_array(array($app, $name), $arguments );
		}
	}
	
	public function redirect($sLocation) {
		header('Location: ' . $sLocation);
		exit;
	}
}
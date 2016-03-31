<?php

namespace Jab\Misc\Auth;

use Jab\Exception\ACLNotFoundException;

class AbstractAcl{
	
	private $aRules = array();
	
	public function __construct ($aACL)
	{
		for ($i = 0; $i < count($aACL) ; $i+=1) {
			$this->aRules[strtolower($aACL[$i])] = pow(2, $i);
		}
	}
	
	public function isAuthorized($task, $accesslevel) {
		if(!isset($this->aRules[strtolower($task)])){
			throw new ACLNotFoundException;
		}
		return ($this->aRules[strtolower($task)] & $accesslevel) > 0;
	}
}
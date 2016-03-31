<?php

namespace Jab\Component\User;

use Jab\Misc\Router\Router as JabRouter;

class Router extends JabRouter{
	
	
	public function trigger ($oComponent, $aRouteParts) {
		if(!isset($aRouteParts[2])) {
			return;
		}
		if(count($aRouteParts) > 3){
			call_user_func_array(array($this, $aRouteParts[2] . 'Action'), array_slice($aRouteParts,2) );
		} else {
			$oComponent->{$aRouteParts[2] . 'Action' }();
		}
	}
}
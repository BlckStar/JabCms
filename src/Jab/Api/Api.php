<?php

namespace Jab\Api;

class Api{
	
	public function response() {
		$aArgs = func_get_args();
		if(!count($aArgs)){
			return null;
		}
		return json_encode($aArgs);
	}
	
}
<?php

namespace Jab\Misc\Session;

class Session
{
	
	public function __construct ()
	{
		if(!$_SESSION) {
			$_SESSION = array();
		}
	}

	public function __get ($name)
	{
		if (isset($_SESSION[$name])) {
			return unserialize($_SESSION[$name]);
		}
		return null;
	}

	public function __set ($name, $mValue)
	{
		$_SESSION[$name] = serialize($mValue);
	}

}

<?php

namespace Jab\Component\Article;

use Jab\Misc\Auth\AbstractACL;

class ACL extends AbstractACL{
	
	public function __construct() {
		parent::__construct(array(
			'write', 'delete'
		));
	}
	
}


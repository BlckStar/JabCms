<?php

namespace Jab\Component\Category\Controller;

use Jab\Component\Component;

class CategoryController implements Component  {
    
    public $category_id;
    
    public function  set ($iCategoryId) {
	$this->category_id = $iCategoryId;
    }
    
    public function display() {
	
    }
}
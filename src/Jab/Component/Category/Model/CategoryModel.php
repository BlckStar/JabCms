<?php

namespace Jab\Component\Category\Model;

use Jab\Model\Model;

class CategoryModel extends Model {
    
    protected $objectName = 'Jab\Component\Article\Object\Category';
    
    public function getCategory($iCategoryId) {
		return parent::get('SELECT * FROM category WHERE id = :id', array('id' => $iCategoryId));
    }
}

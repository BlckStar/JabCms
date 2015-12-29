<?php

namespace Jab\Component\Article\Model;

use Jab\Model\Model;

class ArticleModel extends Model {
    
    protected $objectName = 'Jab\Component\Article\Object\Article';
    
    public function get($iArticleId) {
	return parent::get('SELECT * FROM article WHERE id = :id', array('id' => $iArticleId));
    }
}

<?php

namespace Jab\Component\Article\Model;

use Jab\Model\Model;

class ArticleModel extends Model {
    
    protected $objectName = 'Jab\Component\Article\Object\Article';
    protected $tableName = 'article';
	
    public function getArticle($iArticleId) {
		return parent::get('SELECT * FROM article WHERE id = :id', array('id' => $iArticleId));
    }
	
	public function update ($id, $values)
	{
		$oDb = $this->getDb();
		$oStmt = $oDb->prepare("UPDATE article SET text=:text, header=:header WHERE id=:id");
		if(isset($values['text'])){
			$oStmt->bindValue(':text', $values['text']);
		}
		if(isset($values['header'])){
			$oStmt->bindValue(':header', $values['header']);
		}
		$oStmt->bindValue(':id', $id);
		$oStmt->execute();
	}
	
	
}

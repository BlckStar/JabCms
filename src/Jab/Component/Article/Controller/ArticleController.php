<?php

namespace Jab\Component\Article\Controller;

use Jab\Component\Article\Model\ArticleModel;
use Jab\Controller\BlockController;
use Jab\Component\Component;

class ArticleController implements Component  {
    
    protected $oModel;
    
    protected $article_id;
    
    public function get() {
	$oArticleModel = $this->getModel();
	return $oArticleModel->get($this->article_id);
    }
    
    public function  set ($iArticleId) {
	$this->article_id = $iArticleId;
    }

    public function display() {
	$oArticle = $this->get();
	return $this->render($oArticle);
    }
    
    public function render($oArticle) {
	$oBlockController = new BlockController('/Jab/Component/Article/Template/');
	$oBlockController->article = $oArticle;
	return $oBlockController->render('article.phtml');
    }
    
    protected function getModel() {
	if(!$this->oModel) {
	    $this->oModel = new ArticleModel();
	}
	
	return $this->oModel;
    }
}
<?php

namespace Jab\Component\Article\Controller;

use Jab\Component\Article\Model\ArticleModel;
use Jab\Controller\BlockController;
use Jab\Component\Component;

class ArticleController extends Component
{

	protected $oModel;
	protected $article_id;
	protected $oArticle = null;
	
	public function get ()
	{
		if(!$this->oArticle){
			$oArticleModel = $this->getModel();
			$this->oArticle = $oArticleModel->getArticle($this->article_id);
		}
		return $this->oArticle;
	}

	public function set ($iArticleId)
	{
		$this->article_id = $iArticleId;
	}

	public function display ()
	{
		$oArticle = $this->get();
		return $this->render($oArticle);
	}
	
	public function render ($oArticle)
	{
		$oBlockController = new BlockController('/Jab/Component/Article/Template/');
		$oBlockController->article = $oArticle;
		$aHTML = array();
		if($this->isAuthorized("read")) {
			$aHTML[] = $oBlockController->render('article.phtml');
		}
		if($this->isAuthorized("write")) {
			$aHTML[] = $oBlockController->render('script.phtml');
		}
		return implode('', $aHTML);
	}

	protected function getModel ()
	{
		if (!$this->oModel) {
			$this->oModel = new ArticleModel();
		}

		return $this->oModel;
	}
	
	/**
	 * 
	 * @param \Jab\Component\Article\Object\Article $oArticle
	 */
	public function saveArticle($oArticle) {
		$this->getModel()->update($oArticle->id, array(
				'text'   => $oArticle->text,
				'header' => $oArticle->header
			)
		);
	}
		
}

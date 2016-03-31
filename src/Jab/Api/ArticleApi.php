<?php
namespace Jab\Api;

use Jab\App;

class ArticleApi extends Api {
	
	protected $data;
	protected $id;
	
	public function __construct() {
		$this->id   = (int) $_POST["id"];
		$this->data = json_decode($_POST["regions"]);
	}
	
	public function updateMethod() {
		$oArticleController = App::get()->getComponent("Article");
		$oArticleController->set($this->id);
		$oArticle = $oArticleController->get();
		if(isset($this->data->header)) {
			$oArticle->header = trim(strip_tags($this->data->header));
		}
		if(isset($this->data->content)) {
			$oArticle->text = $this->sanitizeHtml($this->data->content);
		}
		$oArticleController->saveArticle($oArticle);
		return $this->response($this->data);
	}
	
	protected function sanitizeHtml($sHTML) {
		return preg_replace("/<[^>]*>([\s]+)<\/[^>]*>/", "", $sHTML);
	}
}
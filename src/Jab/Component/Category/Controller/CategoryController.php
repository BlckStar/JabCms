<?php

namespace Jab\Component\Category\Controller;

use Jab\Component\Component;
use Jab\Component\Category\Model\CategoryModel;

class CategoryController extends Component
{
	public $category_id;
	protected $oCategory;
	protected $oModel;

	public function set ($iCategoryId)
	{
		$this->category_id = $iCategoryId;
	}

	public function get() {
		if(!$this->oCategory) {
			$oCategoryModel = $this->getModel();
			$this->oCategory = $oCategoryModel->getCategory($this->category_id);
		}
		return $this->oCategory;
	}
	
	public function getModel() {
		if(!$this->oModel) {
			$this->oModel = new CategoryModel();
		}
		return $this->oModel;
	}
	
	public function display ()
	{
		
	}
	

	public function getHeader ()
	{
		return $this->get()->header;
	}

}

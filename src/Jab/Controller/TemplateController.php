<?php

namespace Jab\Controller;

use Jab\App;
use Jab\Model\TemplateModel;

class TemplateController {
    
    protected $oTemplate;
    protected $oModel;
    protected $aRoutes;
    
    protected $site;
    protected $templatePath;
    
    public function __construct() {
	$oModel          = $this->getModel();
	$this->oTemplate = $oModel->getActive(); 
	$oRouter         = App::get()->getRouter();
	$this->aRoutes   = $oRouter->getAllRouteObjects();
    }
    
    public function display($oSite) {
	$this->site = $oSite;
	$this->templatePath = JAB_ROOT . '/template/' . $this->oTemplate->path ;
	ob_start();
	include $this->templatePath . '/index.phtml';
	$page = ob_get_contents();
	ob_end_clean();
	echo $page;
    }
    
    protected function getModel() {
	if(!$this->oModel) {
	    $this->oModel = new TemplateModel();
	}
	return $this->oModel;
    }
    
    public function meta($sName, $sValue){
	return '<meta '.$sName.'="' . $sValue . '">';
    }
    
    public function styleSheet($sPath) {
	return '<style>' . file_get_contents($this->templatePath . '/' . $sPath) . '</style>';
    }
    
    public function script($sPath) {
	return '<script>' . file_get_contents($this->templatePath . '/' . $sPath) . '</script>';
    }
}
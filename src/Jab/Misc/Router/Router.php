<?php

namespace Jab\Misc\Router;

use Jab\Model\RouteModel;

class Router {
    
    protected $aRoute;
    protected $oModel;

    public function getRoute() {
        if(!$this->aRoute) {
            $sUri = ltrim($_SERVER["REQUEST_URI"], '/');
            $aRouteParts = explode("/",$sUri);
	    while(isset($aRouteParts[0]) && ($aRouteParts[0] == '' || $aRouteParts[0] == 'index.php')){
		array_shift($aRouteParts);
	    }
	    $this->aRoute = $aRouteParts;
        }
        return $this->aRoute;
    }
    
    public function getAllRouteObjects() {
	$oRouterModel = $this->getModel();
	$aSortedRoutes = array();
	$aDbRoutes = $oRouterModel->getAll();
	foreach($aDbRoutes as $oRoute) {
	    $aSortedRoutes[$oRoute->id] = $oRoute;
	}
	$this->getCurrentRouteLevel($aSortedRoutes);
	
	$aArrayKeys = array_keys($aSortedRoutes);
	for($i = 0 ; $i < count($aSortedRoutes); $i++ ){
	    $oRoute = $aSortedRoutes[$aArrayKeys[$i]];
	    if($oRoute->level > 0 && isset($aSortedRoutes[$oRoute->parent_id])) {
		$aSortedRoutes[$oRoute->parent_id]->routes[$oRoute->id] = $oRoute;
		unset($aSortedRoutes[$oRoute->id]);
	    }
	}
	return $aSortedRoutes;
    }
    
    public function getCurrentRouteLevel(&$aRoutes, $oRouteId = null) {
	if($oRouteId !== null) {
	    $oRoute = &$aRoutes[$oRouteId];
	    if(isset($aRoutes[$oRoute->parent_id])){
		$oRoute->level = $this->getCurrentRouteLevel($aRoutes, $oRoute->parent_id) +1;
		return $oRoute->level;
	    }
	    return 0;
	}
	foreach($aRoutes as &$oRoute) {
	    if(isset($aRoutes[$oRoute->parent_id])) {
		$oRoute->level = $this->getCurrentRouteLevel($aRoutes,$oRoute->parent_id) + 1;
	    } else {
		$oRoute->level = 0;
	    }
	}
    }

    /**
     * 
     * @return \Jab\Object\Route
     */
    public function dispatch() {
	$aRoute = $this->getRoute();
	
	$oRoute = null;
	$oRouterModel = $this->getModel();
	if(count($aRoute) <= 1) {
	    $oRoute = $oRouterModel->get(isset($aRoute[0]) ? $aRoute[0] : '/');
	} else {
	    $oRoute = $oRouterModel->getTree($aRoute);
	}
	return $oRoute;

    }
    
    protected function getModel() {
	if(!$this->oModel) {
	    $this->oModel = new RouteModel();
	}
	return $this->oModel;
    }
    
}
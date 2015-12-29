<?php

namespace Jab\Model;

use Jab\App;

class Model  {
    
    protected $oDb;
    protected $objectName = 'stdClass';
    protected $tableName  = null;
    
    public function getDb() {
	if(!$this->oDb){
	    $app = App::get();
	    $this->oDb = $app->getDb();
	}
	return $this->oDb;
    }
    
    /**
     * 
     * @return \Jab\Object\Route[]
     */
    public function getAll($sQuery, $args = array(),$objectName = null) {
	$oDb = $this->getDb();
	$oStmt = $oDb->q($sQuery, $args);
	if(!$objectName) {
	   return $oStmt->fetchAll(\PDO::FETCH_CLASS, $this->objectName);
	}
	return $oStmt->fetchAll(\PDO::FETCH_CLASS, $objectName);
	
    }
    
  
    
    public function get($sQuery, $args = array(), $objectName = null) {
	$oDb = $this->getDb();
	$oStmt = $oDb->q($sQuery, $args);
	if(!$objectName) {
	    return $oStmt->fetchObject($this->objectName);
	}
	return $oStmt->fetchObject($objectName);
    }
}
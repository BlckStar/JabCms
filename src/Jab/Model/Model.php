<?php

namespace Jab\Model;

use Jab\App;

class Model
{

	protected $oDb;
	protected $objectName = 'stdClass';
	protected $tableName = null;

	/**
	 * 
	 * @return \Jab\Database\PDODatabase
	 */
	public function getDb ()
	{
		if (!$this->oDb) {
			$app = App::get();
			$this->oDb = $app->getDb();
		}
		return $this->oDb;
	}

	protected function getAll ($sQuery, $args = array(), $objectName = null)
	{
		$oDb = $this->getDb();
		$oStmt = $oDb->q($sQuery, $args);
		if (!$objectName) {
			return $oStmt->fetchAll(\PDO::FETCH_CLASS, $this->objectName);
		}
		return $oStmt->fetchAll(\PDO::FETCH_CLASS, $objectName);
	}

	public function get ($sQuery, $args = array(), $objectName = null)
	{
		$oDb = $this->getDb();
		$oStmt = $oDb->q($sQuery, $args);
		if (!$objectName) {
			return $oStmt->fetchObject($this->objectName);
		}
		return $oStmt->fetchObject($objectName);
	}
	
	public function getValue($sQuery, $args = array(), $mIndex = 0) {
		$oDb = $this->getDb();
		$oStmt = $oDb->q($sQuery, $args);
		return $oStmt->fetch(\PDO::FETCH_BOTH)[$mIndex];
	}

}

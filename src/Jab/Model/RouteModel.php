<?php

namespace Jab\Model;

class RouteModel extends Model
{

	protected $objectName = 'Jab\Object\Route';
	protected $tableName = 'route';

	public function getRoute ($sRoute)
	{
		return parent::get('SELECT * FROM route WHERE path = :route', array('route' => $sRoute));
	}

	public function getTree ($aRoute)
	{
		$oDb = $this->getDb();
		$oDb->q('SELECT * FROM route WHERE path = :route', array('route' => $aRoute));
	}

	/**
	 * 
	 * @return Route[]
	 */
	public function getRoutes ()
	{
		return parent::getAll('SELECT * FROM route');
	}

	protected function getRouteByName ($sRoute)
	{
		
	}

}

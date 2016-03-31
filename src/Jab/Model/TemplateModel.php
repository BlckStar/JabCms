<?php

namespace Jab\Model;

class TemplateModel extends Model
{

	protected $objectName = 'Jab\Object\Template';

	/**
	 * 
	 * @return \Jab\Object\Template
	 /
	public function get ($sName)
	{
		return parent::get('SELECT * FROM template WHERE name = :name', array('name' => $sName));
	}*/

	/**
	 * 
	 * @return \Jab\Object\Template
	 */
	public function getActive ()
	{
		return parent::get('SELECT * FROM template WHERE active = 1');
	}

}

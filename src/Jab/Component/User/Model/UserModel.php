<?php

namespace Jab\Component\User\Model;

use Jab\Model\Model;

class UserModel extends Model{
	
	protected $objectName = 'Jab\Component\User\Object\User';
    protected $tableName = 'user';
	
    public function getUser($iUserId) {
		return parent::get('SELECT id, username, enabled, g.usergroup_id as usergroup FROM user 
			INNER JOIN user_usergroup g ON g.user_id = id
			WHERE id = :id', array('id' => $iUserId));
    }
	
	public function login($sUsername, $sPassword) {
		$iId =  parent::getValue('SELECT id FROM user WHERE username = :username AND password = :password AND enabled = 1',
			array('username' => $sUsername, 'password' => $sPassword)
		);
		if($iId){
			return $this->getUser($iId);
		}
	}
	
	public function getACL($iUserGroup) {
		return parent::getAll(
			'SELECT a.component, a.accesslevel FROM acl a 
			WHERE a.usergroup= :usergroup
			', array("usergroup" => $iUserGroup ),
			"ArrayObject"
		);
	}
	
}
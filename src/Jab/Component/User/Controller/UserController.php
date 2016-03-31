<?php

namespace Jab\Component\User\Controller;

use Jab\Component\Component;
use Jab\Component\User\Model\UserModel;
use Jab\Controller\BlockController;
use Jab\App;
use Jab\Component\User\Object\User;

class UserController extends Component {
	
	protected $iUserId;
	protected $oModel;
	protected $oUser;
	
	public function set($iUserId) {
		$this->iUserId = $iUserId;
	}
	
	public function get () {
		if(!$this->oUser) {
			$oUserSession = App::get()->getIdentity();
			if($oUserSession) {
				$this->oUser = $oUserSession;
			} else {
				$oModel = $this->getModel();
				$this->oUser = $oModel->getUser($this->iUserId);
			}
		}
		return $this->oUser;
	}
	
	public function getModel() {
		if(!$this->oModel) {
			$this->oModel = new UserModel();
		}
		return $this->oModel;
	}
	
	public function display ()
	{

		if(!$this->isAuthorized('read')){
			return $this->renderLogin();
		}
		$oUser = App::get()->getIdentity();
		return $this->renderUser($oUser);
	}
	
	public function renderLogin ()
	{
		$oBlockController = new BlockController('/Jab/Component/User/Template/');
		return $oBlockController->render('login.phtml');
	}
	
	public function renderUser ($oUser)
	{
		$oBlockController = new BlockController('/Jab/Component/User/Template/');
		$oBlockController->user = $oUser;
		return $oBlockController->render('user.phtml');
	}
	
	public function loginAction() {
		$aInputs = App::get()->getInput(INPUT_POST);
		$oModel  = $this->getModel();
		
		$oUser = $oModel->login($aInputs['username'], sha1($aInputs['password']) );
		$this->login($oUser);
		return false;
	}
	
	public function login($oUser = null) {
		if(!$oUser){
			$oUser = new User();
			$oUser->usergroup = 0;
		}
		$aAcl = $this->getModel()->getACL($oUser->usergroup);
		$oUser->rights = array();
		foreach ($aAcl as $oAcl) {
			$oUser->rights[$oAcl->component] = $oAcl->accesslevel;
		}
		App::get()->setIdentity($oUser);
	}
	
	public function logoutAction() {
		App::get()->setIdentity(NULL);
		return $this->redirect('/components/user');
	}
	
}

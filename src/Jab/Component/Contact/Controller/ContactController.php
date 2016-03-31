<?php

namespace Jab\Component\Contact\Controller;

use Jab\App;
use Jab\Component\Component;
use Jab\Controller\BlockController;
use Jab\Component\Contact\Model\ContactModel;

class ContactController extends Component
{

	public $contact_id;
	public $oModel;

	public function set ($iContactId)
	{
		$this->contact_id = $iContactId;
	}

	public function get ()
	{

		$oContactModel = $this->getModel();
		$oForm = $oContactModel->getContact($this->contact_id);
		$aInputs = $oContactModel->getInputs($this->contact_id);
		$aInputObjects = array();
		foreach ($aInputs as $oInput) {
			$sInputClass = 'Jab\\Component\\Contact\\Input\\' . ucfirst($oInput->type);
			$oInputObject = new $sInputClass;
			$oInputObject->setName($oInput->name);
			$oInputObject->setValue($oInput->value);
			$oInputObject->setPlaceholder($oInput->placeholder);
			$oInputObject->setClass($oInput->class);
			$aInputObjects[] = $oInputObject;
		}
		$oForm->inputs = $aInputObjects;
		return $oForm;
	}

	public function display ()
	{
		$aInputs = App::get()->getInput();
		if (isset($aInputs['form_sent_' . $this->contact_id])) {
			if (isset($aInputs['contact_sp_' . $this->contact_id]) && $aInputs['contact_sp_' . $this->contact_id] == $_SESSION['contact_' . $this->contact_id . '_sp']
			) {
				$_SESSION['contact_' . $this->contact_id . '_sp'] = NULL;
				$oContactModel = $this->getModel();
				$oForm = $oContactModel->get($this->contact_id);
				$oInputs = $oContactModel->getInputs($this->contact_id);
				mail(
						$oForm->recipient, $oForm->subject, $this->buildHtml($oInputs, $aInputs), 'From: ' . $oForm->sender
				);
				$oBlock = new BlockController('/Jab/Component/Contact/Template/');
				echo $oBlock->render('thankyou.phtml');
			}
		}
		$oContact = $this->get();
		return $this->render($oContact);
	}

	public function render ($oContact)
	{
		$sGuid = uniqid();
		$_SESSION['contact_' . $oContact->id . '_sp'] = $sGuid;
		$oBlockController = new BlockController('/Jab/Component/Contact/Template/');
		$oBlockController->contact = $oContact;
		$oBlockController->guid = $sGuid;
		return $oBlockController->render('form.phtml');
	}

	protected function getModel ()
	{
		if (!$this->oModel) {
			$this->oModel = new ContactModel();
		}

		return $this->oModel;
	}

	protected function buildHtml ($aInputs, $aPost)
	{
		$oHtmlController = new BlockController('/Jab/Component/Contact/Template/');
		foreach ($aInputs as &$oInput) {
			if (isset($aPost[$oInput->name])) {
				$oInput->value = $aPost[$oInput->name];
			}
		}
		$oHtmlController->inputs = $aInputs;
		return $oHtmlController->render('mail.phtml');
	}

}

<?php

namespace Jab\Component\Contact\Model;

use Jab\Model\Model;

class ContactModel extends Model {
    
    protected $objectName = 'Jab\Component\Contact\Object\Form';
    protected $inputObjectName = 'Jab\Component\Contact\Object\Input';
    
    public function get($iContactId) {
	return parent::get('SELECT * FROM contact_form WHERE id = :id', array('id' => $iContactId));
    }
    
    public function getInputs($iContactId) {
	return parent::getAll('SELECT * FROM contact_input WHERE form_id = :id', array('id' => $iContactId), $this->inputObjectName);
    }
}

<?php

namespace Jab\Component\Contact\Input;

class Submit extends Input {

  public function __toString() {
	$aHtml = array();
	$aHtml[] = '<input type="submit" name="' . $this->name . '"';
	if(isset($this->class)) {
	  $aHtml[] = ' class="' .$this->class . '"';
	}
	if(isset($this->value)) {
	  $aHtml[] = ' class="' .$this->value . '"';
	}
	$aHtml[] = '>';
	return implode('', $aHtml);
  }
}
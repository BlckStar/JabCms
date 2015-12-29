<?php

namespace Jab\Component\Contact\Input;

class Text extends Input {

  public function __toString() {
	$aHtml = array();
	$aHtml[] = '<input type="text" name="' . $this->name . '"';
	if(isset($this->class)) {
	  $aHtml[] = ' class="' .$this->class . '"';
	}
	if(isset($this->placeholder)) {
	  $aHtml[] = ' placeholder="' .$this->placeholder . '"';
	}
	if(isset($this->value)) {
	  $aHtml[] = ' value="' .$this->value . '"';
	}
	$aHtml[] = '>';
	return implode('', $aHtml);
  }
}
<?php

namespace Jab\Component\Contact\Input;

class Textarea extends Input {

  public function __toString() {
	$aHtml = array();
	$aHtml[] = '<textarea name="' . $this->name . '"';
	if(isset($this->class)) {
	  $aHtml[] = ' class="' .$this->class . '"';
	}
	if(isset($this->placeholder)) {
	  $aHtml[] = ' placeholder="' .$this->placeholder . '"';
	}
	$aHtml[] = '>';
	if(isset($this->value)) {
	  $aHtml[] = htmlspecialchars($this->value) ;
	}
	$aHtml[] = '</textarea>';
	return implode('', $aHtml);
  }
}
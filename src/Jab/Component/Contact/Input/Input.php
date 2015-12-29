<?php

namespace Jab\Component\Contact\Input;

abstract class Input {
    
    protected $value;
    protected $name;
    protected $placeholder;
    protected $class;
    
    
    public function setValue($value) {
	$this->value = $value;
    }
    
    public function getValue() {
	return $this->value;
    }
    
    public function setName($name) {
	$this->name = $name;
    }
    
    public function getName() {
	return $this->name;
    }
    public function setClass($class) {
	$this->class = $class;
    }
    
    public function getClass() {
	return $this->class;
    }
    public function setPlaceholder($placeholder) {
	$this->placeholder = $placeholder;
    }
    
    public function getPlaceholder() {
	return $this->placeholder;
    }
    
    
    public abstract function __toString();
}
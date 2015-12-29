<?php

namespace Jab\Object;

class Route {
    
    public $id;
    public $name;
    public $path;
    public $parent_id;
    public $component;
    public $ref_id;
    public $level = null;
    public $routes = array();
}
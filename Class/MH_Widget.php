<?php

namespace MH_Widget;

class MH_Widget {
	
	public function __invoke($path, $className = false){
        $structure = explode("/", $path);
        $class = end($structure);
        if(!class_exists($class)){
            require_once __DIR__ . "/../Widget/" . $path . ".php";
        }
        if($className){
            return new $className();
        }
        return new $class();
    }
}


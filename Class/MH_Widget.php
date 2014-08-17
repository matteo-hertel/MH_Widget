<?php

namespace MH_Widget;

abstract class MH_widgetBase{
    private $config, $data;
    
    abstract public function __invoke();
    
    abstract protected function controller();
    abstract protected function model();
    abstract protected function view();

}

class MH_Widget {
    
    public $config;
    
    private static function loadDependency($path, $className = false){
        
        try{
        
        if($className && class_exists($className)):
            return false;
        endif;
        
        $structure = explode("/", $path);
        $class = $className ? $className :  end($structure);
        
        if(!class_exists($class)):
            require_once __DIR__ . "/../Widget/" . $path . ".php";
        endif;
        
        return $class;
        } catch(Exception $exc){
            $msg = $ecx->getMessage();
            return false;
        }
    }
    
    public function load($path, $className = false){
        return self::loadDependency($path, $className);
        
    }
    
    public static function instance($path, $config = false, $className = false){
        self::loadDependency($path, $className);
        
         $class = self::loadDependency($path, $className);
        
        if(!$class){
            return false;
        }
        
        if($className){
            return new $className($config);
        }
        
        return new $class($config);
    }

	
	public function __invoke($path, $config = false, $className = false){
	    
	    $config = $config ? $config : $this->config;
	    
         $inst = $this->instance($path, $config, $className);
         
        if( get_parent_class($inst) === "MH_Widget\MH_widgetBase"):
         
            return $inst();
         
        else:
            trigger_error("The target widget must extend MH_Widget\MH_widgetBase, class instance is retuned", E_USER_NOTICE);
            return $inst;
        endif;
    }
}





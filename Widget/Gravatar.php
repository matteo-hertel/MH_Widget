<?php

class Gravatar extends \MH_widget\MH_widgetBase {

    public function __construct($config){
        $this->config = $config;
    }
    
    public function __invoke(){
        return $this->controller();
    }
    
    protected function controller(){
        $this->data = $this->model();
        if(array_key_exists("prevent_view", $this->config)):
            
            return $this->data;
            
        endif;
        return $this->view($this->data);

    }
    
    protected function model(){
        
        $base = "http://www.gravatar.com/avatar/" . md5( strtolower( trim( $this->config['email'] ) ) );
        
        $size = "";
        if(isset($this->config["size"])):
            $size = $this->config["size"];
        endif;
        
        $default = "";
        if(isset($this->config["default"])):
            $default = $this->config["default"];
        endif;
        
        $rate = "";
        if(isset($this->config["rate"])):
            $rate = $this->config["rate"];
        endif;
        
        $base .= "?s=$size&d=$default&r=$rate";
        
        return $base;
    }
    
    protected function view(){
        ob_start();
        
        echo sprintf("<img src='%s' />", $this->data);
        
        return ob_get_clean();
    }
    
}
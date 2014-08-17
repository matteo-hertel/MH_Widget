<?php

class HelloWorld extends \MH_widget\MH_widgetBase {

    public function __construct($config){
        $this->config = $config ? $config : [];
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
        
        return "Hello, World!";
    }
    
    protected function view(){
        ob_start();
        
        echo $this->data;
        
        return ob_get_clean();
    }
    
}
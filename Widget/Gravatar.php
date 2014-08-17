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
        return $this->view($this->data);

    }
    
    protected function model(){
        
        return "http://www.gravatar.com/avatar/" . md5( strtolower( trim( $this->config['email'] ) ) );
    }
    
    protected function view(){
        ob_start();
        
        echo sprintf("<img src='%s' />", $this->data);
        
        return ob_get_clean();
    }
    
}
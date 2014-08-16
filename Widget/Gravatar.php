<?php

class Gravatar {
    private $config;
    
    public function __construct($config){
        $this->config = $config;
    }
    
    public function __invoke(){
        return $this->controller();
    }
    
    private function controller(){
        $data = $this->model();
        if(isset($this->config['view'])){
            return $this->config['view']($data); 

        }else{
            return $this->view($data);
        }
    }
    
    private function model(){
        
        return "http://www.gravatar.com/avatar/" . md5( strtolower( trim( $this->config['email'] ) ) );
    }
    
    private function view($data){
        ob_start();
        
        echo sprintf("<img src='%s' />", $data);
        
        return ob_get_clean();
    }
    
}
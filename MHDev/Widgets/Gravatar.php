<?php
namespace MHDev\Widgets;

/**
 * @class Gravatar
 * @brief Gravatar (Globally Recognized Avatar) widget will provide a widget that will return the markup to render a Gravatar image
 * can get a config object and the result html markup will change based on the object
 *
 * @copyright  Copyright (c) 2014 Matteo Hertel (info@matteohertel.com)
 * @license    MIT
 * @version    0.2
 * @author    Matteo Hertel <info@matteohertel.com>
 */
class Gravatar extends \MHDev\WidgetCore\WidgetAbstract
{
    
    /**
     * @brief Magic contructor
     *
     * Gets a config array as parameter and will make that array availabe in the class scope
     *
     * @param type $config
     */
    public function __construct($config) {
        $this->config = is_array($config) ? $config : array();
    }
    
    /**
     * The magic invoke is triggered if the instance of the class is called as function
     *
     * will call the controller to start the MVC chain and get the result back, the result con be both HTML or an Object
     *
     * @return string
     */
    public function __invoke() {
        return $this->controller();
    }
    
    /**
     * Controller function, will call the model to get data, call the view passing the data from the model and return the result
     * in the key "prevent_view" is present in the config array, it will return the data from the model
     * @return string
     */
    protected function controller() {
    	$this->data = $this->model();
        return $this->view();
    }
    
    /**
     * Model function
     *
     * this function will do the heavy lifting ie get stuff from the DB, parse documents, calculate the mass of the sun etc
     * in this case will get the gravatar based on the config object
     * @return string
     */
    protected function model() {
        $protocol = $this->httpsEnabled() ? "https://" : "https://";
        $email_hash = md5(strtolower(trim(array_key_exists("email", $this->config) ? $this->config['email'] : "")));
        //base gravatar URL
        $base = sprintf("%swww.gravatar.com/avatar/%s", $protocol, $email_hash);
        
        //empty size, if there is not size in the config it will be an empty string an will not break the scritp if called
        $size = "";
        if (isset($this->config["size"])):
            $size = $this->config["size"];
        endif;
        
        //empty $default, if there is not default in the config it will be an empty string an will not break the scritp if called
        $default = "";
        if (isset($this->config["default"])):
            $default = $this->config["default"];
        endif;
        
        //empty $rate, if there is not rate in the config it will be an empty string an will not break the scritp if called
        $rate = "";
        if (isset($this->config["rate"])):
            $rate = $this->config["rate"];
        endif;
        
        //construct the final URL
        $base.= "?s=$size&d=$default&r=$rate";
        
        return $base;
    }
    
    /**
     * View function
     *
     * this function will generate and return the html markup, it will open and output buffer,
     * write inside the HTML and return the content of the ob to the controller
     * @return string
     */
    protected function view() {
        ob_start();
        
        echo sprintf("<img src='%s' />", $this->data);
        
        return ob_get_clean();
    }
    

    /**
     * httpsEnabled function
     *
     * this function return true if the connection is made over HTTPS and port 443 (default HTTPS port), false otherwise 
     * @return boolean
     */
    protected function httpsEnabled() {
    	if(!array_key_exists("HTTPS", $_SERVER) || array_key_exists("SERVER_PORT", $_SERVER)):
    		return false;
    	endif;	
        return (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443;
    }
}

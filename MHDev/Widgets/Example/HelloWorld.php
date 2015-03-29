<?php

namespace MHDev\Widgets\Example;

/**
 * @class HelloWorld
 * @brief Simple HelloWorld class to show how the widget system is working
 *
 * @copyright  Copyright (c) 2014 Matteo Hertel (info@matteohertel.com)
 * @license    MIT
 * @version    0.1
 * @author    Matteo Hertel <info@matteohertel.com>
 */
class HelloWorld extends \MHDev\WidgetCore\WidgetAbstract {

    /**
     * @brief Magic contructor 
     * 
     * Gets a config array as parameter and will make that array availabe in the class scope
     * 
     * @param type $config
     */
    public function __construct($config) {
        $this->config = $config ? $config : [];
    }

    /**
     * The magic invoke is triggered if the instance of the class is called as function
     * 
     * will call the controller to start the MVC chain and get the result back, the result con be both HTML or an Object
     * 
     * @return mixed
     */
    public function __invoke() {
        return $this->controller();
    }

    /**
     * Controller function, will call the model to get data, call the view passing the data from the model and return the result
     * in the key "prevent_view" is present in the config array, it will return the data from the model
     * @return mixed
     */
    protected function controller() {
        $this->data = $this->model();
        if (array_key_exists("prevent_view", $this->config)):

            return $this->data;

        endif;
        return $this->view();
    }

    /**
     * Model function
     * 
     * this function will do the heavy lifting ie get stuff from the DB, parse documents, calculate the mass of the sun etc
     * in this case will return an "Hello, World!"
     * @return mixed
     */
    protected function model() {

        return "Hello, World!";
    }

    /**
     * View function
     * 
     * this function will generate and return the html markup, it will open and output buffer, 
     * write inside the HTML and return the content of the ob to the controller
     * @return type
     */
    protected function view() {
        ob_start();

        echo $this->data;

        return ob_get_clean();
    }

}

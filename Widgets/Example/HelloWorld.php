<?php

// Use the right namespace
use \MH_Widget as Widget;

/**
 * @class HelloWorld
 * @brief Simple class to show how the widget system can work
 *
 *
 * @copyright  Copyright (c) 2014 Matteo Hertel (info@matteohertel.com)
 * @license    MIT
 * @version    0.1
 * @author    Matteo Hertel <info@matteohertel.com>
 */
class HelloWorld extends Widget\MH_WidgetBase {

    /**
     * magic constructor will set the config in the instance
     * 
     * @param array [optional] $config
     */
    public function __construct($config = false) {
        $this->config = $config ? $config : [];
    }

    /**
     * the invoke will call the controller
     * 
     * @return function output controller
     */
    public function __invoke() {
        return $this->controller();
    }

    /**
     * The controller will call the model for the raw data and pass it to the view
     * if the prevent_view flag is passed will return the raw data
     * 
     * @return function output model|view
     */
    protected function controller() {
        // get data from the controller
        $this->data = $this->model();
        // if prevent view is present return the data
        if (array_key_exists("prevent_view", $this->config)):

            return $this->data;

        endif;
        // return the markup from the view passing the data to it
        return $this->view($this->data);
    }

    /**
     * in the model data are created in thi example is just a string
     * 
     */
    protected function model() {

        return "Hello, World!";
    }

    /**
     * the view will open an output buffer, process the data from the model
     * write the processed output in the output buffer and return it
     * 
     * @return string content of the output buffer
     */
    protected function view() {
        // open output buffer
        ob_start();
        // write content in the ob
        echo $this->data;
        //return the clean ob;
        return ob_get_clean();
    }

}

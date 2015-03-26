<?php
namespace MHDev\WidgetCore;

/**
 * @class MH_Widget
 * @brief Main Widget class, it will load dependecies, create instances and call the oter widget
 *
 * This class cam behave differently based on the way the different method are called:
 *
 * Normal widget workflow (behavior if the called widget is a child of MH_WidgetBase):
 *  1. An instance is of MH_Widget is created
 *  2. The instance will be called like a function passing the widget path, an optional config array and an option classname
 *      * the config is a public property and can be set before call the instance as function
 *  3. The instance will return the HTML markup or the data from the model if the prevent_preview is passed in the config
 *
 * If the called widget is not an a child of MH_WidgetBase the wokflow must be:
 *  1. the static method instance must be called passing the widget path, an optional config array and an option classname
 *  2. the call will return an instance of the called class
 *
 * Using the static load the MH_Widget class can be used to load other classes and prevent
 * the entire workflow to be executed
 *
 * Warning: if the called widget is not a valid child of the MH_WidgetBase the magic invokw will raise an
 * E_USER_NOTICE and the instance of the called class will be returned
 *
 *
 * @copyright  Copyright (c) 2014 Matteo Hertel (info@matteohertel.com)
 * @license    MIT
 * @version    0.1
 * @author    Matteo Hertel <info@matteohertel.com>
 */
class MH_Widget
{
    
    /**
     * $config is public in this way the config array can be passed before call the
     * instance as a function
     */
    public $config;
    public $prefix;
    
    public function __construct($namespace = "\MHDev\Widgets\\") {
        $this->prefix = $namespace;
    }
    
    /**
     * The magic invoke is triggered if the instance of the class is called as function
     *
     * this function will set the config array if passed, call the instance function to get an instance of the
     * called widget and will call the instance as a function to trigger the magic invoke of the widget if the widget
     * is a valid child of MH_WidgetBase or will return and instance of the called widget/class and rise a notice
     *
     * @param string $path
     * @param array|boolean $config
     * @return mixed
     */
    public function __invoke($path, $config = []) {
        
        // if no config array is passed use the config property of the class
        $config = $config ? $config : $this->config;
        try {
            $class = $this->prefix . $path;
            $obj = new $class($config);
            return $obj();
        }
        catch(\Exception $exc) {
            echo $exc->getMessage();
        }
    }
    
    public static function create($path, $config = []) {
        $widget = new self();
        return $widget($path, $config);
    }
}

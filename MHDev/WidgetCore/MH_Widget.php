<?php
namespace MHDev\WidgetCore;

/**
 * @class MH_Widget
 * @brief Main Widget class it will create instances and call the widgets
 *
 * This class cam behave differently based on the way the different method are called:
 *
 * Normal widget work flow (behavior if the called widget is a child of MH_WidgetBase):
 *  1. An instance is of MH_Widget is created
 *  2. The instance will be called as function passing the widget namespace, an optional config array
 *      * a default config property  can be set before call the instance as function
 *  3. The instance will return the HTML markup or the data from the model if the prevent_preview is passed in the config
 *
 *
 * @copyright  Copyright (c) 2014 Matteo Hertel (info@matteohertel.com)
 * @license    MIT
 * @version    0.2
 * @author    Matteo Hertel <info@matteohertel.com>
 */
class MH_Widget
{
    
    /**
     * The config array can be passed before call the instance as function to have
     * a fall back configuration for widgets
     */
    public $config;
    /**
    * The prefix is the namespace of the called widget, the default is \MHDev\Widgets\
    */
    public $prefix;
    /**
    * the __constructor will accept a namespace to load the widgets from
    */
    public function __construct($namespace = "\MHDev\Widgets\\") {
        $this->prefix = $namespace;
    }
    
    /**
     * The magic invoke is triggered if the instance of the class is called as function
     *
     * when this function is called it will try to return a new instance of the given widget in the the configured namespace
     * passing into the instance the config array or the default one if none is provided
     * @param string $namespace
     * @param array $config
     * @return mixed
     */
    public function __invoke($namespace, $config = []) {
        
        // if no config array is passed use the config property of the class
        $config = is_array($config) ? $config : $this->config;
        try {
            $class = $this->prefix . $namespace;
            $obj = new $class($config);
            return $obj();
        }
        catch(\Exception $exc) {
            echo $exc->getMessage();
            return false;
        }
    }
    
    /**
	 *Static access function create
	 *
	 * Any widget can be called statically, it will follow the very same work flow 
	 * as the manual way, the API is just cleaner and flexible
	 *
     * @param string $namespace
     * @param array $config
     * @return mixed
     */

    public static function create($namespace, $config = []) {
        $widget = new self();
        return $widget($namespace, $config);
    }
}

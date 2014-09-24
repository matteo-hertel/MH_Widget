<?php

/**
 * @brief The widget system will run under the MH_Widget namespace
 */

namespace MH_Widget;

require_once 'MH_WidgetBase.php';

/**
 * @class MH_Widget
 * Main Widget class, it will load dependecies, create instances and call the oter widget
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
class MH_Widget {

    /**
     * $config is public in this way the config array can be passed before call the
     * instance as a function
     */
    public $config;

    /**
     * This function will check if the passed class is not loaded already, if is not will try load it and return the class name
     *
     * @param       string $path The path of the widget without the base Widgets/ eg. "Test/HelloWorld"
     * @param       string $className [optional] By default the last bit of the path will be treated as class name, an option classname will override this behavior
     * @return      string|boolean The class name or false if the try fails
     */
    private static function loadDependency($path, $className = false) {

        try {
            // if a classname is passed and the class is already loaded return the classname
            if ($className && class_exists($className)):
                return $className;
            endif;
            // get the widget path as array
            $structure = explode("/", $path);
            // get the classname from the passed string or the last element of the array
            $class = $className ? $className : end($structure); // the end function wil return the last element of the array
            // if the class in not loaded yet the $path.php will be included
            if (!class_exists($class)):
                //try to include the file
                try {
                    if (!is_readable(__DIR__ . "/../Widgets/" . $path . ".php")):
                        throw new \Exception("Path does not exist or is not readable", 0);
                    endif;
                    require_once __DIR__ . "/../Widgets/" . $path . ".php";
                } catch (\Exception $exc) {
                    //rise an error
                    $msg = $exc->getMessage();
                    trigger_error(htmlentities($msg), E_USER_ERROR);
                }
            endif;
            // return the class name
            return $class;
        } catch (Exception $exc) {
            // return false if some of the check fails
            $msg = $exc->getMessage();
            return false;
        }
    }

    /**
     * This public accessible static function will return the instance of the class in the give path/class name
     * 
     * @param       string $path The path of the widget without the base Widgets/ eg. "Test/HelloWorld"
     * @param       array  $config The config array, false by default
     * @param       string $className [optional] By default the last bit of the path will be treated as class name, an option classname will override this behavior
     * @return      object|boolean The instance of the class or false if some check fails
     */
    public static function instance($path, $config = false, $className = false) {
        //try to load the class
        self::loadDependency($path, $className);
        // get the classname
        $class = self::loadDependency($path, $className);
        //return false if no class if found
        if (!$class) {
            return false;
        }
        // if a className is passed return an instance of that class and the config array is passed
        if ($className) {
            return new $className($config);
        }
        // return and instace of the class and the config array is passed
        return new $class($config);
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
     * @param string $className
     * @return object/boolean
     */
    public function __invoke($path, $config = false, $className = false) {
        // if no config array is passed use the config property of the class
        $config = $config ? $config : $this->config;
        // return an intance of the given widget
        $inst = $this->instance($path, $config, $className);
        // check if the widget is a valid child of MH_WidgetBase
        if (get_parent_class($inst) === "MH_Widget\MH_WidgetBase"):
            // call the instance as a function to trigger the magic invoke
            return $inst();

        else:
            // if is not a valid child raise a notice and return just the instance of that class
            trigger_error("The target widget must extend MH_Widget\MH_widgetBase, class instance is retuned", E_USER_NOTICE);
            return $inst;
        endif;
    }

}

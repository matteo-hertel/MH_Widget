<?php

namespace MHDev\WidgetCore;

/**
 * @class MH_widgetBase
 * @brief Base widget class, all the widget must extend and override the abstract methods of  this class
 *
 * This class provides the base base structure of the fully function widget, to be a proper widget
 * a new class must extend and override the abstract methods of  this class
 *
 * @copyright  Copyright (c) 2014 Matteo Hertel (info@matteohertel.com)
 * @license    MIT
 * @version    0.1
 * @author    Matteo Hertel <info@matteohertel.com>
 */
abstract class WidgetAbstract {

    /**
     * Defining $config in this parent class the child class will be able to access
     * them and use them whitout the need to declare these properties again in the child class
     */
    protected $config;

    /**
     * Defining $data in this parent class the child class will be able to access
     * them and use them whitout the need to declare these properties again in the child class
     */
            protected$data;

    /**
     * @brief Magic invoke function
     *
     * This function will execute if the instasance of the class is called as function
     * every proper MH_Widget must have the invoke method
     */
    abstract public function __invoke();

    /**
     * @brief Controller function
     * 
     * Every MH_Widget run inside his own MVC pattern therefore must
     * have a controller
     */
    abstract protected function controller();

    /**
     * @brief Model function
     * 
     * Every MH_Widget run inside his own MVC pattern therefore must
     * have a model
     */
    abstract protected function model();

    /**
     * @brief View function
     * 
     * Every MH_Widget run inside his own MVC pattern therefore must
     * have a view
     */
    abstract protected function view();
}

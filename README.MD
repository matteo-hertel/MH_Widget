MH_Widgets
=========

Ultra flexible, highly configurable widget system to render any HTML from a single tag.

This package will provide a nice and neat interface to create widgets ready to use in any project, there are a lots of feature straight out of the box, but with its flexible nature can fit any need.

There are two main ways to use this package:
- Use the widget system standalone as easy way to render HTML
- Use the widget system with the integrated parser


To use the widget standalone:

1. Create an instance of \MHDev\WidgetCore\MH_Widget
2. Call the instance as a function (to trigger the magic `__invkoke`) passing two arguments (one optional): namespace, config array
3. under the hood the class will:
    - create a new instance of the requested widget in the given namespace(or use the default one \MHDev\Widgets\ and pass the config object 
    - call the instance as function (to trigger the magic `__invkoke`) and return the result

### The single widget workflow is:

1. from the magic invoke the the `controller` method is called
2. the `controller` method call the `model` method to get data
3. the `controlle`r will call and return the view method passing the data from the model
    - if the `prevent_view` kay is found in the config array the controller will return the data from the model without call the view

###Using the parser
With the integrated parser you can use a custom non-standard html tag mhwidget with attributes to render content from the widget, and example of a working tag:

    <mhwidget size="128" email="youremail@gravatr.com">Gravatar</mhwidget>

##Under the hood

To be a proper widget the class must extend the WidgetAbstract class and override the `__invoke`, `controller`, `model` and `view` methods,

##Usage 

Simple hello world

    $widget = new \MHDev\WidgetCore\MH_Widget("\MHDev\Widgets\\");
    echo $widget("Example\HelloWorld");

Gravatar

    $widget = new \MHDev\WidgetCore\MH_Widget("\MHDev\Widgets\\");
    echo $widget("Gravatar", ["email" => "info@matteohertel.com", "size" => 80]);
Version
----
0.2

Feedback
-----------
Please, send me your feedback, using the issue tracker on github or via email to info[at]matteohertel.com


Dependencies
---
There are no external dependencies but the Parser require the native DOMDocument class and a the widget tag syntax must be right to work properly

License
----
MIT


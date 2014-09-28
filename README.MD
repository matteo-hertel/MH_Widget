MH_Widgets
=========

This sets of classes will provide a quick way to create widgets in PHP and integrate thow widget in your HTML.

The workflow of a proper widget is:

1. Create an instance of MH_Widget
2. Call the instance as a function (to trigger the magic `__invkoke`) passing three arguments (two optional): path, config array, className
3. under the hood the class will:
    - check if the class is already loaded using the className parameter or the last bit of the path
    - if there is no instance include the php file in the provided path but inside the Widgets folder
    - create a new instance of the requested widget and pass the config object 
    - call the instance as function (to trigger the magic `__invkoke`) and return the result

The single widget workflow is:

1. from the magic invoke the the `controller` method is called
2. the `controller` method call the `model` method to get data
3. the `controlle`r will call and return the view method passing the data from the model
    - if the `prevent_view` kay is found in the config array the controller will return the data from the model without call the view

Edge Cases
---

To be a proper widget the class must exted the MH_WIdgetBase class and override the `__invoke`, `controller`, `model` and `view` methods, if a non poper widget is passed to the MH_Widget the function will return an instance of the called class without trigger the whole process

There are two main way to use this set of classes:
1. Use MH_Widget class out of the box
2. User the integrated parser to use just simple HTML markup and have the rendered result

Out of the box
---

Simple follow the previus workflow or use this snippet:

```php
require_once "Class/MH_Widget.php";

$widget = new \MH_Widget\MH_widget();

echo $widget("Gravatar", ["email" => "youremail@gravatr.com", "size" => 80]);

```

Parser
---

With the integrated parser you cna use a custom html tag MHwidget with attributes to render content from the widget, and example of a working tag:
```html
<MHwidget size="128" email="youremail@gravatr.com">Gravatar</widget>
```

the very same result can be use the config attribute, the content will be trated as serialized array sp ypu can use
```html
<mhwidget config='a:2:{s:4:"size";s:3:"128";s:5:"email";s:21:"youremail@gravatr.com";}'>Gravatar</mhwidget>
```

The parser class is documented alongside with all the other classes.


Version
----

0.1

Feedback
-----------

Please, send me your feedback, using the issue tracker on github or via email to info[at]matteohertel.com

Installation
--------------
A composer package will be provided in the next version

Dependencies
---
There are no external dependencies but the Parser require the native DOMDocument class and a the widget tag syntax must be right to work properly

License
----

MIT


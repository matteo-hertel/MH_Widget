<?php

namespace MHDev\WidgetCore;
/**
 * @class MH_WidgetParser
 * @brief This class will parse the give HTML and will replace all the widget tags with the content from MH_Widget class
 *
 * @copyright  Copyright (c) 2014 Matteo Hertel (info@matteohertel.com)
 * @license    MIT
 * @version    0.1
 * @author    Matteo Hertel <info@matteohertel.com>
 */
class WidgetParser {

    /**
     * $dom: the instance of the  DOMDocument class
     */
    private $dom,
            /**
             * all the <mhwidgets> tags found in the text
             */
            $widgets;

    /**
     * The modified HTML redy to go
     */
    public $html;

    /**
     * @brief Magic contructor 
     * 
     * in this class the constructor will also handle most of the logic:
     * 1. Create a new instnace of the DOMDocument
     * 2. suppress the error that will buble up if the HTML is invalid, we love invalid HTML
     * 3. load the text as HTML
     * 4. replace all the <mhwidget> tag with the desired content using the function getWidget
     * 5. assign the new HTML to the html property
     * @param string $text
     */
    public function __construct($text) {
        // instance of the DOMDocument
        $this->dom = new \DOMDocument();
        //suppress the errors for invalid HTML
        libxml_use_internal_errors(true);
        //load the text as HTML
        $this->dom->loadHTML($text);
        // replace the widget tags with custom content
        $this->getWidget();
        //save the HTML and use decode all the HTML entity
        $this->html = html_entity_decode($this->dom->saveHTML());
    }

    /**
     * @brief getWidget will replace all the widget tags with custom content
     * 
     * This is the complex function, the flow is:
     * 1. get the widget tags listNode
     * 2. is the lenght in more than 0:
     *    1. get all the attributes to create the config array
     *      1. if "config" is found as attribute the value will be trated like a serilized array and used as config array
     *    3. pass the config object to the MH_Widget that will return the content
     *    4. replace the widget tag with the new content
     *    5. if the lenght is more than 1 recall thi function and process the next widget
     */
    private function getWidget() {
        //get all the widget tags
        $nodes = $this->dom->getElementsByTagname("mhwidget");
        // extract the length
        $len = $nodes->length;
        if ($len):
            //get the first node
            $node = $nodes->item(0);

            $config = array();
            //the attributes of the HTML tag will form the config object
            foreach ($node->attributes as $item):
                $config[$item->name] = $item->value;
            endforeach;
            //if "config" is found as attribute the value will be trated like a serilized array and used as config array
            if (array_key_exists("config", $config)):
                $config = unserialize($config["config"]);
            endif;
            //instance of MH_Widget
            $MH_Widget = new MH_Widget();
            //get the content from MH_Widget
            $widget = $this->dom->createTextNode($MH_Widget($node->nodeValue, $config));
            //replace the node
            $node->parentNode->replaceChild($widget, $node);
            //recall this function if there are more than 1 widget in the list
            if ($len > 1):
                $this->getWidget();
            endif;
        endif;
    }

    /**
     * this static function will be used to quickly access all the parse project, the workflow is simple:
     * 1. create a new instance of this very class
     * 2. pass the content to the contructor
     * 3. return the parsed content
     * @param string $text
     * @return string|boolean
     */
    public static function parse($text) {
        //simple check, will return false if there is no text or text is not a string
        if (!$text || !is_string($text)):
            return false;
        endif;
        //new instance of this class
        $inst = new self($text);
        //return the parsed HTML
        return $inst->html;
    }

}

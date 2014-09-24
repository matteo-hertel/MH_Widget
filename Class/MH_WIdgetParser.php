<?php

class MH_WidgetParser {

    private $dom;
    public $text, $html, $widgets;

    public function __construct($text) {
        $this->text = sprintf("<span>%s</span>", $text);
        $this->dom = new DOMDocument();
        $this->dom->loadXML($this->text);
        $this->getWidget();
        $this->html = html_entity_decode($this->dom->saveHTML());
    }

    private function getWidget() {

        $nodes = $this->dom->getElementsByTagname("widget");
        $len = $nodes->length;
        if ($len):

            $node = $nodes->item(0);

            $config = array();

            foreach ($node->attributes as $item):
                $config[$item->name] = $item->value;
            endforeach;

            if (array_key_exists("config", $config)):
                $config = unserialize($config["config"]);
            endif;
            $MH_Widget = new \MH_Widget\MH_widget();

            $widget = $this->dom->createTextNode($MH_Widget($node->nodeValue, $config));

            $node->parentNode->replaceChild($widget, $node);
            if ($len > 0):
                $this->getWidget();
            endif;
        endif;
    }

    public static function parse($text) {
        if (!$text):
            return false;
        endif;
        $inst = new self($text);
        return $inst->html;
    }

}

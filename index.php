<?php

$start = microtime(true);
/*
 * Example one
 * 
 * Simple Hello World
 */
require_once "Class/MH_Widget.php";

$widget = new \MH_Widget\MH_widget();

echo $widget("Example/HelloWorld");

echo "<hr />";

/*
 * Example two
 * Simple Hello World with static instance
 */

$hello2 = \MH_Widget\MH_widget::instance("Example/HelloWorld");

echo sprintf("<h1>%s</h1>", $hello2());
echo "<hr />";

/*
 * Example three 
 * Gravatar
 */

echo $widget("Gravatar", ["email" => "info@matteohertel.com", "size" => 80]);

/*
 * Example four
 * Error
 * 
 */

//$error = $widget("test");


/*
 * Example 5
 * Full gravatar example
 */

$size = array_key_exists("size", $_GET) ? (int) $_GET["size"] : 80;
echo $widget("Gravatar", ["email" => "info@matteohertel.com", "size" => $size > 1 && $size < 2048 ? $size : 80]);
echo "<hr />";
/*
 * Example 6
 * Parser
 */
require_once 'Class/MH_WIdgetParser.php';

$html = <<< EOT
This is a simple example in wich I can show you that I can get my profile pic from my gravatr widget
        <br />
    <mhwidget size="128" email="info@matteohertel.com">Gravatar</mhwidget>
        <mhwidget size="128" default="mm">Gravatar</mhwidget>
        <hr />
    and I want another image but 80x80 now!
        <mhwidget config='a:2:{s:4:"size";s:3:"128";s:5:"email";s:21:"info@matteohertel.com";}'>Gravatar</mhwidget>
    and last but not least, <mhwidget>Example/HelloWorld</mhwidget>
   
EOT;
echo \MH_Widget\MH_WidgetParser::parse($html);


echo sprintf("<p>Memory allocated: %skb</p>", memory_get_usage(true) / 1024);
echo sprintf("<p>Memory spike: %skb</p>", memory_get_peak_usage(true) / 1024);
echo sprintf("<p>Execution time: %s</p>", microtime(true) - $start);


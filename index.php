<?php

$start = microtime(true);
require_once "vendor/autoload.php";

$widget = new \MHDev\WidgetCore\MH_Widget("\MHDev\Widgets\\");

/*
 * Example one
 * 
 * Simple Hello World
 */

echo "<h3>Simple Hello World</h3>";
echo $widget("Example\HelloWorld");
echo "<hr />";

/*
 * Example two
 * 
 * Gravatar 
 */

echo "<h3>Gravatar</h3>";
echo $widget("Gravatar", ["email" => "info@matteohertel.com", "size" => 80]);
echo "<hr />";

/*
 * Example three
 * 
 * test from different namespace  
 */

echo "<h3>test from different namespace</h3>";
$widget->prefix = "\Test\\";
echo $widget("TestWidget");
echo "<hr />";

/*
 * Example four
 * 
 * Static access 
 */

echo "<h3>Static access </h3>";
echo \MHDev\WidgetCore\MH_Widget::create("Gravatar", ["email" => "test@test.com", "size" => 128, "default" => "identicon"]);
echo "<hr />";

/*
 * Example five
 * 
 * Parser
 */
echo "<h3>Parser</h3>";
$widget->prefix = "\MHDev\Widgets\\";
$html = <<< EOT
This is a simple example in wich I can show you that I can get my profile pic from my gravatr widget
        <br />
    <mhwidget size="128" email="info@matteohertel.com">Gravatar</mhwidget>
        <mhwidget size="128" default="mm">Gravatar</mhwidget>
<br />
    and I want another image but 80x80 now!
        <mhwidget config='a:2:{s:4:"size";s:3:"128";s:5:"email";s:21:"info@matteohertel.com";}'>Gravatar</mhwidget>
    and last but not least, <mhwidget>Example\HelloWorld</mhwidget>
   
EOT;

echo \MHDev\WidgetCore\WidgetParser::parse($html);


echo sprintf("<p>Memory allocated: %skb</p>", memory_get_usage(true) / 1024);
echo sprintf("<p>Memory spike: %skb</p>", memory_get_peak_usage(true) / 1024);
echo sprintf("<p>Execution time: %s</p>", microtime(true) - $start);


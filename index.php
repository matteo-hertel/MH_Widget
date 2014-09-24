<?php

$start = microtime(true);
$size = array_key_exists("size", $_GET) ? (int) $_GET["size"] : 80;

require_once "Class/MH_Widget.php";

$widget = new \MH_Widget\MH_widget();

$hello = \MH_Widget\MH_widget::instance("Example/HelloWorld");

echo $hello();

echo "<hr />";
$avatar = $widget("Gravatar", ["email" => "info@matteohertel.com", "size" => $size > 1 && $size < 2048 ? $size : 80]);
echo $avatar;
echo "<hr />";

//$error = $widget("test");

require_once './Class/MH_WIdgetParser.php';
$test = <<< EOT
This is a simple example in wich I can show you that I can my profile pic from my gravatr widget
        <br />
    <widget size="128" email="info@matteohertel.com">Gravatar</widget>
        <hr />
    and I want another image but 80x80 now!
        <widget size="80" email="info@matteohertel.com">Gravatar</widget>
        
        
EOT;
echo MH_WidgetParser::parse($test);

echo sprintf("Execution time: %s", microtime(true) - $start);




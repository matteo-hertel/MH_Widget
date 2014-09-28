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

require_once 'Class/MH_WIdgetParser.php';
$test = <<< EOT
This is a simple example in wich I can show you that I can my profile pic from my gravatr widget
        <br />
    <mhwidget size="128" email="info@matteohertel.com">Gravatar</mhwidget>
        <hr />
    and I want another image but 80x80 now!
        <mhwidget config='a:2:{s:4:"size";s:3:"128";s:5:"email";s:21:"info@matteohertel.com";}'>Gravatar</mhwidget>
        
        
EOT;
echo \MH_Widget\MH_WidgetParser::parse($test);

echo sprintf("Execution time: %s", microtime(true) - $start);




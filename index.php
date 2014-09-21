<?php
$start = microtime(true);
$size = array_key_exists("size", $_GET) ? (int)$_GET["size"] : 80;

require_once "Class/MH_Widget.php";

$widget = new \MH_Widget\MH_widget();

$hello = $widget("HelloWorld");


echo $hello;

$avatar = $widget("Gravatar", ["email" => "info@matteohertel.com", "size" => $size > 1 && $size < 2048 ? $size : 80]);

echo $avatar;


echo"<pre style='color:#59E817; background-color:black; word-wrap:break-word;'>";
var_export(microtime(true) - $start);
echo"</pre>";

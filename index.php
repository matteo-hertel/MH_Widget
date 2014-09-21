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
$error = $widget("test");
echo sprintf("Execution time: %s", microtime(true) - $start);


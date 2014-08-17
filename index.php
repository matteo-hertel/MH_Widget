<?php
$start = microtime();
require_once "Class/MH_Widget.php";

$widget = new \MH_Widget\MH_widget();


$hello = $widget("Gravatar", ["email" => "info@matteohertel.com"]);

//$hello = $widget::load("Gravatar");

echo "<pre>";
var_dump($hello);
echo "</pre>";

echo"<pre style='color:#59E817; background-color:black; word-wrap:break-word;'>";
var_export(microtime() - $start);
echo"</pre>";

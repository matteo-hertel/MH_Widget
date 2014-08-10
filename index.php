<?php

require_once "Class/MH_Widget.php";

$widget = new \MH_Widget\MH_widget();

$hello = $widget("HelloWorld");

echo "<pre>";
var_dump($hello->say());
echo "</pre>";
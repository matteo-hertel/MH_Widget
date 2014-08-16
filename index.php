<?php

require_once "Class/MH_Widget.php";

$widget = new \MH_Widget\MH_widget();

$hello = $widget("Gravatar", ["email" => "info@matteohertel.com", "view" => function($data){return $data;}]);

echo "<pre>";
var_dump($hello);
echo "</pre>";
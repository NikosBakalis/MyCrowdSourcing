<?php

// print_r($_POST);
$cookie = $_POST;
$count = 0;
$lat = $cookie['latlngrad'][0];
$lng = $cookie['latlngrad'][1];
$rad = $cookie['latlngrad'][2];

$fp = fopen('../uploads/circle_contents.txt', 'a');

fwrite($fp, $lat . "%%" . $lng . "%%" . $rad . "\n");

fclose($fp);

?>

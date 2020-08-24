<?php

$cookie = $_POST;

$fp = fopen('../uploads/polygon_contents.txt', 'a');

foreach ($cookie as $value) {
  foreach ($value as $key) {
    fwrite($fp, $key . "%%");
  }
  $stat = fstat($fp);
  ftruncate($fp, $stat['size'] - 2);
  fwrite($fp, "\n");
}

fclose($fp);

?>

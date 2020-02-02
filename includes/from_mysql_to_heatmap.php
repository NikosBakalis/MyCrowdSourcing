<<?php

require 'dbhandler.inc.php';

$result = mysqli_query($connection, "SELECT firstname, lastname, username FROM user");
$rows = array();
while ($row = mysqli_fetch_array($result)) {
  $rows[] = $row;
}
echo json_encode($rows);
?>

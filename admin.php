<?php
  include 'header.php';
?>

<?php

echo $_SESSION['userID'];

echo date(' d/m/Y H:i:s', 1575043129582 / 1000);

?>

<form action="includes/from_mysql_to_json.inc.php" method="post">
  <button type="submit" name="from_mysql_to_json">from_mysql_to_json</button>
</form>

<?php
  include 'footer.php';
?>

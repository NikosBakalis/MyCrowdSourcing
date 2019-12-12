<?php

if(isset($_POST['admin_delete_all'])){ //This one right here cheks if the user entered this area using the html button.
  require 'dbhandler.inc.php';

  $sql = "DELETE FROM location";
  $stmt = mysqli_stmt_init($connection);
  if (!mysqli_stmt_prepare($stmt, $sql)) { //This one right here will check if the sql statement above working properly.
    header("Location: ../admin.php");
    exit();
  }
  else {
    mysqli_stmt_execute($stmt);
    header("Location: ../admin.php");
  }
}

?>

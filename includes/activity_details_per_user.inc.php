<?php

include 'dbhandler.inc.php';

if (isset($_POST['type_of_activity'])) {
  $name = $_POST['type_of_activity'];
  // echo $name;

  $error_empty = false;

  if (empty($name)) {
    echo "<span class='form-error'>Fill in all fields!</span>";
    $error_empty = true;
  } else {
    echo "<span class='form-success'>Success!</span>";
  }

  if (!empty($name)) {
    $sql_1 = "SELECT * FROM activity_details";
    $sql_2 = "SELECT * FROM activity_details WHERE type = '$name'";
    $stmt = mysqli_stmt_init($connection);
    if (!mysqli_stmt_prepare($stmt, $sql_1) || !mysqli_stmt_prepare($stmt, $sql_2)) { //This one right here will check if the sql statement above working properly.
      echo "Connection failed!";
      exit();
    }
    else{
      $result_1 = mysqli_query($connection, $sql_1);
      $resultCheck_1 = mysqli_num_rows($result_1);
      // echo $resultCheck_1 . '<br>';
      $result_2 = mysqli_query($connection, $sql_2);
      $resultCheck_2 = mysqli_num_rows($result_2);
      // echo $resultCheck_2 . '<br>';
      echo ($resultCheck_2 / $resultCheck_1) * 100 . "%";

      // if ($resultCheck_2 > 0) {
      //   while ($row = mysqli_fetch_assoc($result_2)) {
      //     // echo $row['latitude'] . '<br>';
      //     // echo $row['longitude'] . '<br>';
      //     // $float_latitide = floatval($row['latitude']);
      //   }
      // }
    }
  }

  // echo $float_latitide;
} else {
  echo "There was an error!";
}

?>

<?php

session_start();

// if (isset($_POST['start_datetime']) || isset($_POST['end_datetime'])) {
  include 'dbhandler.inc.php';

  $big_array = array();
  $name = $_POST['start_datetime'];
  // echo $name;
  // $name = "2018-04-25 18:27:00";
  // echo $name;
  $another_name = $_POST['end_datetime'];
  // $another_name = "2018-04-25 19:30:55";
  // echo $another_name;

  $error_empty = false;

  if (empty($name) || empty($another_name)) {
    // echo "<span class='form-error'>Fill in all fields!</span>";
    $error_empty = true;
  } else if (!empty($name) && !empty($another_name)) {
    // echo "<span class='form-success'>Success!</span>";
    $sql = "SELECT * FROM location WHERE timestamp_l >= '$name' AND timestamp_l <= '$another_name'";
    $stmt = mysqli_stmt_init($connection);
    if (!mysqli_stmt_prepare($stmt, $sql)) { //This one right here will check if the sql statement above working properly.
      echo "Connection failed!";
      exit();
    }
    else{
      $result = mysqli_query($connection, $sql);
      $resultCheck = mysqli_num_rows($result);

      if ($resultCheck > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
          $float_latitide = floatval($row['latitude']);
          $float_longitude = floatval($row['longitude']);
          $lat_lon_opa_array = array();
          array_push($lat_lon_opa_array, $float_latitide, $float_longitude);
          array_push($big_array, $lat_lon_opa_array);
          unset($lat_lon_opa_array);
        }
      }
    }
  }
  echo json_encode($big_array);
// } else {
//   exit();
// }

?>

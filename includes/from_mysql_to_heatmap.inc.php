<?php

session_start();

include 'dbhandler.inc.php';

$big_array = array();

$userID = $_SESSION['userID'];
$sql = "SELECT * FROM location WHERE userID = '$userID'";
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
      // echo $row['latitude'] . '<br>';
      $float_latitide = floatval($row['latitude']);
      $float_longitude = floatval($row['longitude']);
      $lat_lon_opa_array = array();
      array_push($lat_lon_opa_array, $float_latitide, $float_longitude);
      array_push($big_array, $lat_lon_opa_array);
      unset($lat_lon_opa_array);
    }
  }
}

echo json_encode($big_array);

?>

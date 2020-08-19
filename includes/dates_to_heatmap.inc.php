<?php

session_start();

// if (isset($_POST['start_datetime']) || isset($_POST['end_datetime'])) {
include 'dbhandler.inc.php';

$big_array = array();
$activity = $_POST['activity'];
$start_date = $_POST['start_datetime'];
$end_date = $_POST['end_datetime'];

if (!empty($activity) && (empty($start_date) && empty($end_date))) {
  $sql = "SELECT * FROM location
          INNER JOIN activity
          ON location.userID = activity.userID
          AND location.timestamp_l = activity.timestamp_l
          INNER JOIN activity_details
          ON activity.userID = activity_details.userID
          AND activity.timestamp_l = activity_details.timestamp_l
          AND activity.timestamp_a = activity_details.timestamp_a
          WHERE type = '$activity'";
} elseif (empty($activity) && !empty($start_date) && !empty($end_date)) {
  $sql = "SELECT * FROM location WHERE timestamp_l >= '$start_date' AND timestamp_l <= '$end_date'";
} else {
  $sql = "SELECT * FROM location";
}
$stmt = mysqli_stmt_init($connection);
if (!mysqli_stmt_prepare($stmt, $sql)) { //This one right here will check if the sql statement above working properly.
  echo "Connection failed!";
  exit();
} else {
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
echo json_encode($big_array);

?>

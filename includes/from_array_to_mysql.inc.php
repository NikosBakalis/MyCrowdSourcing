<?php
// include_once("from_json_to_array_with_json_machine.inc.php");
require 'C:/xampp/htdocs/MyCrowdSourcing/includes/dbhandler.inc.php'; //This one  right here requires the file dbhandler.inc.php that creates the conection.

foreach ($locations_array as $item) { //This one right here, $locations_array, is an array  from file from_json_to_array_with_json_machine.inc.php.
  $sql1 = "INSERT INTO location(userID, timestamp_l, latitude, longitude, accuracy, heading, vertical_accuracy, velocity, altitude) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
  $stmt1 = mysqli_stmt_init($connection);
  if (!mysqli_stmt_prepare($stmt1, $sql1)) { //This one right here will check if the sql statement above working properly.
    echo "Connection failed!";
    exit();
  }
  else{
    mysqli_stmt_bind_param($stmt1, "ssddiiiii", $item[0], $item[1], $item[2], $item[3], $item[4], $item[5], $item[6], $item[7], $item[8]);
    mysqli_stmt_execute($stmt1);
  }
}
unset($locations_array); //This one right here clears the $locations_array.

foreach ($activities_array as $item) { //This one right here, $activities_array, is an array  from file from_json_to_array_with_json_machine.inc.php.
  $sql2 = "INSERT INTO activity(userID, timestamp_l, timestamp_a) VALUES (?, ?, ?)";
  $stmt2 = mysqli_stmt_init($connection);
  if (!mysqli_stmt_prepare($stmt2, $sql2)) { //This one right here will check if the sql statement above working properly.
    echo "Connection failed!";
    exit();
  }
  else{
    mysqli_stmt_bind_param($stmt2, "sss", $item[0], $item[1], $item[2]);
    mysqli_stmt_execute($stmt2);
  }
}
unset($activities_array); //This one right here clears the $activities_array.

foreach ($activities_details_array as $item) { //This one right here, $activities_details_array, is an array  from file from_json_to_array_with_json_machine.inc.php.
  $sql3 = "INSERT INTO activity_details(userID, timestamp_l, timestamp_a, type, confidence) VALUES (?, ?, ?, ?, ?)";
  $stmt3 = mysqli_stmt_init($connection);
  if (!mysqli_stmt_prepare($stmt3, $sql3)) { //This one right here will check if the sql statement above working properly.
    echo "Connection failed!";
    exit();
  }
  else{
    mysqli_stmt_bind_param($stmt3, "ssssi", $item[0], $item[1], $item[2], $item[3], $item[4]);
    mysqli_stmt_execute($stmt3);
  }
}
unset($activities_details_array); //This one right here clears the $activities_details_array.

// header("Location: ../index.php"); //This one right here takes you back to the main page.

// print("<pre>".print_r($locations_array, true)."</pre>");

?>

<?php

session_start();
set_time_limit (0);


/**
 * Method to find the distance between 2 locations from its coordinates.
 *
 * @param latitude_center
 * @param longitude_center
 * @param latitude_point This one right here is the users latitude
 * @param longitude_point This one right here is the users longitude
 *
 * @return Float Distance in Kilometers.
 */
function getDistanceBetweenPointsNew($latitude_center, $longitude_center, $latitude_point, $longitude_point, $unit = 'Km') {
    $theta = $longitude_center - $longitude_point;
    $distance = sin(deg2rad($latitude_center)) * sin(deg2rad($latitude_point)) + cos(deg2rad($latitude_center)) * cos(deg2rad($latitude_point)) * cos(deg2rad($theta));

    $distance = acos($distance);
    $distance = rad2deg($distance);
    $distance = $distance * 60 * 1.1515;

    switch($unit)
    {
        case 'Mi': break;
        case 'Km' : $distance = $distance * 1.609344;
    }

    return (round($distance,7));
}


$resource = opendir("../uploads");
while(($files = readdir($resource)) != false) {
  if ($files != '.' && $files != '..') {
    require 'dbhandler.inc.php';

    $data = file_get_contents('http://localhost/MyCrowdSourcing/uploads/'.$files);
    // echo $data;
    $rows = json_decode($data, true);
    //echo $rows;

    $blah = 0;
    $correct = 0;
    $false = 0;
    if (is_array($rows) || is_object($rows)) {
      foreach ($rows['locations'] as $row) {
        $blah = $blah + 1;
        $sql1 = "INSERT INTO location(userID, timestamp_l, latitude, longitude, accuracy, heading, vertical_accuracy, velocity, altitude) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt1 = mysqli_stmt_init($connection);
        if (!mysqli_stmt_prepare($stmt1, $sql1)) { //This one right here will check if the sql statement above working properly.
          echo "Connection failed!1";
          exit();
        }
        else {
          $thisTimestampMs_l = date('Y-m-d H:i:s', $row['timestampMs'] / 1000);
          $thisLatitudeE7 = $row['latitudeE7'] / pow(10, 7);
          $thislongitudeE7 = $row['longitudeE7'] / pow(10, 7);
          // echo $row['timestampMs'];
          // echo "<br>";
          if (getDistanceBetweenPointsNew(38.230462, 21.753150, $thisLatitudeE7, $thislongitudeE7) < 10.0) {
            mysqli_stmt_bind_param($stmt1, "ssddiiiii", $_SESSION['userID'], $thisTimestampMs_l, $thisLatitudeE7, $thislongitudeE7, $row['accuracy'], $row['heading'], $row['verticalAccuracy'], $row['velocity'], $row['altitude']);
            mysqli_stmt_execute($stmt1);
            // if ($stmt1->execute()) {
            //    $correct = $correct + 1;
            // } else {
            //    $false = $false + 1;
            //    // echo $row['timestampMS']." ";
            //    // echo $row['latitudeE7']." ";
            //    // echo $row['longitudeE7']." ";
            //    // echo $thisTimestampMs_l. " " .$thisLatitudeE7. " " .$thislongitudeE7. " " .$row['accuracy']. " " .$row['heading']. " " .$row['verticalAccuracy']. " " .$row['velocity']. " " .$row['altitude'];
            // }

            if (isset($row['activity']) && (is_array($row['activity']) || is_object($row['activity']))) {
              foreach ($row['activity'] as $ro) {
                $sql2 = "INSERT INTO activity(userID, timestamp_l, timestamp_a) VALUES (?, ?, ?)";
                $stmt2 = mysqli_stmt_init($connection);
                if (!mysqli_stmt_prepare($stmt2, $sql2)) { //This one right here will check if the sql statement above working properly.
                  echo "Connection failed!2";
                  exit();
                }
                else {
                  $thisTimestampMs_a = date('Y-m-d H:i:s', $ro['timestampMs'] / 1000);
                  // echo $ro['timestampMs'];
                  mysqli_stmt_bind_param($stmt2, "sss", $_SESSION['userID'], $thisTimestampMs_l, $thisTimestampMs_a);
                  mysqli_stmt_execute($stmt2);

                  if (is_array($ro['activity']) || is_object($ro['activity'])) {
                    foreach ($ro['activity'] as $r) {
                      $sql3 = "INSERT INTO activity_details(userID, timestamp_l, timestamp_a, type, confidence) VALUES (?, ?, ?, ?, ?)";
                      $stmt3 = mysqli_stmt_init($connection);
                      if (!mysqli_stmt_prepare($stmt3, $sql3)) { //This one right here will check if the sql statement above working properly.
                        echo "Connection failed!3";
                        exit();
                      }
                      else {
                        mysqli_stmt_bind_param($stmt3, "ssssi", $_SESSION['userID'], $thisTimestampMs_l, $thisTimestampMs_a, $r['type'], $r['confidence']);
                        mysqli_stmt_execute($stmt3);
                      }
                    }
                  }
                }
              }
            }
          }
        }
      }
      // echo " - ".$blah." ".$correct." ".$false;
    }
    unlink('../uploads/'.$files);
  }
}
header("Location: ../index.php"); //This one right here takes you back to the main page.


?>

<?php

session_start();

function is_dir_empty($dir) { //This one right here is the basic function to search if a directory is empty or not.
  if (!is_readable($dir)) {
    return NULL;
  }
  else {
    return (count(scandir($dir)) == 2);
  }
}
function my_parser(){
  $resource = opendir("../uploads");
  while(($files = readdir($resource)) != false) {
    if ($files != '.' && $files != '..') {
      echo "Something to parse!";
      echo $files;
      require 'dbhandler.inc.php';

      $data = file_get_contents('http://localhost/MyCrowdSourcing/uploads/'.$files);
      //echo $data;
      $rows = json_decode($data, true);
      //echo $rows;

      if (is_array($rows) || is_object($rows)) {
        foreach ($rows['locations'] as $row) {
          $sql1 = "INSERT INTO location(userID, timestamp_l, latitude, longtitude, accuracy, heading, vertical_accuracy, velocity, altitude) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
          $stmt1 = mysqli_stmt_init($connection);
          if (!mysqli_stmt_prepare($stmt1, $sql1)) { //This one right here will check if the sql statement above working properly.
            echo "Connection failed!";
            exit();
          }
          else {
            $thisTimestampMs_l = date('Y-m-d H:i:s', $row['timestampMs'] / 1000);
            $thisLatitudeE7 = $row['latitudeE7'] / pow(10, 7);
            $thisLongtitudeE7 = $row['longitudeE7'] / pow(10, 7);
            echo $row['timestampMs'];
            echo "<br>";
            mysqli_stmt_bind_param($stmt1, "ssddiiiii", $_SESSION['userID'], $thisTimestampMs_l, $thisLatitudeE7, $thisLongtitudeE7, $row['accuracy'], $row['heading'], $row['verticalAccuracy'], $row['velocity'], $row['altitude']);
            mysqli_stmt_execute($stmt1);

            if (is_array($row['activity']) || is_object($row['activity'])) {
              foreach ($row['activity'] as $ro) {
                $sql2 = "INSERT INTO activity(userID, timestamp_l, timestamp_a) VALUES (?, ?, ?)";
                $stmt2 = mysqli_stmt_init($connection);
                if (!mysqli_stmt_prepare($stmt2, $sql2)) { //This one right here will check if the sql statement above working properly.
                  echo "Connection failed!";
                  exit();
                }
                else {
                  $thisTimestampMs_a = date('Y-m-d H:i:s', $ro['timestampMs'] / 1000);
                  echo $ro['timestampMs'];
                  mysqli_stmt_bind_param($stmt2, "sss", $_SESSION['userID'], $thisTimestampMs_l, $thisTimestampMs_a);
                  mysqli_stmt_execute($stmt2);

                  if (is_array($ro['activity']) || is_object($ro['activity'])) {
                    foreach ($ro['activity'] as $r) {
                      $sql3 = "INSERT INTO activity_details(userID, timestamp_l, timestamp_a, type, confidence) VALUES (?, ?, ?, ?, ?)";
                      $stmt3 = mysqli_stmt_init($connection);
                      if (!mysqli_stmt_prepare($stmt3, $sql3)) { //This one right here will check if the sql statement above working properly.
                        echo "Connection failed!";
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
      // unlink($file);
      // if (!unlink($file)) {
      //   echo "NO";
      // }
      // else {
      //   echo "YES";
      // }
    }
  }
}

my_parser();

?>

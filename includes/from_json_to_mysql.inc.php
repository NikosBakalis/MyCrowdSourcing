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
//function my_parser(){
  if (!is_dir_empty("../uploads")) {
    echo "Something to parse!";
    require 'dbhandler.inc.php';

    $files = scandir('../uploads/');

    foreach($files as $file) {
      //echo $file;
      $data = file_get_contents('http://localhost/MyCrowdSourcing/uploads/'.$file);
      //echo $data;
      $rows = json_decode($data, true);

      if (is_array($rows) || is_object($rows)) {
        foreach ($rows['locations'] as $row) {
          $sql = "INSERT INTO location(userID, timestamp_l, latitude, longtitude, accuracy, heading, vertical_accuracy, velocity, altitude) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
          $stmt = mysqli_stmt_init($connection);
          if (!mysqli_stmt_prepare($stmt, $sql)) { //This one right here will check if the sql statement above working properly.
            echo "Connection failed!";
            exit();
          }
          else {
            $thisTimestampMs_l = date('Y-m-d H:i:s', $row['timestampMs'] / 1000);
            $thisLatitudeE7 = $row['latitudeE7'] / pow(10, 7);
            $thisLongtitudeE7 = $row['longitudeE7'] / pow(10, 7);
            mysqli_stmt_bind_param($stmt, "ssddiiiii", $_SESSION['userID'], $thisTimestampMs_l, $thisLatitudeE7, $thisLongtitudeE7, $row['accuracy'], $row['heading'], $row['verticalAccuracy'], $row['velocity'], $row['altitude']);
            mysqli_stmt_execute($stmt);

            if (is_array($row) || is_object($row)){
              foreach ($row['activity'] as $ro) {
                $sql = "INSERT INTO activity(userID, timestamp_l, timestamp_a) VALUES (?, ?, ?)";
                $stmt = mysqli_stmt_init($connection);
                if (!mysqli_stmt_prepare($stmt, $sql)) { //This one right here will check if the sql statement above working properly.
                  echo "Connection failed!";
                  exit();
                }
                else {
                  $thisTimestampMs_a = date('Y-m-d H:i:s', $ro['timestampMs'] / 1000);
                  mysqli_stmt_bind_param($stmt, "sss", $_SESSION['userID'], $thisTimestampMs_l, $thisTimestampMs_a);
                  mysqli_stmt_execute($stmt);

                  if (is_array($ro) || is_object($ro)){
                    foreach ($ro['activity'] as $r) {
                      $sql = "INSERT INTO activity_details(userID, timestamp_l, timestamp_a, type, confidence) VALUES (?, ?, ?, ?, ?)";
                      $stmt = mysqli_stmt_init($connection);
                      if (!mysqli_stmt_prepare($stmt, $sql)) { //This one right here will check if the sql statement above working properly.
                        echo "Connection failed!";
                        exit();
                      }
                      else {
                        mysqli_stmt_bind_param($stmt, "ssssi", $_SESSION['userID'], $thisTimestampMs_l, $thisTimestampMs_a, $r['type'], $r['confidence']);
                        mysqli_stmt_execute($stmt);
                      }
                    }
                  }
                }
              }
            }
          }
        }
      }
      unlink($file);
      if (!unlink($file)) {
        echo "NO";
      }
      else {
        echo "YES";
      }
    }
  }
  else {
    echo "Nothing to parse!";
  }
//}

?>

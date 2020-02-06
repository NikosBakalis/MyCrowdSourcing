<?php

<<<<<<< HEAD
$myfile = fopen("C:/xampp/htdocs/MyCrowdSourcing/uploads/current_userID.txt", "r") or die("Unable to open file!"); // This one right here opes the file we creted on uploads.inc.php.
$_SESSION['userID'] = file_get_contents('C:/xampp/htdocs/MyCrowdSourcing/uploads/current_userID.txt'); // This one right here gets the contents of the file.
fclose($myfile); // This one right here closes the file we opened.
=======
$myfile = fopen("C:/xampp/htdocs/MyCrowdSourcing/uploads/current_userID.txt", "r") or die("Unable to open file!");
$_SESSION['userID'] = file_get_contents('C:/xampp/htdocs/MyCrowdSourcing/uploads/current_userID.txt');
fclose($myfile);
// $_SESSION['userID'] = str_replace("\n", "", $_SESSION['userID']);
>>>>>>> b9a85365c27e9d4ec9da072865de233fa7337dfa

set_time_limit (0);
ini_set('memory_limit', '-1');
require_once('C:/xampp/htdocs/MyCrowdSourcing/includes/json_machine/JsonMachine.php');

//This one right here is a function that allow us to find all the places in a fixed distance away from a fixed center we want.
//Following the circled distance logic.
function getDistanceBetweenPointsNew($latitude_center, $longitude_center, $latitude_point, $longitude_point, $unit = 'Km') {
    $theta = $longitude_center - $longitude_point;
    $distance = sin(deg2rad($latitude_center)) * sin(deg2rad($latitude_point)) + cos(deg2rad($latitude_center)) * cos(deg2rad($latitude_point)) * cos(deg2rad($theta));

    $distance = acos($distance);
    $distance = rad2deg($distance);
    $distance = $distance * 60 * 1.1515;

    switch($unit) { //This one right here allow us to change the unit from Miles Kilometers.
        case 'Mi': break;
        case 'Km' : $distance = $distance * 1.609344;
    }

    return (round($distance, 7)); //This one right here returns the distance rounded up to seven digits after comma. Like this one 24.1234567.
}

$resource = opendir("C:/xampp/htdocs/MyCrowdSourcing/uploads"); //This one right here checks the directory we want.
while(($files = readdir($resource)) != false) { //This one right here executes if the directory we selected above isn't empty.
  if ($files != '.' && $files != '..') { //This one right here excludes the "." and the ".." files from the folder searching.
    require 'C:/xampp/htdocs/MyCrowdSourcing/includes/dbhandler.inc.php';

    $locations = \JsonMachine\JsonMachine::fromFile('C:/xampp/htdocs/MyCrowdSourcing/uploads/'.$files, "/locations");

      foreach ($locations as $key => $location_values) {
        $sql1 = "INSERT INTO location(userID, timestamp_l, latitude, longitude, accuracy, heading, vertical_accuracy, velocity, altitude) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt1 = mysqli_stmt_init($connection);
        if (!mysqli_stmt_prepare($stmt1, $sql1)) { //This one right here will check if the sql statement above working properly.
          echo "Connection failed!";
          exit();
        }
        else {
          //This one right below help us change googles json data while parsing so as to use them later.
          $thisTimestampMs_l = date('Y-m-d H:i:s', $location_values['timestampMs'] / 1000);
          $thisLatitudeE7 = $location_values['latitudeE7'] / pow(10, 7);
          $thislongitudeE7 = $location_values['longitudeE7'] / pow(10, 7);
          if (getDistanceBetweenPointsNew(38.230462, 21.753150, $thisLatitudeE7, $thislongitudeE7) < 10.0) { //This one right here is the use of the function we created on line 11.
            mysqli_stmt_bind_param($stmt1, "ssddiiiii", $_SESSION['userID'], $thisTimestampMs_l, $thisLatitudeE7, $thislongitudeE7, $location_values['accuracy'], $location_values['heading'], $location_values['verticalAccuracy'], $location_values['velocity'], $location_values['altitude']);
            mysqli_stmt_execute($stmt1);
            if (isset($location_values['activity'])){
              foreach ($location_values['activity'] as $keys => $activity_values) {
                $sql2 = "INSERT INTO activity(userID, timestamp_l, timestamp_a) VALUES (?, ?, ?)";
                $stmt2 = mysqli_stmt_init($connection);
                if (!mysqli_stmt_prepare($stmt2, $sql2)) { //This one right here will check if the sql statement above working properly.
                  echo "Connection failed!";
                  exit();
                }
                else {
                  $thisTimestampMs_a = date('Y-m-d H:i:s', $activity_values['timestampMs'] / 1000); //This one right here help us change googles json data while parsing so as to use them later.
                    mysqli_stmt_bind_param($stmt2, "sss", $_SESSION['userID'], $thisTimestampMs_l, $thisTimestampMs_a);
                    mysqli_stmt_execute($stmt2);
                  foreach ($activity_values['activity'] as $keyss => $activity_details_values) {
                    $sql3 = "INSERT INTO activity_details(userID, timestamp_l, timestamp_a, type, confidence) VALUES (?, ?, ?, ?, ?)";
                    $stmt3 = mysqli_stmt_init($connection);
                    if (!mysqli_stmt_prepare($stmt3, $sql3)) { //This one right here will check if the sql statement above working properly.
                      echo "Connection failed!";
                      exit();
                    }
                    else {
                      mysqli_stmt_bind_param($stmt3, "ssssi", $_SESSION['userID'], $thisTimestampMs_l, $thisTimestampMs_a, $activity_details_values['type'], $activity_details_values['confidence']);
                      mysqli_stmt_execute($stmt3);
                    } //else closes.
                  } //foreach closes.
                } //else closes.
              } //foreach closes.
            } //if closes.
          } //functions if closes.
        } //else closes.
      } //foreach closes.
    unlink('C:/xampp/htdocs/MyCrowdSourcing/uploads/'.$files); //This one right here deletes the file we just parsed from the directory it has been uploaded.
  } //if closes.
} //when closes.
// proc_close($process);
header("Location: ../index.php"); //This one right here takes you back to the main page.
exit();

?>

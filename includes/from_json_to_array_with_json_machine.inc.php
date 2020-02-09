<?php

// $myfile = fopen("C:/xampp/htdocs/MyCrowdSourcing/uploads/current_userID.txt", "r") or die("Unable to open file!"); // This one right here opes the file we creted on uploads.inc.php.
// $_SESSION['userID'] = file_get_contents('C:/xampp/htdocs/MyCrowdSourcing/uploads/current_userID.txt'); // This one right here gets the contents of the file.
// fclose($myfile); // This one right here closes the file we opened.

// session_start();
// set_time_limit (0);
// ini_set('memory_limit', '-1');

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

// $resource = opendir("../uploads"); //This one right here checks the directory we want.
$resource = opendir("C:/xampp/htdocs/MyCrowdSourcing/uploads");
$locations_array = array();
$activities_array = array();
$activities_details_array = array();

while(($files = readdir($resource)) != false) { //This one right here executes if the directory we selected above isn't empty.
  if ($files != '.' && $files != '..' && $files != 'current_userID.txt' && $files != 'empty_text.txt') { //This one right here excludes the "." and the ".." files from the folder searching.
    $locations = \JsonMachine\JsonMachine::fromFile('C:/xampp/htdocs/MyCrowdSourcing/uploads/'.$files, "/locations");
      foreach ($locations as $key => $location_values) {
        //This one right below help us change googles json data while parsing so as to use them later.
        $thisTimestampMs_l = date('Y-m-d H:i:s', $location_values['timestampMs'] / 1000);
        $thisLatitudeE7 = $location_values['latitudeE7'] / pow(10, 7);
        $thislongitudeE7 = $location_values['longitudeE7'] / pow(10, 7);
        if (getDistanceBetweenPointsNew(38.230462, 21.753150, $thisLatitudeE7, $thislongitudeE7) < 10.0) { //This one right here is the use of the function we created on line 11.
          if (isset($location_values['accuracy']) && isset($location_values['heading']) && isset($location_values['verticalAccuracy']) && isset($location_values['velocity']) && isset($location_values['altitude'])) {
            array_push($locations_array, array($_SESSION['userID'], $thisTimestampMs_l, $thisLatitudeE7, $thislongitudeE7, $location_values['accuracy'], $location_values['heading'], $location_values['verticalAccuracy'], $location_values['velocity'], $location_values['altitude']));
          }
          else if(isset($location_values['accuracy']) && isset($location_values['heading']) && isset($location_values['verticalAccuracy']) && isset($location_values['velocity']) && !isset($location_values['altitude'])) {
            array_push($locations_array, array($_SESSION['userID'], $thisTimestampMs_l, $thisLatitudeE7, $thislongitudeE7, $location_values['accuracy'], $location_values['heading'], $location_values['verticalAccuracy'], $location_values['velocity'], NULL));
          }
          else if(isset($location_values['accuracy']) && isset($location_values['heading']) && isset($location_values['verticalAccuracy']) && !isset($location_values['velocity']) && isset($location_values['altitude'])) {
            array_push($locations_array, array($_SESSION['userID'], $thisTimestampMs_l, $thisLatitudeE7, $thislongitudeE7, $location_values['accuracy'], $location_values['heading'], $location_values['verticalAccuracy'], NULL, $location_values['altitude']));
          }
          else if(isset($location_values['accuracy']) && isset($location_values['heading']) && isset($location_values['verticalAccuracy']) && !isset($location_values['velocity']) && !isset($location_values['altitude'])) {
            array_push($locations_array, array($_SESSION['userID'], $thisTimestampMs_l, $thisLatitudeE7, $thislongitudeE7, $location_values['accuracy'], $location_values['heading'], $location_values['verticalAccuracy'], NULL, NULL));
          }
          else if(isset($location_values['accuracy']) && isset($location_values['heading']) && !isset($location_values['verticalAccuracy']) && isset($location_values['velocity']) && isset($location_values['altitude'])) {
            array_push($locations_array, array($_SESSION['userID'], $thisTimestampMs_l, $thisLatitudeE7, $thislongitudeE7, $location_values['accuracy'], $location_values['heading'], NULL, $location_values['velocity'], $location_values['altitude']));
          }
          else if(isset($location_values['accuracy']) && isset($location_values['heading']) && !isset($location_values['verticalAccuracy']) && isset($location_values['velocity']) && !isset($location_values['altitude'])) {
            array_push($locations_array, array($_SESSION['userID'], $thisTimestampMs_l, $thisLatitudeE7, $thislongitudeE7, $location_values['accuracy'], $location_values['heading'], NULL, $location_values['velocity'], NULL));
          }
          else if(isset($location_values['accuracy']) && isset($location_values['heading']) && !isset($location_values['verticalAccuracy']) && !isset($location_values['velocity']) && isset($location_values['altitude'])) {
            array_push($locations_array, array($_SESSION['userID'], $thisTimestampMs_l, $thisLatitudeE7, $thislongitudeE7, $location_values['accuracy'], $location_values['heading'], NULL, NULL, $location_values['altitude']));
          }
          else if(isset($location_values['accuracy']) && isset($location_values['heading']) && !isset($location_values['verticalAccuracy']) && !isset($location_values['velocity']) && !isset($location_values['altitude'])) {
            array_push($locations_array, array($_SESSION['userID'], $thisTimestampMs_l, $thisLatitudeE7, $thislongitudeE7, $location_values['accuracy'], $location_values['heading'], NULL, NULL, NULL));
          }
          else if(isset($location_values['accuracy']) && !isset($location_values['heading']) && isset($location_values['verticalAccuracy']) && isset($location_values['velocity']) && isset($location_values['altitude'])) {
            array_push($locations_array, array($_SESSION['userID'], $thisTimestampMs_l, $thisLatitudeE7, $thislongitudeE7, $location_values['accuracy'], NULL, $location_values['verticalAccuracy'], $location_values['velocity'], $location_values['altitude']));
          }
          else if(isset($location_values['accuracy']) && !isset($location_values['heading']) && isset($location_values['verticalAccuracy']) && isset($location_values['velocity']) && !isset($location_values['altitude'])) {
            array_push($locations_array, array($_SESSION['userID'], $thisTimestampMs_l, $thisLatitudeE7, $thislongitudeE7, $location_values['accuracy'], NULL, $location_values['verticalAccuracy'], $location_values['velocity'], NULL));
          }
          else if(isset($location_values['accuracy']) && !isset($location_values['heading']) && isset($location_values['verticalAccuracy']) && !isset($location_values['velocity']) && isset($location_values['altitude'])) {
            array_push($locations_array, array($_SESSION['userID'], $thisTimestampMs_l, $thisLatitudeE7, $thislongitudeE7, $location_values['accuracy'], NULL, $location_values['verticalAccuracy'], NULL, $location_values['altitude']));
          }
          else if(isset($location_values['accuracy']) && !isset($location_values['heading']) && isset($location_values['verticalAccuracy']) && !isset($location_values['velocity']) && !isset($location_values['altitude'])) {
            array_push($locations_array, array($_SESSION['userID'], $thisTimestampMs_l, $thisLatitudeE7, $thislongitudeE7, $location_values['accuracy'], NULL, $location_values['verticalAccuracy'], NULL, NULL));
          }
          else if(isset($location_values['accuracy']) && !isset($location_values['heading']) && !isset($location_values['verticalAccuracy']) && isset($location_values['velocity']) && isset($location_values['altitude'])) {
            array_push($locations_array, array($_SESSION['userID'], $thisTimestampMs_l, $thisLatitudeE7, $thislongitudeE7, $location_values['accuracy'], NULL, NULL, $location_values['velocity'], $location_values['altitude']));
          }
          else if(isset($location_values['accuracy']) && !isset($location_values['heading']) && !isset($location_values['verticalAccuracy']) && isset($location_values['velocity']) && !isset($location_values['altitude'])) {
            array_push($locations_array, array($_SESSION['userID'], $thisTimestampMs_l, $thisLatitudeE7, $thislongitudeE7, $location_values['accuracy'], NULL, NULL, $location_values['velocity'], NULL));
          }
          else if(isset($location_values['accuracy']) && !isset($location_values['heading']) && !isset($location_values['verticalAccuracy']) && !isset($location_values['velocity']) && isset($location_values['altitude'])) {
            array_push($locations_array, array($_SESSION['userID'], $thisTimestampMs_l, $thisLatitudeE7, $thislongitudeE7, $location_values['accuracy'], NULL, NULL, NULL, $location_values['altitude']));
          }
          else if(isset($location_values['accuracy']) && !isset($location_values['heading']) && !isset($location_values['verticalAccuracy']) && !isset($location_values['velocity']) && !isset($location_values['altitude'])) {
            array_push($locations_array, array($_SESSION['userID'], $thisTimestampMs_l, $thisLatitudeE7, $thislongitudeE7, $location_values['accuracy'], NULL, NULL, NULL, NULL));
          }
          else if(!isset($location_values['accuracy']) && isset($location_values['heading']) && isset($location_values['verticalAccuracy']) && isset($location_values['velocity']) && isset($location_values['altitude'])) {
            array_push($locations_array, array($_SESSION['userID'], $thisTimestampMs_l, $thisLatitudeE7, $thislongitudeE7, NULL, $location_values['heading'], $location_values['verticalAccuracy'], $location_values['velocity'], $location_values['altitude']));
          }
          else if(!isset($location_values['accuracy']) && isset($location_values['heading']) && isset($location_values['verticalAccuracy']) && isset($location_values['velocity']) && !isset($location_values['altitude'])) {
            array_push($locations_array, array($_SESSION['userID'], $thisTimestampMs_l, $thisLatitudeE7, $thislongitudeE7, NULL, $location_values['heading'], $location_values['verticalAccuracy'], $location_values['velocity'], NULL));
          }
          else if(!isset($location_values['accuracy']) && isset($location_values['heading']) && isset($location_values['verticalAccuracy']) && !isset($location_values['velocity']) && isset($location_values['altitude'])) {
            array_push($locations_array, array($_SESSION['userID'], $thisTimestampMs_l, $thisLatitudeE7, $thislongitudeE7, NULL, $location_values['heading'], $location_values['verticalAccuracy'], NULL, $location_values['altitude']));
          }
          else if(!isset($location_values['accuracy']) && isset($location_values['heading']) && isset($location_values['verticalAccuracy']) && !isset($location_values['velocity']) && !isset($location_values['altitude'])) {
            array_push($locations_array, array($_SESSION['userID'], $thisTimestampMs_l, $thisLatitudeE7, $thislongitudeE7, NULL, $location_values['heading'], $location_values['verticalAccuracy'], NULL, NULL));
          }
          else if(!isset($location_values['accuracy']) && isset($location_values['heading']) && !isset($location_values['verticalAccuracy']) && isset($location_values['velocity']) && isset($location_values['altitude'])) {
            array_push($locations_array, array($_SESSION['userID'], $thisTimestampMs_l, $thisLatitudeE7, $thislongitudeE7, NULL, $location_values['heading'], NULL, $location_values['velocity'], $location_values['altitude']));
          }
          else if(!isset($location_values['accuracy']) && isset($location_values['heading']) && !isset($location_values['verticalAccuracy']) && isset($location_values['velocity']) && !isset($location_values['altitude'])) {
            array_push($locations_array, array($_SESSION['userID'], $thisTimestampMs_l, $thisLatitudeE7, $thislongitudeE7, NULL, $location_values['heading'], NULL, $location_values['velocity'], NULL));
          }
          else if(!isset($location_values['accuracy']) && isset($location_values['heading']) && !isset($location_values['verticalAccuracy']) && !isset($location_values['velocity']) && isset($location_values['altitude'])) {
            array_push($locations_array, array($_SESSION['userID'], $thisTimestampMs_l, $thisLatitudeE7, $thislongitudeE7, NULL, $location_values['heading'], NULL, NULL, $location_values['altitude']));
          }
          else if(!isset($location_values['accuracy']) && isset($location_values['heading']) && !isset($location_values['verticalAccuracy']) && !isset($location_values['velocity']) && !isset($location_values['altitude'])) {
            array_push($locations_array, array($_SESSION['userID'], $thisTimestampMs_l, $thisLatitudeE7, $thislongitudeE7, NULL, $location_values['heading'], NULL, NULL, NULL));
          }
          else if(!isset($location_values['accuracy']) && !isset($location_values['heading']) && isset($location_values['verticalAccuracy']) && isset($location_values['velocity']) && isset($location_values['altitude'])) {
            array_push($locations_array, array($_SESSION['userID'], $thisTimestampMs_l, $thisLatitudeE7, $thislongitudeE7, NULL, NULL, $location_values['verticalAccuracy'], $location_values['velocity'], $location_values['altitude']));
          }
          else if(!isset($location_values['accuracy']) && !isset($location_values['heading']) && isset($location_values['verticalAccuracy']) && isset($location_values['velocity']) && !isset($location_values['altitude'])) {
            array_push($locations_array, array($_SESSION['userID'], $thisTimestampMs_l, $thisLatitudeE7, $thislongitudeE7, NULL, NULL, $location_values['verticalAccuracy'], $location_values['velocity'], NULL));
          }
          else if(!isset($location_values['accuracy']) && !isset($location_values['heading']) && isset($location_values['verticalAccuracy']) && !isset($location_values['velocity']) && isset($location_values['altitude'])) {
            array_push($locations_array, array($_SESSION['userID'], $thisTimestampMs_l, $thisLatitudeE7, $thislongitudeE7, NULL, NULL, $location_values['verticalAccuracy'], NULL, $location_values['altitude']));
          }
          else if(!isset($location_values['accuracy']) && !isset($location_values['heading']) && isset($location_values['verticalAccuracy']) && !isset($location_values['velocity']) && !isset($location_values['altitude'])) {
            array_push($locations_array, array($_SESSION['userID'], $thisTimestampMs_l, $thisLatitudeE7, $thislongitudeE7, NULL, NULL, $location_values['verticalAccuracy'], NULL, NULL));
          }
          else if(!isset($location_values['accuracy']) && !isset($location_values['heading']) && !isset($location_values['verticalAccuracy']) && isset($location_values['velocity']) && isset($location_values['altitude'])) {
            array_push($locations_array, array($_SESSION['userID'], $thisTimestampMs_l, $thisLatitudeE7, $thislongitudeE7, NULL, NULL, NULL, $location_values['velocity'], $location_values['altitude']));
          }
          else if(!isset($location_values['accuracy']) && !isset($location_values['heading']) && !isset($location_values['verticalAccuracy']) && isset($location_values['velocity']) && !isset($location_values['altitude'])) {
            array_push($locations_array, array($_SESSION['userID'], $thisTimestampMs_l, $thisLatitudeE7, $thislongitudeE7, NULL, NULL, NULL, $location_values['velocity'], NULL));
          }
          else if(!isset($location_values['accuracy']) && !isset($location_values['heading']) && !isset($location_values['verticalAccuracy']) && !isset($location_values['velocity']) && isset($location_values['altitude'])) {
            array_push($locations_array, array($_SESSION['userID'], $thisTimestampMs_l, $thisLatitudeE7, $thislongitudeE7, NULL, NULL, NULL, NULL, $location_values['altitude']));
          }
          else if(!isset($location_values['accuracy']) && !isset($location_values['heading']) && !isset($location_values['verticalAccuracy']) && !isset($location_values['velocity']) && !isset($location_values['altitude'])) {
            array_push($locations_array, array($_SESSION['userID'], $thisTimestampMs_l, $thisLatitudeE7, $thislongitudeE7, NULL, NULL, NULL, NULL, NULL));
          }
          if (isset($location_values['activity'])){
            foreach ($location_values['activity'] as $keys => $activity_values) {

              $thisTimestampMs_a = date('Y-m-d H:i:s', $activity_values['timestampMs'] / 1000); //This one right here help us change googles json data while parsing so as to use them later.
              array_push($activities_array, array($_SESSION['userID'], $thisTimestampMs_l, $thisTimestampMs_a));
              foreach ($activity_values['activity'] as $keyss => $activity_details_values) {
                array_push($activities_details_array, array($_SESSION['userID'], $thisTimestampMs_l, $thisTimestampMs_a, $activity_details_values['type'], $activity_details_values['confidence']));
              } //foreach closes.
            } //foreach closes.
          } //if closes.
        } //functions if closes.
      } //foreach closes.
      // require_once('C:/xampp/htdocs/MyCrowdSourcing/includes/from_array_to_mysql.inc.php');

      // $myfile = fopen("../uploads/current_userID.txt", "w") or die("Unable to open file!"); //This one right here creates a file in uploads folder with name "current_userID.txt"
      // $txt = $_SESSION['userID']; // This one right here stores the value of the userID to a variable with name $txt.
      // fwrite($myfile, $txt); // This one right here writes in the file the userID of the current user.
      // fclose($myfile); // This one right here closes the file.
      print("<pre>".print_r($locations_array, true)."</pre>");
      // file_put_contents("array.json", json_encode($arr1));
      execInBackground('C:/xampp/php/php.exe C:/xampp/htdocs/MyCrowdSourcing/includes/from_array_to_mysql.inc.php', $_SESSION['userID']);
      // execInBackground('php from_array_to_mysql.inc.php');
      // popen(require_once('from_array_to_mysql.inc.php'), 'e');
    unlink('C:/xampp/htdocs/MyCrowdSourcing/uploads/'.$files); //This one right here deletes the file we just parsed from the directory it has been uploaded.
  } //if closes.
} //when closes.
// print("<pre>".print_r($locations_array, true)."</pre>");
// unset($locations_array);
// unset($activities_array);
// print("<pre>".print_r($activities_details_array, true)."</pre>");
// unset($activities_details_array);

 // header("Location: ../index.php"); //This one right here takes you back to the main page.

?>

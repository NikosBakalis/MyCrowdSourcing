<?php

ini_set('memory_limit', '-1');

if(isset($_POST['from_mysql_to_json'])){
  require 'dbhandler.inc.php';

  $sql = "CALL filter_json(?, ?, ?)";
  $stmt = mysqli_stmt_init($connection);
  if (!mysqli_stmt_prepare($stmt, $sql)) { //This one right here will check if the sql statement above working properly.
    echo "Connection failed!";
    exit();
  }
  else {
    $time_start = '2016-05-03 11:53:49'; //This one right here must be users input.
    $time_end = '2020-05-03 14:36:23'; //This one right here too.
    $activity_types = 'WALKING.STILL.DRIVING.UNKNOWN'; //This one right here too.
    mysqli_stmt_bind_param($stmt, "sss", $time_start, $time_end, $activity_types);
    mysqli_stmt_execute($stmt);

    $result = $stmt->get_result(); //This one right here returns the array result of the $stmt to the $result variable.
    $stmt->free_result();

    $file_unique_name = uniqid('', true);
    $file_with_extension = $file_unique_name.".json";

    $file_for_user = fopen("../downloadable/".$file_with_extension, "w") or die("Unable to open file.");

    $recordObject = new stdClass();
    $recordObject->records = array();

    $compareUserID = "";
    $compareTimestamp_l = "";
    $compareTimestamp_a = "";
    $compareType = "";

    while ($row = $result->fetch_array(MYSQLI_ASSOC)) //This one right here allows us to fetch rows from table associated with the name we gave them on database.
    {
      if ($row['userID'] != $compareUserID) { //This one right here executes if userID change.
        $userObject = new stdClass(); //This one right here creates new object.
        if ($row['userID'] != null) {
          $userObject->userID = $row['userID']; //This one right here creates a new object only if userID changes value.
        }
        $userObject->locations = array();
        $compareUserID = $row['userID'];
        if ($userObject != null) {
          array_push($recordObject->records, $userObject);
        }

        $compareTimestamp_l = "";
      }

      if ($row['timestamp_l'] != $compareTimestamp_l) {
        $locationObject = new stdClass();
        if ($row['timestamp_l'] != null) {
          $locationObject->timestamp_l = $row['timestamp_l'];
        }
        if ($row['latitude'] != null) {
          $locationObject->latitude = $row['latitude'];
        }
        if ($row['longitude'] != null) {
          $locationObject->longitude = $row['longitude'];
        }
        if ($row['accuracy'] != null) {
          $locationObject->accuracy = $row['accuracy'];
        }
        if ($row['heading'] != null) {
          $locationObject->heading = $row['heading'];
        }
        if($row['vertical_accuracy'] != null){
          $locationObject->vertical_accuracy = $row['vertical_accuracy'];
        }
        if ($row['velocity'] != null) {
          $locationObject->velocity = $row['velocity'];
        }
        $locationObject->activity = array();
        $compareTimestamp_l = $row['timestamp_l'];
        if ($locationObject != null) {
          array_push($userObject->locations, $locationObject);
        }

        $compareTimestamp_a = "";
      }

      if ($row['timestamp_a'] != $compareTimestamp_a) {
        $activityObject = new stdClass();
        if ($row['timestamp_a'] != null) {
          $activityObject->timestamp_a = $row['timestamp_a'];
        }
        $activityObject->activity = array();
        $compareTimestamp_a = $row['timestamp_a'];
        if ($activityObject != null) {
          array_push($locationObject->activity, $activityObject);
        }

        $compareType = "";
      }

      if ($row['type'] != $compareType) {
        $detailObject = new stdClass();
        if ($row['type'] != null) {
          $detailObject->type = $row['type'];
        }
        if ($row['confidence']) {
          $detailObject->confidence = $row['confidence'];
        }
        $compareType = $row['type'];
        if ($detailObject != null) {
          array_push($activityObject->activity, $detailObject);
        }
      }
    }
    // echo json_encode($recordObject, JSON_PRETTY_PRINT); //This one right here echos the $recordObject in html.
    // $pieces = str_split(json_encode($recordObject, JSON_PRETTY_PRINT), 1024 * 4);
    // foreach ($pieces as $piece) {
    //     fwrite($file_for_user, $piece, strlen($piece));
    // }
    fwrite($file_for_user, json_encode($recordObject, JSON_PRETTY_PRINT)); //This one right here writes into the file. /* This one right here also gets error when it comes to realy big files. Try to break fwrite to smaller pieces like above */

    fclose($file_for_user); //This one right here closes the file.
  }

  /* Here I have to add the file download code! */
  if (!empty($file_with_extension) && file_exists('../downloadable/'.$file_with_extension)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/json');
    header('Content-Disposition: attachment; filename="'.basename($file_with_extension));
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: '.filesize('../downloadable/'.$file_with_extension));
    readfile('../downloadable/'.$file_with_extension);
    //fgets('../downloadable/'.$file_with_extension);
    unlink('../downloadable/'.$file_with_extension); //This one right here deletes the file we just parsed from the directory it has been uploaded.
    exit;
  }

}
else { //This one right here sent the curious user back to home when he tries to enter the include page in other way that from the button I mentioned on lines 3-4-5-6.
  header("Location: ../index.php");
  exit();
}

?>

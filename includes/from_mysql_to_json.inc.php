<?php

if(isset($_POST['from_mysql_to_json'])){
  require 'dbhandler.inc.php';

  $sql = "CALL filter_json(?, ?, ?)";
  $stmt = mysqli_stmt_init($connection);
  if (!mysqli_stmt_prepare($stmt, $sql)) { //This one right here will check if the sql statement above working properly.
    echo "Connection failed!";
    exit();
  }
  else {
    $time_start = '2018-05-03 11:53:49'; //This one right here must be users input.
    $time_end = '2018-05-03 14:36:23'; //This one right here too.
    $activity_types = 'WALKING.STILL.DRIVING.UNKNOWN'; //This one right here too.
    mysqli_stmt_bind_param($stmt, "sss", $time_start, $time_end, $activity_types);
    mysqli_stmt_execute($stmt);

    $result = $stmt->get_result(); //This one right here returns the array result of the $stmt to the $result variable.
    $stmt->free_result();

    $file_for_user = fopen("file_for_user.json", "w") or die("Unable to open file.");

    $recordObject = new stdClass();

    $userObject = new stdClass();

    $locationObject = new stdClass();
    $locationObject->timestamp_l = $row['timestamp_l'];
    $locationObject->latitude = $row['latitude'];
    $locationObject->longitude = $row['longitude'];
    $locationObject->accuracy = $row['accuracy'];
    

    $activityObject = new stdClass();
    $activityObject->timestamp_a = $row['timestamp_a'];
    $activityObject->activity = array();

    $detailObject = new stdClass();
    $detailObject->type = $row['type'];
    $detailObject->confidence = $row['confidence'];


    while ($row = $result->fetch_array(MYSQLI_ASSOC)) //This one right here allows us to fetch rows from table associated with the name we gave them on database.
    {
        $output = $row['userID']." ".$row['timestamp_l']." ".$row['latitude']." ".$row['longitude']." ".$row['accuracy']." ".$row['heading']." ".$row['vertical_accuracy']." ".$row['velocity']." "
        .$row['altitude']." ".$row['timestamp_a']." ".$row['type']." ".$row['confidence'];
        echo "<br>";

        echo json_encode($row, JSON_PRETTY_PRINT);
        fwrite($file_for_user, json_encode($row, JSON_PRETTY_PRINT));
        fwrite($file_for_user, "\n");


    }
    fclose($file_for_user);
  }
}
else { //This one right here sent the curious user back to home when he tries to enter the include page in other way that from the button I mentioned on lines 3-4-5-6.
  header("Location: ../index.php");
  exit();
}

?>

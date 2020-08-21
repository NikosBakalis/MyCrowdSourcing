<?php

session_start();

include 'dbhandler.inc.php';

if (!empty($_SESSION['userID'])) {
  $current_userID = $_SESSION['userID'];

  $dates_array = array();

  $sql1 = "SELECT latest_upload FROM user WHERE id = '$current_userID'";
  $sql2 = "SELECT timestamp_l FROM location WHERE userID = '$current_userID' ORDER BY timestamp_l";
  $stmt = mysqli_stmt_init($connection);
  if (!mysqli_stmt_prepare($stmt, $sql1) || !mysqli_stmt_prepare($stmt, $sql2)) { //This one right here will check if the sql statement above working properly.
    echo "Connection failed!";
    exit();
  }
  else{
    $result1 = mysqli_query($connection, $sql1);
    if ($result1->num_rows > 0) {
      echo "Your latest upload was:<br>";
      while($row = $result1->fetch_assoc()) {
        echo "<br>" . $row['latest_upload'];
      }
      $result2 = mysqli_query($connection, $sql2);
      if ($result2->num_rows > 0) {
        echo "<br><br><br>And refers to dates:<br>";
        while($row = $result2->fetch_assoc()) {
          // echo "string";
          array_push($dates_array, $row['timestamp_l']);
        }
        echo "<br>From: " . $dates_array[0] . "<br>To: " . end($dates_array);
      }
    } else {
      echo "You don't seem to have uploaded anything yet...<br>To do so use the button above!";
    }
  }
}

?>

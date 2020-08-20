<?php

session_start();

include 'dbhandler.inc.php';

$current_userID = $_SESSION['userID'];

$sql1 = "SELECT * FROM activity_details WHERE userID = '$current_userID' AND (type = 'ON_BICYCLE' OR type = 'ON_FOOT' OR type = 'WALKING' OR type = 'RUNNING')";
$sql2 = "SELECT * FROM activity_details WHERE userID = '$current_userID'";
$stmt = mysqli_stmt_init($connection);
if (!mysqli_stmt_prepare($stmt, $sql1) || !mysqli_stmt_prepare($stmt, $sql2)) { //This one right here will check if the sql statement above working properly.
  echo "Connection failed!";
  exit();
}
else{
  $result1 = mysqli_query($connection, $sql1);
  $resultCheck1 = mysqli_num_rows($result1);
  $result2 = mysqli_query($connection, $sql2);
  $resultCheck2 = mysqli_num_rows($result2);

  if ($resultCheck2 > 0) {
    if ($resultCheck1 / $resultCheck2 > 0.25) {
      echo "Good effort! Your ECO score is: " . round(($resultCheck1 / $resultCheck2), 4) * 100 . "%.";
    } else if ($resultCheck = ($resultCheck1 / $resultCheck2) > 0.50) {
      echo "AMAZING!!! Your ECO score is: " . round(($resultCheck), 4) * 100 . "%.";
    } else {
      echo "Your ECO score is: " . round(($resultCheck1 / $resultCheck2), 4) * 100 . "%. You can do better than that!";
    }
    $sql3 = "UPDATE user SET eco_score = round(($resultCheck1 / $resultCheck2), 4) * 100 WHERE id = ?";
    if (!mysqli_stmt_prepare($stmt, $sql3)) { //This one right here will check if the sql statement above working properly.
      echo "Connection failed!";
      exit();
    } else { //This one right here is called if the sql statement is working properly and executes it.
      mysqli_stmt_bind_param($stmt, "s", $current_userID);
      mysqli_stmt_execute($stmt);
    }
  } else {
    echo "It seems you don't have an ECO score yet. Please upload your data first!";
  }
}

// echo json_encode($big_array);

?>

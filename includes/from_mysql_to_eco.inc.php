<?php

session_start();

include 'dbhandler.inc.php';

$sql1 = "SELECT * FROM activity_details WHERE type = 'ON_BICYCLE' OR type = 'ON_FOOT' OR type = 'WALKING' OR type = 'RUNNING'";
$sql2 = "SELECT * FROM activity_details";
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
    if ($resultCheck = ($resultCheck1 / $resultCheck2) > 0.25) {
      echo "Good effort! Your ECO score is: " . round(($resultCheck1 / $resultCheck2), 4) * 100 . "%.";
    } else if ($resultCheck = ($resultCheck1 / $resultCheck2) > 0.50) {
      echo "AMAZING!!! Your ECO score is: " . round(($resultCheck), 4) * 100 . "%.";
    } else {
      echo "Your ECO score is: " . round(($resultCheck1 / $resultCheck2), 4) * 100 . "%. You can do better than that!";
    }
  }
}

// echo json_encode($big_array);

?>

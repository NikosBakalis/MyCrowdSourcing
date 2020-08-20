<?php

session_start();

include 'dbhandler.inc.php';

if (!empty($_SESSION['userID'])) {
  $current_userID = $_SESSION['userID'];

  $sql1 = "SELECT * FROM activity_details WHERE userID = '$current_userID' AND (type = 'ON_BICYCLE' OR type = 'ON_FOOT' OR type = 'WALKING' OR type = 'RUNNING') AND (MONTH(timestamp_l) = MONTH(CURRENT_DATE()) AND YEAR(timestamp_l) = YEAR(CURRENT_DATE()))";
  $sql2 = "SELECT * FROM activity_details WHERE userID = '$current_userID' AND MONTH(timestamp_l) = MONTH(CURRENT_DATE()) AND YEAR(timestamp_l) = YEAR(CURRENT_DATE())";
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
        echo "Good effort! <br> Your ECO score is: " . round(($resultCheck1 / $resultCheck2), 4) * 100 . "%.";
      } else if ($resultCheck = ($resultCheck1 / $resultCheck2) > 0.50) {
        echo "AMAZING!!! <br> Your ECO score is: " . round(($resultCheck), 4) * 100 . "%.";
      } else {
        echo "Your ECO score is: " . round(($resultCheck1 / $resultCheck2), 4) * 100 . "%. <br> You can do better than that!";
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
      echo "It seems you don't have an ECO score for the current month.<br>Please upload more recent data!";
    }
  }
  $sql4 = "SELECT * FROM user ORDER BY eco_score DESC LIMIT 3";
  if (!mysqli_stmt_prepare($stmt, $sql4)) { //This one right here will check if the sql statement above working properly.
    echo "Connection failed!";
    exit();
  } else {
    $result4 = mysqli_query($connection, $sql4);
    if ($result4->num_rows > 0) {
      $placement = 1;
      echo "<br><br><br>Most ECO friendly users of month below:<br>";
      while($row = $result4->fetch_assoc()) {
        $firstLetter = substr($row['lastname'], 0, 1);
        echo "<br>". $placement . ": " . $row["firstname"] . " " . $firstLetter . ". " . $row['eco_score'] . "%";
        $placement = $placement + 1;
      }
    } else {
      echo "0 results";
    }
  }
}

?>

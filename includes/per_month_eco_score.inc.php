<?php

session_start();

include 'dbhandler.inc.php';

$monthArray = array();
$percentageArray = array();
$bothArray = array();

$current_userID = $_SESSION['userID'];
for ($i=0; $i < 12; $i++) {
  // echo $i . "\n";
  // echo "<span class='form-success'>Success!</span>"; // This one right here echo this message if the input is not empty.
  $sql1 = "SELECT * FROM activity_details
  WHERE YEAR(timestamp_l) = YEAR(CURRENT_DATE - INTERVAL $i MONTH)
  AND MONTH(timestamp_l) = MONTH(CURRENT_DATE - INTERVAL $i MONTH)
  AND userID = '$current_userID'
  AND (type = 'ON_BICYCLE' OR type = 'ON_FOOT' OR type = 'WALKING' OR type = 'RUNNING')"; // This one right here selects everything from activity_details table. I want only the count but I will retrieve it with mysqli_num_rows() function.
  $sql2 = "SELECT * FROM activity_details WHERE userID = '$current_userID' AND MONTH(timestamp_l) = MONTH(CURRENT_DATE() - INTERVAL $i MONTH) AND YEAR(timestamp_l) = YEAR(CURRENT_DATE() - INTERVAL $i MONTH)";
  $stmt = mysqli_stmt_init($connection);
  if (!mysqli_stmt_prepare($stmt, $sql1)) { //This one right here will check if the sql statement above working properly.
    echo "Connection failed!";
    exit();
  }
  else{
    $result1 = mysqli_query($connection, $sql1); // This one right here stores the query into a variable.
    $resultCheck1 = mysqli_num_rows($result1); // This one right here stores the mysqli_num_rows() into a variable.
    $result2 = mysqli_query($connection, $sql2); // This one right here stores the query into a variable.
    $resultCheck2 = mysqli_num_rows($result2); // This one right here stores the mysqli_num_rows() into a variable.
    if ($resultCheck2 > 0) {
      $score = round(($resultCheck1 / $resultCheck2), 4) * 100;
      array_push($percentageArray, $score);
      while ($row = mysqli_fetch_assoc($result2)) {
        $timestamp_a = $row["timestamp_a"];
        $monthNumber = date("m", strtotime($timestamp_a));
        $monthLetter = date("F", strtotime($timestamp_a));
        // echo $monthLetter;
        if(!in_array($monthLetter, $monthArray, true)){
          array_push($monthArray, $monthLetter);
        }
      }
    } else {
      // echo $resultCheck1;
      $score = 0.00;
      array_push($percentageArray, $score);
      // code...
    }
  }
}
$monthArray = array_reverse($monthArray);
$bothArray['monthArray'] = $monthArray;
// $bothArray['monthArray'] = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
$percentageArray = array_reverse($percentageArray);
$bothArray['percentageArray'] = $percentageArray;
// print_r($bothArray);
// $bothArray['percentageArray'] = [1, 2];
echo json_encode($bothArray); // This one right here encodes both array to a JSON.

?>

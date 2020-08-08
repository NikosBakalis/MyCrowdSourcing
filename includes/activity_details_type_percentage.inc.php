<?php

include 'dbhandler.inc.php';

// if (isset($_POST['type_of_activity'])) { // This one right here checks if we are here from the 'type_of_activity' button in frontend.
//   $name = $_POST['type_of_activity']; // This one right here stores the value that the user inserted into a variable.
$name = "no";
$typeArray = array();
$percentageArray = array();
$bothArray = array();
// $array['key1'] = 'one';
// $array['key2'] = 'two';

  // $error_empty = false;

  if (empty($name)) { // This one right here checks if the input of the user is empty.
    echo "<span class='form-error'>Fill in all fields!</span>"; // This one right here echo this message if the input is empty.
    // $error_empty = true;
  } elseif (!empty($name)) { // This one right here checjs if the input of the user is not empty.
    // echo "<span class='form-success'>Success!</span>"; // This one right here echo this message if the input is not empty.
    $sql_1 = "SELECT * FROM activity_details"; // This one right here selects everything from activity_details table. I want only the count but I will retrieve it with mysqli_num_rows() function.
    $sql_3 = "SELECT DISTINCT type FROM activity_details";
    $stmt = mysqli_stmt_init($connection);
    if (!mysqli_stmt_prepare($stmt, $sql_1) || !mysqli_stmt_prepare($stmt, $sql_3)) { //This one right here will check if the sql statement above working properly.
      echo "Connection failed!";
      exit();
    }
    else{
      $result_1 = mysqli_query($connection, $sql_1); // This one right here stores the query into a variable.
      $resultCheck_1 = mysqli_num_rows($result_1); // This one right here stores the mysqli_num_rows() into a variable.
      $result_3 = mysqli_query($connection, $sql_3); // This one right here stores the query into a variable.
      while($resultCheck_3 = mysqli_fetch_array($result_3)){
        $name = $resultCheck_3["type"];
        $sql_2 = "SELECT * FROM activity_details WHERE type = '$name'"; // This one right here selects everything from activity_details table where type is something that the admin choose in frontend. I want only the count but I will retrieve it with mysqli_num_rows() function.
        $result_2 = mysqli_query($connection, $sql_2); // This one right here stores the query into a variable.
        $resultCheck_2 = mysqli_num_rows($result_2); // This one right here stores the mysqli_num_rows() into a variable.
        // echo "<tr>";
        // echo "<td>" . $resultCheck_3["type"] . "</td>";
        // echo "<td>" . ($resultCheck_2 / $resultCheck_1) * 100 . "%" . "</td>"; // This one right here echos the activity_percentage of the specific activity the user entered before.
        // echo "</tr>";
        array_push($typeArray, $resultCheck_3["type"]);
        array_push($percentageArray, ($resultCheck_2 / $resultCheck_1) * 100);
      }
      // print_r($typeArray);
      // echo json_encode($typeArray);
      // print_r($percentageArray);
      // echo json_encode($percentageArray);
      $bothArray['typeArray'] = $typeArray;
      $bothArray['percentageArray'] = $percentageArray;
      echo json_encode($bothArray);
    }
  }

  // echo $float_latitide;
// } else { //This one right here sent the curious user back to home when he tries to enter the include page in other way that from the button I mentioned on line 5.
//   echo "There was an error!";
// }

?>

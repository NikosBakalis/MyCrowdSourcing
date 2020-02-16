<?php

session_start();

include 'dbhandler.inc.php';

if (isset($_POST['start_datetime']) || $_POST['end_datetime']) {
  $name = $_POST['start_datetime'];
  echo $name;
  $another_name = $_POST['end_datetime'];
  echo $another_name;

  $error_empty = false;

  if (empty($name) || empty($another_name)) {
    echo "<span class='form-error'>Fill in all fields!</span>";
    $error_empty = true;
  } else {
    echo "<span class='form-success'>Success!</span>";
  }

  if (!empty($name) && !empty($another_name)) {
    $sql = "SELECT * FROM location WHERE timestamp_l > '$name' AND timestamp_l < '$another_name'";
    $stmt = mysqli_stmt_init($connection);
    if (!mysqli_stmt_prepare($stmt, $sql)) { //This one right here will check if the sql statement above working properly.
      echo "Connection failed!";
      exit();
    }
    else{
      $result = mysqli_query($connection, $sql);
      $resultCheck = mysqli_num_rows($result);

      if ($resultCheck > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
          echo $row['latitude'] . '<br>';
          // $float_latitide = floatval($row['latitude']);
        }
      }
    }
  }

  // echo $float_latitide;
} else {
  echo "There was an error!";
}

?>

<script>
  var error_empty = "<?php echo $error_empty; ?>";
  if(error_empty == true){
    $("#start_datetime, #end_datetime").addClass("input-error");
  }// else {
  //   $("#start_datetime, #end_datetime").val("");
  // }
</script>

<?php

function execInBackground($cmd) {
  $descriptorspec = array(
     0 => array("pipe", "r"),  // stdin is a pipe that the child will read from
     1 => array("pipe", "w"),  // stdout is a pipe that the child will write to
     2 => array("pipe", "w")   // stderr is a file to write to
  );
  $pipes = array();
  if(substr(php_uname(), 0, 7) == "Windows"){
    $process = /*pclose(*/proc_open($cmd, $descriptorspec, $pipes)/*)*/;
  }
  else {
    exec($cmd . " > /dev/null &");
  }
}

// if (isset($_POST['submit_file'])) { //This one right here checks if the user came here from the submit button.
  $file = $_FILES['upload_file']; //This one right here stores the uploaded file to $file variable.

  //print_r($file); //This one right here provides us the 'info' we use right below.
  $file_name = $file['name']; //This one right here stores the name of the file to $file_name variable.
  $file_tmp_name = $file['tmp_name']; //You can...
  $file_size = $file['size']; //get this...
  $file_error = $file['error']; //by your...
  $file_type = $file['type']; //own.

  $file_extension = explode('.', $file_name); //This one right here give us the extension of the file that the user uploaded.
  $file_actual_extension = strtolower(end($file_extension)); //This one right here lowercase all the letters of the extension so as to get what we want.

  $allowed_extensions = array('json', 'zip'); //This one right here is an array with all the file extensions that users can upload.

  if (in_array($file_actual_extension, $allowed_extensions)) { //This one right here checks if the extension of the file that the user uploaded is valid.
    switch ($file_actual_extension) {
      case 'zip':
        // This one right here will be the code for zip case.
        break;

      case 'json':
        if ($file_error === 0) { //This one right here checks for more errors through the upload.
          if ($file_size <= 524288000) { //This one right here limits the size of the file that the user wants yo upload. 1,073,741,824 = exactly 1GB, and 524,288,000 = exactly 500MB.
            $file_name_new = uniqid('', true).".".$file_actual_extension; //This one right here renames the file that the user wants to upload to something unique so as to avoid having more than one file with the same name.
            $file_destination = '../uploads/'.$file_name_new; //This one right here finally uploads the file to the destination we want to.

            move_uploaded_file($file_tmp_name, $file_destination); //This one right here moves the uploaded file from temporary location to the location we want to.
            // include('from_json_to_mysql_with_json_decode.inc.php');
            include('from_json_to_mysql_with_json_machine.inc.php');
            echo "1";
            // execInBackground('php C:\xampp\htdocs\MyCrowdSourcing\includes\from_json_to_mysql_with_json_machine.inc.php');
            // execInBackground('php C:\xampp\htdocs\MyCrowdSourcing\includes\from_mysql_to_heatmap');
            echo "string";
            //include('from_json_to_array_with_json_machine.inc.php');
          }
          else {
            echo "Your file is too big!";
            header("Location: ../index.php?upload=fail");
          }
        }
        else {
          echo "There was an error uploading your file!";
          header("Location: ../index.php?upload=fail");
        }
      }
    }
    else {
      echo "You can't upload files of this type!";
      header("Location: ../index.php?upload=fail");
    }
  // }
  // else { //This one right here sent the curious user back to home when he tries to enter the include page in other way that from the button I mentioned on lines 19-20-21-22.
    header("Location: ../index.php");
  //   exit();
  // }

?>

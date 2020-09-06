<?php

function encrypt($decrepted_string, $encrytion_key){ //This one right here is the encryptment function we use on line 77 to encrypt users ID.
  $ciphering = "AES-128-CTR";
  $options = 0;
  $encryption_iv = '1234567891011121';
  $string = openssl_encrypt($decrepted_string, $ciphering, $encrytion_key, $options, $encryption_iv);
  return $string;
}

function decrypt($encrypted_string, $decryption_key){ //This one right here is the decryptment function and we don't actually use it yet.
  $ciphering = "AES-128-CTR";
  $options = 0;
  $decryption_iv = '1234567891011121';
  $string = openssl_decrypt ($encrypted_string, $ciphering, $decryption_key, $options, $decryption_iv);
  return $string;
}

function password_security($tested_password){ // This one right here is the security checker of the password.
  $isSecured = false;
  $contains_letter = preg_match('/[a-zA-Z]/', $tested_password);
  $contains_capital = preg_match('/[A-Z]/', $tested_password);
  $contains_digit = preg_match('/\d/', $tested_password);
  $contains_special = preg_match('/[^a-zA-Z\d]/', $tested_password);

  $contains_all = $contains_letter && $contains_capital && $contains_digit && $contains_special;

  if (strlen($tested_password) >= 8 && $contains_all == "1") {
    $isSecured = true;
  }
  return $isSecured;
}

/* This one right here we will chech if the user entered
this sections using the submit button
If that's true then we will let him continue
else he will not see a thing!*/
if (isset($_POST['signup_submit'])) {
  require 'dbhandler.inc.php';

  $firstname = $_POST['firstname'];
  $lastname = $_POST['lastname'];
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $repassword = $_POST['repassword'];

  if (empty($firstname) || empty($lastname) || empty($username) || empty($email) || empty($password) || empty($repassword)) { //This one right here checks if the user has left any blank value.
    header("Location: ../signup.php?error=empty_fields&firstname=".$firstname."&lastname=".$lastname."&username=".$username."&email=".$email);
    exit();
  }
  else if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username)) { // This one right here checks both email and username situation (look next two if statements for more info).
    header("Location: ../signup.php?error=invalid_username_and_email&firstname=".$firstname."&lastname=".$lastname);
    exit();
  }
  else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { //This one right here checks the validation and the relibility af an e-mail.
    header("Location: ../signup.php?error=invalid_email&firstname=".$firstname."&lastname=".$lastname."&username=".$username);
    exit();
  }
  else if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) { //This one right here checks the usernames symbols.
    header("Location: ../signup.php?error=invalid_username&firstname=".$firstname."&lastname=".$lastname."&email=".$email);
    exit();
  }
  else if (!password_security($password)) { //This one right here checks the security of the password.
    header("Location: ../signup.php?error=password_too_simple&firstname=".$firstname."&lastname=".$lastname."&username=".$username."&email=".$email);
  }
  else if ($password !== $repassword) { //This one right here checks the similarity of password and confirm password.
    header("Location: ../signup.php?error=password_check_failed&firstname=".$firstname."&lastname=".$lastname."&username=".$username."&email=".$email);
    exit();
  }
  else { //This one right here checks if the email of the user is already used in the database.
    $sql = "SELECT email FROM user WHERE email=?";
    $stmt = mysqli_stmt_init($connection);
    $sql1 = "SELECT username FROM user WHERE username=?";
    $stmt1 = mysqli_stmt_init($connection);
    if (!mysqli_stmt_prepare($stmt, $sql) || !mysqli_stmt_prepare($stmt1, $sql1)) { //This one right here will check if the sql statement above working properly.
      header("Location: ../signup.php?error=sql_error");
      exit();
    }
    else { //This one right here is called if the sql statement is working properly and executes it.
      mysqli_stmt_bind_param($stmt, "s", $email);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_store_result($stmt); //This one right here fecthes info from the database and thats why we dont use it again down after line 86.
      mysqli_stmt_bind_param($stmt1, "s", $username);
      mysqli_stmt_execute($stmt1);
      mysqli_stmt_store_result($stmt1); //This one right here fecthes info from the database and thats why we dont use it again down after line 86.
      $resultCheck = mysqli_stmt_num_rows($stmt);
      $resultCheck1 = mysqli_stmt_num_rows($stmt1);
      if ($resultCheck > 0 || $resultCheck1 > 0) {
        header("Location: ../signup.php?error=user_already_taken&firstname=".$firstname."&lastname=".$lastname."&username=".$username);
        exit();
      }
      else { //This one right here checks if the email of the user is already used in the database again.
        $sql = "INSERT INTO user(id, firstname, lastname, username, email, pwd) VALUES(?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_stmt_init($connection);
        if (!mysqli_stmt_prepare($stmt, $sql)) { //This one right here will check if the sql statement above working properly again.
          header("Location: ../signup.php?error=sql_error");
          exit();
        }
        else { //This one right here is called if the sql statement is working properly and executes it again.
          $encryptedID = encrypt($email, $password);
          $hashedPassword = password_hash($password, PASSWORD_DEFAULT); //BUT FIRST!!! This one right here hashes the password on bcrypt Andrea cuz its fucking awesome and way better than SHA-256 :P :P.
          mysqli_stmt_bind_param($stmt, "ssssss", $encryptedID, $firstname, $lastname, $username, $email, $hashedPassword);
          mysqli_stmt_execute($stmt);
          header("Location: ../signup.php?signup=success");
          exit();
        }
      }
    }
    mysqli_stmt_close($stmt); //This one right here closes the statement.
    mysqi_close($connection); //This one right here closes the connection.
  }
}
else { //This one right here sent the curious user back to home when he tries to enter the include page in other way that from the button I mentioned on lines 19-20-21-22.
  header("Location: ../signup.php");
  exit();
}

?>

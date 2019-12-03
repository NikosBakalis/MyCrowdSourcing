<?php

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
  else if ($password !== $repassword) { //This one right here checks the similarity of password and confirm password.
    header("Location: ../signup.php?error=password_check_failed&firstname=".$firstname."&lastname=".$lastname."&username=".$username."&email=".$email);
    exit();
  }
  else { //This one right here checks if the email of the user is already used in the database.
    $sql = "SELECT email FROM users WHERE email=?";
    $stmt = mysqli_stmt_init($connection);
    if (!mysqli_stmt_prepare($stmt, $sql)) { //This one right here will check if the sql statement above working properly.
      header("Location: ../signup.php?error=sql_error");
      exit();
    }
    else { //This one right here is called if the sql statement is working properly and executes it.
      mysqli_stmt_bind_param($stmt, "s", $email);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_store_result($stmt); //This one right here fecthes info from the database and thats why we dont use it again down after line 63.
      $resultCheck = mysqli_stmt_num_rows($stmt);
      if ($resultCheck > 0) {
        header("Location: ../signup.php?error=user_already_taken&firstname=".$firstname."&lastname=".$lastname."&username=".$username);
        exit();
      }
      else { //This one right here checks if the email of the user is already used in the database again.
        $sql = "INSERT INTO users(firstname, lastname, username, email, pwd) VALUES(?, ?, ?, ?, ?)";
        $stmt = mysqli_stmt_init($connection);
        if (!mysqli_stmt_prepare($stmt, $sql)) { //This one right here will check if the sql statement above working properly again.
          header("Location: ../signup.php?error=sql_error");
          exit();
        }
        else { //This one right here is called if the sql statement is working properly and executes it again.
          $hashedPassword = password_hash($password, PASSWORD_DEFAULT); //BUT FIRST!!! This one right here hashes the password on bcrypt Andrea cuz its fucking awesome and way better than SHA-256 :P :P.
          mysqli_stmt_bind_param($stmt, "sssss", $firstname, $lastname, $username, $email, $hashedPassword);
          mysqli_stmt_execute($stmt);
          header("Location: ../signup.php?signup=success");
          exit();
        }
      }
    }
  }
  mysqli_stmt_close($stmt); //This one right here closes the statement.
  mysqi_close($connection); //This one right here closes the connection.
}
else { //This one right here sent the curious user back to home when he tries to enter the include page in other way that from the button I mentioned on lines 3-4-5-6.
  header("Location: ../signup.php");
  exit();
}

?>

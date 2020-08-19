<?php
  include 'header.php';
?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/signup.css">
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <main>
      <div class="signup_box">
        <h2>Signup form</h2>
          <?php
            if(isset($_GET['error'])){
              if($_GET['error'] == "empty_fields"){
                echo '<p class="signup_error">Please fill all fields!</p>';
              }
              else if($_GET['error'] == "invalid_username_and_email"){
                echo '<p class="signup_error">Invalid username and e-mail address!</p>';
              }
              else if($_GET['error'] == "invalid_email"){
                echo '<p class="signup_error">Invalid e-mail address!</p>';
              }
              else if($_GET['error'] == "invalid_username"){
                echo '<p class="signup_error">Invalid username!</p>';
              }
              else if($_GET['error'] == "password_too_simple"){
                echo '<p class="signup_error">Password too simple! Use at least 8 character that contains at least one Letter, one Digit and one Special!</p>';
              }
              else if($_GET['error'] == "password_check_failed"){
                echo '<p class="signup_error">Password and Confirm-Password do not match!</p>';
              }
              else if($_GET['error'] == "sql_error"){
                echo '<p class="signup_error">!!!DATABASE ERROR!!!</p>';
              }
              else if($_GET['error'] == "user_already_taken"){
                echo '<p class="signup_error">There is already a user with that username or e-mail address!</p>';
              }
              else {
                echo '<p class="signup_error">Unknown error!</p>';
              }
            }
            else if (isset($_GET['signup']) == "success") {
              echo '<p style="color:green;"class="signup_success">Signup successful!</p>';
            }
          ?>
        <form action="includes/signup.inc.php" method="post">
          <input type="text" name="firstname" placeholder="Firstname...">
          <input type="text" name="lastname" placeholder="Lastname...">
          <input type="text" name="username" placeholder="Username...">
          <input type="text" name="email" placeholder="Email...">
          <input type="password" name="password" placeholder="Password...">
          <input type="password" name="repassword" placeholder="Confirm Password...">
          <button type="submit" name="signup_submit">Signup</button>
        </form>
      </div>
      <div class="message">
        <p>You are logged in!</p>
        <p>You are logged out!</p>
      </div>
    </main>
</body>
</html>


<?php
  include 'footer.php';
?>

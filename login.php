<?php
  include 'header.php';
?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/login.css">
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <main>
      <div class="login_box">
        <h1>Login form</h2>
          <?php
            if(isset($_GET['error'])){
              if($_GET['error'] == "empty_fields"){
                echo '<p class="login_error">Please fill all fields!</p>';
              }
              else if($_GET['error'] == "wrong_password"){
                echo '<p class="login_error">Wrong password!</p>';
              }
              else if($_GET['error'] == "sql_error"){
                echo '<p class="login_error">!!!DATABASE ERROR!!!</p>';
              }
              else if($_GET['error'] == "no_user"){
                echo '<p class="login_error">There is no user with that e-mail address!</p>';
              }
              else {
                echo '<p class="login_error">Unknown error!</p>';
              }
            }
          ?>
        <form action="includes/login.inc.php" method="post">
          <input type="text" name="username_or_email" placeholder="Username or e-mail...">
          <input type="password" name="password" placeholder="Password...">
          <button type="submit" name="login_submit">Login</button>
        </form>
        <a href="signup.php">Signup</a>
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

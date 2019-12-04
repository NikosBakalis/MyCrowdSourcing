<?php

  session_start();

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/header.css">
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <div class="header">
      <div class="image_earth"></div>
      <div class="login_logout">
        <?php
          if (isset($_SESSION['userID'])) { //This one right here checks if we have a session with a user and fetches the appropriate message.
            echo '<a href="includes/logout.inc.php">Logout</a>';
          } else {
            echo '<a href="login.php">Login/Signup</a>';
          }
        ?>
      </div>
      <div class="inner_header">
        <div class="logo_container">
          <h1><span>MY</span>CROWDSOURCING</h1>
        </div>
        <ul class="navigation">
          <a href="index.php"><li>Home</li></a>
          <a href="#"><li>About us</li></a>
          <a href="#"><li>Services</li></a>
          <a href="#"><li>Profile</li></a>
        </ul>
      </div>
    </div>
  </body>
</html>

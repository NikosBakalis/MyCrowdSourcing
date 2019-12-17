<?php
  include 'header.php';
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>
    <link rel="stylesheet" type="text/css" href="css/services.css">
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <div class="services_section">
      <div class="inner_width">
        <h1 class="section_title">Services</h1>
        <div class="border"></div>
        <div class="services_container">
          <div class="service_box">
            <div class="service_icon">
              <i class="fa fa-home"></i>
            </div>
            <div class="service_title">
              Log-In/Sign-Up
            </div>
            <div class="service_description">
              To use our services you must own an account on our platform. If you don't, feal free to
              <a  href="signup.php"> register</a>.
              Since you create your account you ought to move to the next step and upload your files!
            </div>
          </div>
          <div class="service_box">
            <div class="service_icon">
              <i class="fa fa-upload"></i>
            </div>
            <div class="service_title">
              File Upload
            </div>
            <div class="service_description">
              As long as you own an account on our platform you can upload your Google
              Location History JSON, that you will retrieve:
              <a  href="https://takeout.google.com">Here </a>.
              Upload this file to our database:
              <a  href="../include/uploads.inc.php"> Here</a>....this might take a while...After that,
              you can refresh our main page and there you can find your heat map!
            </div>
          </div>
          <div class="service_box">
            <div class="service_icon">
              <i class="fas fa-map"></i>
            </div>
            <div class="service_title">
              Heat Maps
            </div>
            <div class="service_description">
              A heatmap is a graphical representation of data that uses a system of color-coding
              to represent different values. Our heatmaps are used to display your behaviour based on
              your Google Location History.
            </div>
          </div>
          <div class="service_box">
            <div class="service_icon">
              <i class="fa fa-area-chart"></i>
            </div>
            <div class="service_title">
              Display Stats
            </div>
            <div class="service_description">
              We also provide you with statistics of your Google Location History behaviour such as:
              your eco score, the period of the file you uploaded, the date of you last upload, etc!
            </div>
          </div>
          <div class="service_box">
            <div class="service_icon">
              <i class="fa fa-search"></i>
            </div>
            <div class="service_title">
              Analyze stats
            </div>
            <div class="service_description">
              Further more we analyze your statistics and we let you order them in various ways like:
              your, locations and activities, ordered by time, day, month, year, type of activity, etc!
            </div>
          </div>
          <div class="service_box">
            <div class="service_icon">
              <i class="fa fa-trash"></i>
            </div>
            <div class="service_title">
              Remove stats
            </div>
            <div class="service_description">
              Finaly, you are capable of removing all the data you uploaded from our database and
              permanently delete them!
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>

<?php
  include 'footer.php';
?>

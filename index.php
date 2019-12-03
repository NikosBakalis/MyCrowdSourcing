<?php
  include 'header.php';
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
    integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
    crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"
    integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="
    crossorigin=""></script>
    <link rel="stylesheet" type="text/css" href="css/index.css">
    <title></title>
  </head>
  <body>
    <section class="main">
      This right here will be the main page of our Website
      <div class="circled_leaflet_map"></div>
      <div class="more_info">
        <div id="top_left">
          Top Left
        </div>
        <div id="top_right">
          Top Right
        </div>
        <div id="bottom_left">
          Bottom Left
        </div>
        <div id="bottom_right">
          Bottom Right
        </div>
      </div>
    </section>
  </body>
</html>


<?php
  include 'footer.php';
?>

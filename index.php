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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/index.css">
    <title></title>
    <style>
      #mapid{
        height: 180px;
      }
    </style>
  </head>
  <body>
    <section class="main">
      This right here will be the main page of our Website
      <div class="circled_leaflet_map">
        <div id="mapid"></div>
      </div>
      <script>
        var mymap = L.map('mapid').setView([51.505, -0.09], 13);

        L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        maxZoom: 18,
        id: 'mapbox/streets-v11',
        accessToken: 'your.mapbox.access.token'
        }).addTo(mymap);

        //const tilesUrl = 'https://a.tile.openstreetmap.org/${z}/${x}/${y}.png';

        //const tiles = L.tileLayer(tileUrl, {attribution});

        //tiles.addTo(map);
      </script>
      <div class="more_info">
        <div id="top_left">
          Top Left
        </div>
        <div id="top_right">
          <?php
            if (isset($_SESSION['userID'])) { //This one right here checks if we have a session with a user and fetches the appropriate message.
              echo '<form action="includes/uploads.inc.php" method="post" enctype="multipart/form-data">
                    <input type="file" name="upload_file">
                    <button type="submit" name="submit_file">UPLOAD</button>
                    </form>';
            } else {
              echo 'Top Right';
            }
          ?>
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

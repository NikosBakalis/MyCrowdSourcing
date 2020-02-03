<?php
  include 'header.php';
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"></script>
    <!-- <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
    integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
    crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"
    integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="
    crossorigin=""></script> -->
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
        <div id="mapid"
          style="width: 900px;
          height: 900px;
          border-radius: 50%;
          position: relative;
          z-index: 500;
          margin: auto">
        </div>
      </div>
      <script>
        var mymap = L.map('mapid').setView([38.230462, 21.753150], 12.5);

        L.tileLayer('https://api.maptiler.com/maps/streets/{z}/{x}/{y}.png?key=jYXMr02JU1RhJCrKJMBl', {
        attribution: '<a href="https://www.maptiler.com/copyright/" target="_blank">&copy; MapTiler</a> <a href="https://www.openstreetmap.org/copyright" target="_blank">&copy; OpenStreetMap contributors</a>'//,
        //minZoom: 14
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
              // echo '<form action="includes/uploads.inc.php" method="post" enctype="multipart/form-data">
              //       <input type="file" name="upload_file">
              //       <button id="submit" type="submit" name="submit_file">UPLOAD</button>
              //       </form>';
              ?>

              <form class="form" id="uploadForm">
                <input type="file" name="upload_file" id="inpFile">
                <input class="button" type="submit" name="submit_file" value="Upload">
              </form>

              <div class="progress_bar" id="progressBar">
                <div class="progress_bar_fill">
                  <span class="progress_bar_text">0%</span>
                </div>
              </div>

              <script>
                const uploadForm = document.getElementById("uploadForm");
                const inpFile = document.getElementById("inpFile");
                const progressBarFill = document.querySelector("#progressBar > .progress_bar_fill");
                const progressBarText = progressBarFill.querySelector(".progress_bar_text");

                uploadForm.addEventListener("submit", uploadFile);

                function uploadFile(e){
                  e.preventDefault();

                  const xhr = new XMLHttpRequest();

                  xhr.open("POST", "includes/uploads.inc.php");
                  // xhr.open("POST", "includes/from_mysql_to_heatmap.inc.php");
                  xhr.upload.addEventListener("progress", e => {
                    const percent = e.lengthComputable ? (e.loaded / e.total) * 100 : 0;

                    progressBarFill.style.width = percent.toFixed(2) + "%";
                    progressBarText.textContent = percent.toFixed(2) + "%";
                  })
                  xhr.setRequestHeader("Content-Type", "multipart/form-data");
                  xhr.send(new FormData(uploadForm));
                  //console.log($targetPath);
                }
              </script>

              <?php
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

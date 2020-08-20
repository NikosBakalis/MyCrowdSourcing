<?php
  include 'header.php';
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"/>
    <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"></script>
    <!-- <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
    integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
    crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"
    integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="
    crossorigin=""></script> -->

    <script src="includes/Leaflet_heat/dist/leaflet-heat.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- <script src="https://github.com/Leaflet/Leaflet.heat/blob/gh-pages/dist/leaflet-heat.js"></script>
    <script src="C:/xampp/htdocs/MyCrowdSourcing/includes/Leaflet.heat/dist/leaflet-heat.js"></script>
    <script src="http://leaflet.github.io/Leaflet.markercluster/example/realworld.10000.js"></script> -->
    <link rel="stylesheet" type="text/css" href="css/index.css">
    <title></title>
  </head>
  <body>
    <section class="main">
      <div class="circled_leaflet_map">
        <table class="map_table">
          <tr>
            <td id="top_left">

                <?php
                if (isset($_SESSION['userID'])) { //This one right here checks if we have a session with a user and fetches the appropriate message.
                  echo '<div id="form_div">
                        <form action="includes/uploads.inc.php" method="post" enctype="multipart/form-data">
                        <input id="file" type="file" name="upload_file">
                        <button id="submit" type="submit" name="submit_file">UPLOAD</button>
                        </form>
                        </div>';
                } else {
                  echo 'You are logged out!
                        Please Login/Signup
                        to upload your crowd sourcing!';
                }
                ?>

            </td>
            <td id="center" rowspan="2">
              <div id="mapid">
              </div>
            </td>
            <td id="top_right">
              <script src="JavaScript/eco.js"></script>
            </td>
          </tr>
          <tr>
            <td id="bot_left">
              <script src="JavaScript/latest_upload_and_datetimes.js"></script>
            </td>
            <td id="bot_right">Bottom Right</td>
          </tr>
          <script src="JavaScript/maps.js"></script>
        </table>
      </div>
      <!-- <script src="http://leaflet.github.io/Leaflet.markercluster/example/realworld.10000.js"></script> -->

      <!-- <div class="more_info">

        <div> -->
          <?php
            // if (isset($_SESSION['userID'])) { //This one right here checks if we have a session with a user and fetches the appropriate message.
            //   echo '<form action="includes/uploads.inc.php" method="post" enctype="multipart/form-data">
            //         <input type="file" name="upload_file">
            //         <button id="submit" type="submit" name="submit_file">UPLOAD</button>
            //         </form>';
              ?>

              <!-- <form class="form" id="upload_form">
                <input type="file" name="upload_file" id="upload_file">
                <input class="button" type="submit" name="submit_file" value="Upload" id="submit_file">
              </form>

              <div class="progress_bar" id="progressBar">
                <div class="progress_bar_fill">
                  <span class="progress_bar_text">0%</span>
                </div>
              </div> -->

              <script>
                // $(document).ready(function() {
                //   $('#submit_file').click(function() {
                //       const upload_form = document.getElementById("upload_form");
                //       const upload_file = document.getElementById("upload_file");
                //       const progressBarFill = document.querySelector("#progressBar > .progress_bar_fill");
                //       const progressBarText = progressBarFill.querySelector(".progress_bar_text");
                //
                //       upload_form.addEventListener("submit", uploadFile);
                //
                //       function uploadFile(e){
                //         e.preventDefault();
                //
                //         const xhr = new XMLHttpRequest();
                //
                //         xhr.open("POST", "includes/uploads.inc.php");
                //         xhr.upload.addEventListener("progress", e => {
                //           const percent = e.lengthComputable ? (e.loaded / e.total) * 100 : 0;
                //
                //           progressBarFill.style.width = percent.toFixed(2) + "%";
                //           progressBarText.textContent = percent.toFixed(2) + "%";
                //         })
                //        // xhr.setRequestHeader("Content-Type", "multipart/form-data");
                //         xhr.send(new FormData(upload_form));
                //       }
                //   });
                // });
              </script>

              <?php
            // } else {
            //   echo 'Top Right';
            // }
          ?>
        <!-- </div> -->

      <!-- </div> -->
    </section>
  </body>
</html>


<?php
  include 'footer.php';
?>

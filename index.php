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

      <script src="http://leaflet.github.io/Leaflet.markercluster/example/realworld.10000.js"></script>
      <script>
        var map = L.map('mapid').setView([38.230462, 21.753150], 12);

        var tiles = L.tileLayer('https://api.maptiler.com/maps/streets/{z}/{x}/{y}.png?key=jYXMr02JU1RhJCrKJMBl', {
          attribution: '<a href="https://www.maptiler.com/copyright/" target="_blank">&copy; MapTiler</a> <a href="https://www.openstreetmap.org/copyright" target="_blank">&copy; OpenStreetMap contributors</a>'//,
          //minZoom: 14
        }).addTo(map);

        var heat = L.heatLayer([[38.230462, 21.753150]], {radius: 15}).addTo(map), draw = true;

        function load_heatmap(points){
          var heat = L.heatLayer(points, {radius: 15}).addTo(map), draw = true;
        }

        function draw_heatmap(points){
          // var heat = L.heatLayer([[0, 0]], {radius: 15}).addTo(map), draw = true;
          for (const values in points) {
            // console.log(`${points[values]}`);
            heat.addLatLng(points[values]);
          }
        }
        //addressPoints = addressPoints.map(function (p) { return [p[0], p[1]]; });
        // var heat = L.heatLayer(this.responseText, {radius: 25}).addTo(map);
    </script>

    <script>
      function wait(ms){
        var start = new Date().getTime();
        var end = start;
        while(end < start + ms) {
          end = new Date().getTime();
        }
      }

      Object.size = function(obj) {
        var size = 0, key;
        for (key in obj) {
          if (obj.hasOwnProperty(key)) size++;
        }
        return size;
      };

      function array_diff (a1, a2) {
        var a = [], diff = [];

        for (var i = 0; i < a1.length; i++) {
            a[a1[i]] = true;
        }
        for (var i = 0; i < a2.length; i++) {
            if (a[a2[i]]) {
                delete a[a2[i]];
            } else {
                a[a2[i]] = true;
            }
        }
        for (var k in a) {
            diff.push(k);
        }
        return diff;
      }

      function string_diff(str1, str2) {
        var diff = "";
        str2.split("").forEach(function(val, i) {
          if (val != str1.charAt(i))
          diff += val;
        });
        return diff;
      }

      String.prototype.replaceAt=function(index, replacement) {
        return this.substr(0, index) + replacement + this.substr(index + replacement.length);
      }
      // var hello="Hello World";
      // alert(hello.replaceAt(0, "[")); --> [ello World

      var data = null;
      var new_data = null;
      var new_response = "";
      var counter = 0;
      more_loads();
      function more_loads(){
        // var response = '';
        $.ajax({
          type: "POST",
          url: "includes/from_mysql_to_heatmap.inc.php",
          // async: true,
          success: function(text){
            response = text;
            data = JSON.parse(response);
            console.log(Object.size(new_data));
            console.log(Object.size(data));
            if (Object.size(data) === 0) {
              counter = 0;
              // console.log("data = 0");
            }
            else if (Object.size(new_data) !== Object.size(data)) {
              counter = 0;
              draw = true;
              // console.log("new data != data");
              var new_obj_to_string = JSON.stringify(new_data);
              var obj_to_string = JSON.stringify(data);
              var diff = string_diff(new_obj_to_string, obj_to_string);
              // console.log(diff);
              var replacements = diff.replaceAt(0, "[");
              // console.log(replacements);
              var final = JSON.parse(replacements);
              draw_heatmap(final);
              new_data = data;
              new_response = response;
              data = null;
              response = null;
              // new_obj_to_string = null;
              // obj_to_string = null;
              // diff = null;
              // replacements = null;
              // final = null;
              more_loads();
            }
            else if (Object.size(new_data) === Object.size(data) && counter < 10) { // This one right here is trash code.
              counter = counter + 1;
              draw = false;
              more_loads();
            }
            else {
              console.log("What the actual fuck?");
              // data = null;
              // new_data = null;
              // response = null;
              // new_response = null;
              // counter = 0;
              // new_obj_to_string = null;
              // obj_to_string = null;
              // diff = null;
              // replacements = null;
              // final = null;
            }
          }
        });
      }
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
                    <button id="submit" type="submit" name="submit_file">UPLOAD</button>
                    </form>';
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

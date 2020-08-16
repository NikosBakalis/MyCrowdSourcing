<?php
  include 'header.php';
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"/>
    <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"></script>
    <script src="includes/Leaflet_heat/dist/leaflet-heat.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"> -->
    <meta charset="utf-8">
    <title></title>
    <style type="text/css">
    .map_table {
      width: 100%;
      border: 1px solid black;
      table-layout: fixed;

      background-position: center;
      background-image: url("images/earth-map-dark-texture-background-104605.jpg");
      color: white;
      font-size: 200%;
    }
    tr {
      height: 50%;
    }
    td {
      border: 1px solid black;
    }
    #top_left {
      vertical-align: middle;
      text-align: center;
    }
    #bot_left {
      vertical-align: middle;
      text-align: center;
    }
    #top_right {
      vertical-align: middle;
      text-align: center;
    }
    #bot_right {
      vertical-align: middle;
      text-align: center;
    }
    #center {
      width: 40%;
    }
    #mapid {
      width: auto;
      padding-top: 100%;
      border-radius: 100%;
      position: relative;
      z-index: 500;
      margin: auto;
    }
    button {
      width: 50%;
      margin-top: 10%;
      font-size: 60%;
    }
    </style>
  </head>
  <body>

    <script>
      $(document).ready(function(){
        $("#test").submit(function(event){
          event.preventDefault();
          var start_datetime = $("#start_datetime").val();
          var end_datetime = $("#end_datetime").val();
          $(".output").load("includes/test.inc.php", {
            start_datetime: start_datetime,
            end_datetime: end_datetime
          });
        });
      });
    </script>

    <section class="main">
      <div class="circled_leaflet_map">
        <table class="map_table">
          <tr>
            <td id="top_left">
              <?php
                if ($_SESSION['type'] == 'admin') {
                  echo "You are the real admin";
                }
                else {
                  header("Location: index.php");
                }
              ?>
            </td>
            <td id="center" rowspan="2">
              <div id="mapid">
              </div>
            </td>
            <td id="top_right">
              <form id="test" action="includes/test.inc.php" method="post">

                <input id="start_datetime" type="text" name="name">
                <input id="end_datetime" type="text" name="name">
                <button id="datetimes" type="submit" name="datetimes">Submit</button>
                <p class="output"></p>
              </form>
            </td>
          </tr>
          <tr>
            <td id="bot_left">
              <form action="includes/from_mysql_to_json.inc.php" method="post">
                <button type="submit" name="from_mysql_to_json">Download JSON</button>
              </form>
            </td>
            <td id="bot_right">
              <form action="includes/admin_delete_all.inc.php" method="post">
                <button type="submit" name="admin_delete_all">DELETE EVERYTHING</button>
              </form>
            </td>
          </tr>
        </table>

      </div>
      <script src="http://leaflet.github.io/Leaflet.markercluster/example/realworld.10000.js"></script>
      <script src="JavaScript/maps.js"></script>
    </section>
  </body>
</html>

<?php
  include 'footer.php';
?>

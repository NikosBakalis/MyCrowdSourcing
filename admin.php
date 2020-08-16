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
    <link rel="stylesheet" type="text/css" href="css/admin.css">
    <title></title>
  </head>
  <body>
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
              <form id="test" name"test" action="">
                <script src="JavaScript/datemaps.js"></script>
                <input id="start_datetime" type="text" name="start_datetime">
                <input id="end_datetime" type="text" name="end_datetime">
                <button id="datetimes" type="submit" name="datetimes">Submit</button>
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
      <script src="JavaScript/maps.js"></script>
    </section>
  </body>
</html>

<?php
  include 'footer.php';
?>

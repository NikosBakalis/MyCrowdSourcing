<?php
  include 'header.php';
?>

<?php

if ($_SESSION['type'] == 'admin') {
  echo "You are the real admin";
}
else {
  header("Location: index.php");
}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
    <title></title>
  </head>
  <body>
    <div class="container">
      <canvas id="myChart"></canvas>
    </div>
    <script>
      let myChart = document.getElementById("myChart").getContext("2d");

      Chart.defaults.global.defaultFontFamily = "Lato";
      Chart.defaults.global.defaultFontSize = 18;
      Chart.defaults.global.defaultFontColor = "#777";

      let massPopChart = new Chart(myChart, {
        type:"pie",
        data:{
          labels:["Boston", "Worcester", "Springfield", "Lowell"],
          datasets:[{
            label:"Population",
            data:[
              1,
              2,
              3,
              4
            ],
            backgroundColor:[
              "rgba(255, 99, 132, 0.6)",
              "rgba(54, 162, 235, 0.6)",
              "rgba(255, 206, 86, 0.6)",
              "rgba(75, 192, 192, 0.6)"
            ]
          }]
        },
        options:{
          title:{
            display:true,
            text:"Title",
            fontSize:25
          },
          layout:{
            padding:{
              left:50,
              right:50,
              bottom:50,
              top:0
            }
          }
        }
      })
    </script>
  </body>
</html>

<?php
  include 'footer.php';
?>

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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/dashboard.css">
    <title></title>
  </head>
  <body>
    <div id="div1">
      <canvas id="typePercentageChart" width="50" height="15"></canvas>
      <script>
        $.post('includes/activity_details_type_percentage.inc.php',
        function(result){
          // console.log(result);
          var both = jQuery.parseJSON(result);
          console.log(both);
          console.log(Object.values(both)[0].length);
          // var typeArray = Object.values(both)[0];
          var typeArray = [];
          for (var i = 0; i < Object.values(both)[0].length; i++) {
            typeArray.push(Object.values(both)[0][i]);
            console.log(typeArray[i]);
          }
          // var typeArray = jQuery.parseJSON(Object.values(both));
          var ctx = document.getElementById('typePercentageChart').getContext('2d');
          var typePercentageChart = new Chart(ctx, {
              type: 'pie',
              data: {
                labels: Object.values(both)[0], // 'Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'
                datasets: [{
                  label: 'Percentage of each type of activity',
                  data: Object.values(both)[1], // 12, 19, 3, 5, 2, 3
                  backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(44, 99, 132, 0.2)',
                    'rgba(23, 162, 235, 0.2)',
                    'rgba(67, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(69, 102, 255, 0.2)'
                  ],
                  borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(44, 99, 132, 1)',
                    'rgba(23, 162, 235, 1)',
                    'rgba(67, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(69, 102, 255, 1)'
                  ],
                  borderWidth: 4
                }]
              },
              options: {
                scales: {
                  yAxes: [{
                    ticks: {
                      beginAtZero: true
                    }
                  }]
                }
              }
          });
        });
      </script>
    </div>
    <div id="div2">
    </div>
    <div id="div3">
    </div>
    <div id="div4">
</div>
  </body>
</html>

<?php
  include 'footer.php';
?>

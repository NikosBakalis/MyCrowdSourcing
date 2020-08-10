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
    <script>
      function random_rgba() {
        var o = Math.round, r = Math.random, s = 255;
        return 'rgba(' + o(r()*s) + ',' + o(r()*s) + ',' + o(r()*s) + ',' + 0.5 + ')';
        // return 'rgba(' + o(r()*s) + ',' + o(r()*s) + ',' + o(r()*s) + ',' + r().toFixed(1) + ')';
      }
      function rgba_x_number_array(number) {
        var rgba_array = [];
        for (var i = 0; i < number; i++) {
          rgba_array.push(random_rgba());
        }
        return rgba_array;
      }
    </script>
    <div id="div0">
      <div id="div1" style="width:1000px;height:240px;padding-top:20px;padding-bottom:150px";>
        <canvas id="activityDetailsPercentageChart"></canvas>
        <script>
        $.post('includes/per_activity_details_percentage.inc.php',
        function(result){
          var both = jQuery.parseJSON(result);
          var typeArray = [];
          for (var i = 0; i < Object.values(both)[0].length; i++) {
            typeArray.push(Object.values(both)[0][i]);
          }
          var ctx = document.getElementById('activityDetailsPercentageChart').getContext('2d');
          var activityDetailsPercentageChart = new Chart(ctx, {
            type: 'pie',
            data: {
              labels: Object.values(both)[0], // 'Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'
              datasets: [{
                label: 'Percentage of each type of activity',
                data: Object.values(both)[1], // 12, 19, 3, 5, 2, 3
                backgroundColor: rgba_x_number_array(Object.values(both)[1].length),
                borderWidth: 4
              }]
            },
            options: {
              scales: {
                yAxes: [{
                  ticks: {
                    beginAtZero: false
                  }
                }]
              }
            }
          });
        });
        </script>
      </div>
      <div id="div2" style="width:1000px;height:240px;padding-top:150px;padding-bottom:150px";>
        <canvas id="perUserPercentageChart"></canvas>
        <script>
        $.post('includes/per_user_percentage.inc.php',
        function(result){
          var both = jQuery.parseJSON(result);
          var userArray = [];
          for (var i = 0; i < Object.values(both)[0].length; i++) {
            userArray.push(Object.values(both)[0][i]);
          }
          var ctx = document.getElementById('perUserPercentageChart').getContext('2d');
          var perUserPercentageChart = new Chart(ctx, {
            type: 'bar',
            data: {
              labels: Object.values(both)[0],
              datasets: [{
                label: 'Percentage of the activity per user',
                data: Object.values(both)[1],
                backgroundColor: rgba_x_number_array(Object.values(both)[1].length),
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
      <div id="div3" style="width:1000px;height:240px;padding-top:150px;padding-bottom:150px";>
        <canvas id="perMonthPercentageChart"></canvas>
        <script>
          $.post('includes/per_month_percentage.inc.php',
          function(result){
            var both = jQuery.parseJSON(result);
            var monthArray = [];
            for (var i = 0; i < Object.values(both)[0].length; i++) {
              monthArray.push(Object.values(both)[0][i]);
            }
            var ctx = document.getElementById('perMonthPercentageChart').getContext('2d');
            var perMonthPercentageChart = new Chart(ctx, {
              type: 'bar',
              data: {
                labels: Object.values(both)[0],
                datasets: [{
                  label: 'Percentage of the activity per month',
                  data: Object.values(both)[1],
                  backgroundColor: rgba_x_number_array(Object.values(both)[1].length),
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
      <div id="div4"style="width:1000px;height:240px;padding-top:150px;padding-bottom:150px";>
        <canvas id="perDayPercentageChart"></canvas>
        <script>
          $.post('includes/per_day_percentage.inc.php',
          function(result){
            var both = jQuery.parseJSON(result);
            var dayArray = [];
            for (var i = 0; i < Object.values(both)[0].length; i++) {
              dayArray.push(Object.values(both)[0][i]);
            }
            var ctx = document.getElementById('perDayPercentageChart').getContext('2d');
            var perDayPercentageChart = new Chart(ctx, {
              type: 'bar',
              data: {
                labels: Object.values(both)[0],
                datasets: [{
                  label: 'Percentage of the activity per day',
                  data: Object.values(both)[1],
                  backgroundColor: rgba_x_number_array(Object.values(both)[1].length),
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
      <div id="div5"style="width:1000px;height:240px;padding-top:150px;padding-bottom:150px";>
        <canvas id="perHourPercentageChart"></canvas>
        <script>
          $.post('includes/per_hour_percentage.inc.php',
          function(result){
            var both = jQuery.parseJSON(result);
            var hourArray = [];
            for (var i = 0; i < Object.values(both)[0].length; i++) {
              hourArray.push(Object.values(both)[0][i]);
            }
            var ctx = document.getElementById('perHourPercentageChart').getContext('2d');
            var perHourPercentageChart = new Chart(ctx, {
              type: 'bar',
              data: {
                labels: Object.values(both)[0],
                datasets: [{
                  label: 'Percentage of the activity per hour',
                  data: Object.values(both)[1],
                  backgroundColor: rgba_x_number_array(Object.values(both)[1].length),
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
      <div id="div6"style="width:1000px;height:240px;padding-top:150px;padding-bottom:300px";>
        <canvas id="perYearPercentageChart"></canvas>
        <script>
          $.post('includes/per_year_percentage.inc.php',
          function(result){
            var both = jQuery.parseJSON(result);
            var yearArray = [];
            for (var i = 0; i < Object.values(both)[0].length; i++) {
              yearArray.push(Object.values(both)[0][i]);
            }
            var ctx = document.getElementById('perYearPercentageChart').getContext('2d');
            var perYearPercentageChart = new Chart(ctx, {
              type: 'bar',
              data: {
                labels: Object.values(both)[0],
                datasets: [{
                  label: 'Percentage of the activity per year',
                  data: Object.values(both)[1],
                  backgroundColor: rgba_x_number_array(Object.values(both)[1].length),
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
    </div>
  </body>
</html>

<?php
  include 'footer.php';
?>

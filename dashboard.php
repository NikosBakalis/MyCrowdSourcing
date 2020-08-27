<?php
  include 'header.php';
?>

<?php

if ($_SESSION['type'] == 'admin') {
  echo "You are the real admin";

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
    <div class="main">
      <script>
        function random_rgba() {
          var o = Math.round, r = Math.random, s = 255;
          return 'rgba(' + o(r()*s) + ',' + o(r()*s) + ',' + o(r()*s) + ',' + 1 + ')';
          // return 'rgba(' + o(r()*s) + ',' + o(r()*s) + ',' + o(r()*s) + ',' + r().toFixed(1) + ')';
        }
        function rgba_x_number_array(number) {
          var rgba_array = [];
          for (var i = 0; i < number; i++) {
            rgba_array.push(random_rgba());
          }
          return rgba_array;
        }

        Chart.defaults.global.defaultFontColor = 'white';
        Chart.defaults.global.title.fontSize = 20;

      </script>
      <div id="div0">
        <div id="row1">
          <div id="div1">
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
              // ctx.style.backgroundColor = 'rgba(0,0,0,0.5)';
              var activityDetailsPercentageChart = new Chart(ctx, {
                type: 'pie',
                data: {
                  labels: Object.values(both)[0], // 'Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'
                  datasets: [{
                    data: Object.values(both)[1], // 12, 19, 3, 5, 2, 3
                    backgroundColor: rgba_x_number_array(Object.values(both)[1].length),
                    borderColor: 'white',
                    borderWidth: 1
                  }]
                },
                options: {
                  legend: {
                    position: 'left'
                  },
                  title: {
                    display: true,
                    text: 'Percentage of each type of activity'
                  },
                  scales: {
                    yAxes: [{
                      gridLines: {
                        display: false,
                      },
                      ticks: {
                        display: false
                      }
                    }]
                  }
                }
              });
            });
            </script>
          </div>
          <div id="div2">
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
                    data: Object.values(both)[1],
                    backgroundColor: rgba_x_number_array(Object.values(both)[1].length),
                    borderColor: 'white',
                    borderWidth: 1
                  }]
                },
                options: {
                  legend: {
                    display: false
                  },
                  title: {
                    display: true,
                    text: 'Percentage of the activity per user'
                  },
                  scales: {
                    yAxes: [{
                      gridLines: {
                        color: 'white',
                        zeroLineColor: 'white'
                      },
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
        <div id="row2">
          <div id="div3">
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
                      label: '',
                      data: Object.values(both)[1],
                      backgroundColor: rgba_x_number_array(Object.values(both)[1].length),
                      borderColor: 'white',
                      borderWidth: 1
                    }]
                  },
                  options: {
                    legend: {
                      display: false
                    },
                    title: {
                      display: true,
                      text: 'Percentage of the activity per month'
                    },
                    scales: {
                      yAxes: [{
                        gridLines: {
                          color: 'white',
                          zeroLineColor: 'white'
                        },
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
          <div id="div4">
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
                      data: Object.values(both)[1],
                      backgroundColor: rgba_x_number_array(Object.values(both)[1].length),
                      borderColor: 'white',
                      borderWidth: 1
                    }]
                  },
                  options: {
                    legend: {
                      display: false
                    },
                    title: {
                      display: true,
                      text: 'Percentage of the activity per day'
                    },
                    scales: {
                      yAxes: [{
                        gridLines: {
                          color: 'white',
                          zeroLineColor: 'white'
                        },
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
        <div id="row3">
          <div id="div5">
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
                      data: Object.values(both)[1],
                      backgroundColor: rgba_x_number_array(Object.values(both)[1].length),
                      borderColor: 'white',
                      borderWidth: 1
                    }]
                  },
                  options: {
                    legend: {
                      display: false
                    },
                    title: {
                      display: true,
                      text: 'Percentage of the activity per hour'
                    },
                    scales: {
                      yAxes: [{
                        gridLines: {
                          color: 'white',
                          zeroLineColor: 'white'
                        },
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
          <div id="div6">
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
                      data: Object.values(both)[1],
                      backgroundColor: rgba_x_number_array(Object.values(both)[1].length),
                      borderColor: 'white',
                      borderWidth: 1
                    }]
                  },
                  options: {
                    legend: {
                      display: false
                    },
                    title: {
                      display: true,
                      text: 'Percentage of the activity per year'
                    },
                    scales: {
                      yAxes: [{
                        gridLines: {
                          color: 'white',
                          zeroLineColor: 'white'
                        },
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
      </div>
    </div>
  </body>
</html>

<?php

}
else {
  // header("Location: index.php");
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
    <div class="main">
      <script>
        function random_rgba() {
          var o = Math.round, r = Math.random, s = 255;
          return 'rgba(' + o(r()*s) + ',' + o(r()*s) + ',' + o(r()*s) + ',' + 1 + ')';
          // return 'rgba(' + o(r()*s) + ',' + o(r()*s) + ',' + o(r()*s) + ',' + r().toFixed(1) + ')';
        }
        function rgba_x_number_array(number) {
          var rgba_array = [];
          for (var i = 0; i < number; i++) {
            rgba_array.push(random_rgba());
          }
          return rgba_array;
        }

        Chart.defaults.global.defaultFontColor = 'white';
        Chart.defaults.global.title.fontSize = 20;

      </script>
      <div id="div0">
        <div id="row1">
          <div id="div1">
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
              // ctx.style.backgroundColor = 'rgba(0,0,0,0.5)';
              var activityDetailsPercentageChart = new Chart(ctx, {
                type: 'pie',
                data: {
                  labels: Object.values(both)[0], // 'Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'
                  datasets: [{
                    data: Object.values(both)[1], // 12, 19, 3, 5, 2, 3
                    backgroundColor: rgba_x_number_array(Object.values(both)[1].length),
                    borderColor: 'white',
                    borderWidth: 1
                  }]
                },
                options: {
                  legend: {
                    position: 'left'
                  },
                  title: {
                    display: true,
                    text: 'Percentage of each type of activity'
                  },
                  scales: {
                    yAxes: [{
                      gridLines: {
                        display: false,
                      },
                      ticks: {
                        display: false
                      }
                    }]
                  }
                }
              });
            });
            </script>
          </div>
          <div id="div2">
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
                      data: Object.values(both)[1],
                      backgroundColor: rgba_x_number_array(Object.values(both)[1].length),
                      borderColor: 'white',
                      borderWidth: 1
                    }]
                  },
                  options: {
                    legend: {
                      display: false
                    },
                    title: {
                      display: true,
                      text: 'Percentage of the activity per hour'
                    },
                    scales: {
                      yAxes: [{
                        gridLines: {
                          color: 'white',
                          zeroLineColor: 'white'
                        },
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
        <div id="row2">
          <div id="div3">
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
                    data: Object.values(both)[1],
                    backgroundColor: rgba_x_number_array(Object.values(both)[1].length),
                    borderColor: 'white',
                    borderWidth: 1
                  }]
                },
                options: {
                  legend: {
                    display: false
                  },
                  title: {
                    display: true,
                    text: 'Percentage of the activity per day'
                  },
                  scales: {
                    yAxes: [{
                      gridLines: {
                        color: 'white',
                        zeroLineColor: 'white'
                      },
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
      </div>
    </div>
  </body>
</html>



<?php

}

?>





<?php
  include 'footer.php';
?>

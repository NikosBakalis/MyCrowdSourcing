$("#test").submit(function(e) {
  e.preventDefault();
  var start_datetime = $("#start_datetime").val();
  var end_datetime = $("#end_datetime").val();
  $.ajax({
    type:"POST",
    url:"includes/dates_to_heatmap.inc.php",
    data: {
      start_datetime: start_datetime,
      end_datetime: end_datetime
    },
    success:function(response1){
      console.log(start_datetime);
      console.log(end_datetime);
      $.ajax({
        type:"GET",
        url:"includes/dates_to_heatmap.inc.php",
        success:function(response2){
          data = JSON.parse(response1);
          if (map.hasLayer(heatdates) && map.hasLayer(heat)) {
            map.removeLayer(heatdates);
            console.log("1");
            map.removeLayer(heat);
          } else if (map.hasLayer(heatdates) && !map.hasLayer(heat)) {
            map.removeLayer(heatdates);
            console.log("2");
          } else if (!map.hasLayer(heatdates) && map.hasLayer(heat)) {
            map.removeLayer(heat);
            var heatdates = L.heatLayer(data, {radius: 15}).addTo(map);
            console.log("3");
          } else {
            console.log("Hmmm?");
          }
        }
      });
    }
  });
});

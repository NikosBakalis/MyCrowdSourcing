var map = L.map('mapid').setView([38.230462, 21.753150], 12);

var tiles = L.tileLayer('https://api.maptiler.com/maps/streets/{z}/{x}/{y}.png?key=jYXMr02JU1RhJCrKJMBl', {
  attribution: '<a href="https://www.maptiler.com/copyright/" target="_blank">&copy; MapTiler</a> <a href="https://www.openstreetmap.org/copyright" target="_blank">&copy; OpenStreetMap contributors</a>'//,
  //minZoom: 14
}).addTo(map);

var heat = L.heatLayer([], {radius: 15}).addTo(map), draw = true;

// FeatureGroup is to store editable layers
var drawnItems = new L.FeatureGroup();
map.addLayer(drawnItems);
var drawControl = new L.Control.Draw({
  edit: {
      featureGroup: drawnItems
  }
});
map.addControl(drawControl);

var latlngrad = [];
var latlng = [];
map.on('draw:created', function(event){
  var layer = event.layer,
      type = event.layerType,
      feature = layer.feature = layer.feature || {};

  feature.type = feature.type || "Feature";
  var props = feature.properties = feature.properties || {};
  drawnItems.addLayer(layer);
  // console.log(Polygon.getBounds().contains([38.230462, 21.753150]));
  console.log(type);
  if (type === "marker") {
    console.log(layer.getLatLng());
  } else if (type === "circle") {
    var lat = Object.values(layer.getLatLng())[0];
    var lng = Object.values(layer.getLatLng())[1];
    latlngrad.push(lat, lng, layer.getRadius() / 1000);
    console.log(latlngrad);
    $.ajax({
      url: "includes/from_drawmap_to_circle_text.inc.php",
      method: "POST",
      data: {
        latlngrad: latlngrad
      },
      success: function (response) {
        console.log(response);
      }
    })
    latlngrad = [];
  } else {
    // console.log(layer.getBounds().contains([38.230462, 21.753150]));
    // console.log(layer.getLatLngs());
    latlngobj = Object.values(layer.getLatLngs())[0];
    for (const property in latlngobj) {
      // console.log(latlng[property]);
      for (const insideProperty in latlngobj[property]) {
        // console.log(latlngobj[property][insideProperty]);
        latlng.push(latlngobj[property][insideProperty]);
      }
    }
    // console.log(latlng);
    var lat = [];
    var lng = [];
    for (var i = 0; i < latlng.length; i=i+8) {
      // console.log(latlng[i]);
      lat.push(latlng[i]);
      lng.push(latlng[i + 1]);

    }
    // console.log(lat);
    // console.log(lng);
    latlng = [];
    for (var i = 0; i < lat.length; i++) {
      latlng.push(lat[i], lng[i]);
    }
    // console.log(latlng);
    var uniquelatlng = [];
    $.each(latlng, function(i, el){
        if($.inArray(el, uniquelatlng) === -1) uniquelatlng.push(el);
    });
    // console.log(uniquelatlng);
    // latlng = Object.values(latlng);
    // console.log(latlng);
    $.ajax({
      url: "includes/from_drawmap_to_polygon_text.inc.php",
      method: "POST",
      data: {
        uniquelatlng: uniquelatlng
      },
      success: function (response) {
        console.log(response);
      }
    })
    latlng = [];
    uniquelatlng = [];
  }
});

// document.getElementById("bot_right").addEventListener("click", function(){
//   // var hasil = $('#result').html(JSON.stringify(drawnItems.toGeoJSON()));
//   console.log(JSON.stringify(drawnItems.toGeoJSON()));
//   console.log("\n");
//   console.log(props);
//   // if (drawControl.getBounds().contains([38.230462, 21.753150])) {
//   //   console.log('YES');
//   // }
//   // drawnItems.getBounds().contains(MarketLatLng);
// });

// var marker = L. ΕΔΩΩΩΩΩΩΩΩΩΩΩΩΩΩΩΩΩΩΩΩΩΩΩΩΩΩΩΩΩΩΩΩΩΩΩΩΩΩΩΩΩΩΩΩΩΩ!

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
  var replacements = "";
  // var response = '';
  $.ajax({
    type: "GET",
    url: "includes/from_mysql_to_heatmap.inc.php",
    success: function(text){
      response = text;
      data = JSON.parse(response);
      if (Object.size(data) === 0) {
        counter = 0;
      }
      else if (Object.size(new_data) !== Object.size(data)) {
        counter = 0;
        draw = true;
        // console.log("new data != data");
        var new_obj_to_string = JSON.stringify(new_data);
        var obj_to_string = JSON.stringify(data);
        var diff = string_diff(new_obj_to_string, obj_to_string);
        var replacements = diff.replaceAt(0, "[");
        var final = JSON.parse(replacements);
        draw_heatmap(final);
        new_data = data;
        new_response = response;
        data = null;
        response = null;
        more_loads();
      }
      else if (Object.size(new_data) === Object.size(data) && counter < 10) { // This one right here is trash code.
        counter = counter + 1;
        draw = false;
        more_loads();
      }
      else {
        counter = 0;
        console.log("What the actual fuck?");
      }
    }
  });
}

$("#datetimes").submit(function(e) {
  e.preventDefault();
  var activity = $("#activity").val();
  var start_datetime = $("#start_datetime").val();
  var end_datetime = $("#end_datetime").val();
  $.ajax({
    type:"POST",
    url:"includes/dates_to_heatmap.inc.php",
    data: {
      activity: activity,
      start_datetime: start_datetime,
      end_datetime: end_datetime
    },
    success:function(response){
      // console.log(start_datetime);
      // console.log(end_datetime);
      map.removeLayer(heat);
      data = JSON.parse(response);
      heat = L.heatLayer(data, {radius: 15}).addTo(map), draw = true;
    }
  });
});

// $("#submit").submit(function(e) {
//   e.preventDefault();
//   $.ajax({
//     type:"GET",
//     url:"includes/from_json_to_mysql_with_json_machine.inc.php",
//     success:function(response){
//       // console.log(start_datetime);
//       // console.log(end_datetime);
//       // map.removeLayer(heat);
//       // data = JSON.parse(response);
//       console.log(response);
//     }
//   });
// });

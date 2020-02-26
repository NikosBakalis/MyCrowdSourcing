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
    type: "GET",
    url: "includes/from_mysql_to_heatmap.inc.php",
    // async: true,
    success: function(text){
      response = text;
      data = JSON.parse(response);
      // console.log(Object.size(new_data));
      // console.log(Object.size(data));
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

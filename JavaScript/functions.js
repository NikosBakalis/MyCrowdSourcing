export function wait(ms){
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

export function array_diff (a1, a2) {
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

export function string_diff(str1, str2) {
  var diff = "";
  str2.split("").forEach(function(val, i) {
    if (val != str1.charAt(i))
    diff += val;
  });
  return diff;
}

String.prototype.replaceAt = function(index, replacement) {
  return this.substr(0, index) + replacement + this.substr(index + replacement.length);
}
// var hello="Hello World";
// alert(hello.replaceAt(0, "[")); --> [ello World

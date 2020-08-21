jQuery.ajax({
    type: "GET",
    url: 'includes/from_mysql_to_eco.inc.php',
    success: function (textstatus) {
      document.getElementById("top_right").innerHTML = textstatus;
    }
});

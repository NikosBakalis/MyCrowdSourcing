jQuery.ajax({
    type: "GET",
    url: 'includes/from_mysql_to_latest_upload_and_datetimes.inc.php',
    success: function (textstatus) {
      document.getElementById("bot_left").innerHTML = textstatus;
    }
});

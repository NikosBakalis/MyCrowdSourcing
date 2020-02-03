<?php

$targetPath = "../uploads/".basename($_FILES["upload_file"]["name"]);
echo $targetPath;
move_uploaded_file($_FILES["upload_file"]["tmp_name"], $targetPath);

?>

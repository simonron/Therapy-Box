<?php
session_start();
$arr_file_types = ['image/png', 'image/gif', 'image/jpeg'];

if (!(in_array($_FILES['file']['type'], $arr_file_types))) {
	echo "false";
	return;
}

if (!file_exists('images/profiles')) {
	mkdir('images', 0777);
  	mkdir('images/profiles', 0777);
}

move_uploaded_file($_FILES['file']['tmp_name'], 'images/profiles/' .$_FILES['file']['name']);
$profile_image = $_FILES['file']['name'];

echo $profile_image ." uploaded successfully.";

$_SESSION["profile_image"] = $profile_image ;

?>
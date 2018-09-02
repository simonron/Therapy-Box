<?php
$arr_file_types = ['image/png', 'image/gif', 'image/jpg','image/JPEG','image/JPG','image/PNG', 'image/GIF',];

if (!(in_array($_FILES['file']['type'], $arr_file_types))) {
	echo "false";
	return;
}

if (!file_exists('images/profiles')) {
	mkdir('images', 0777);
  	mkdir('images/profiles', 0777);

}

move_uploaded_file($_FILES['file']['tmp_name'], 'images/profiles/' . time() . $_FILES['file']['name']);

echo $_FILES['file']['name']." uploaded successfully.";
$profile_image = $_FILES['file']['name'];
?>
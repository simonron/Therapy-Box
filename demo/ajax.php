<?php
$arr_file_types = ['image/png', 'image/gif', 'image/jpg', 'image/JPEG', 'image/JPG', 'image/PNG', 'image/GIF'];

if (!(in_array($_FILES['file']['type'], $arr_file_types))) {
	echo "false";
	return;
}

if (!file_exists('images/profiles')) {
	mkdir('images', 0777);
  	mkdir('images/profiles', 0777);

}

$profile_image = time() . $_FILES['file']['name'];
move_uploaded_file($_FILES['file']['tmp_name'], 'images/profiles/' . $profile_image);

echo $profile_image." uploaded successfully.";
?>
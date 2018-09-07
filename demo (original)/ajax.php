<?php
session_start();
$upload_target = $_SESSION["upload_target"];

echo "!!! ".$upload_target." !!!!";


$arr_file_types = ['image/png', 'image/gif', 'image/jpeg'];

if (!(in_array($_FILES['file']['type'], $arr_file_types))) {
	echo "false";
	return;
}

//echo('images/'.$upload_target);

$image = $_FILES['file']['name'];

if (!file_exists('images/'.$upload_target)) {
	mkdir('images', 0777);
  	mkdir('images/'.$upload_target, 0777);
};

if($upload_target == "profiles"){
$_SESSION["profile_image"] = $image ;
/*
echo"<h1>FRPG$profile_image</h1>";
*/
}
move_uploaded_file($_FILES['file']['tmp_name'], 'images/'.$upload_target.'/' .$_FILES['file']['name']);

echo $image ." uploaded successfully.";

?>
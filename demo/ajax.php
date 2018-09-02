<?php
session_start();
$upload_target = $_SESSION["upload_target"];
echo $upload_target;

$arr_file_types = ['image/png', 'image/gif', 'image/jpeg'];

if (!(in_array($_FILES['file']['type'], $arr_file_types))) {
  echo "false";
  return;
}

if (!file_exists('images/'.$upload_target)) {
  mkdir('images', 0777);
  mkdir('images/'.$upload_target, 0777);
};

move_uploaded_file($_FILES['file']['tmp_name'], 'images/'.$upload_target.'/' .$_FILES['file']['name']);
$image = $_FILES['file']['name'];

echo $image ." uploaded successfully.";
if($upload_target == "profile_image"){
  $_SESSION["profile_image"] = $image ;
}else{
  $_SESSION["photo_image"] = $image ;
}

?>
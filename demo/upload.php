<?php
header('Content-Type:application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');


if (isset($FILES['file'], $_POST['id'])){
  move_upload_file($_FILES['file']['temp_name'], 'uploads/'. $_POST['id']);
}

echo json_encode([
  'data' => [
    'id' => $id
  ]
]);
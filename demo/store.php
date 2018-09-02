<?php
header('Content-Type:application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
$id =unique(true);

echo json_encode([
  'data' => [
    'id' => $id
  ]
]);
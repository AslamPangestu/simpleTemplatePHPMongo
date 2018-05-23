<?php
require_once('dbconn.php');
$id    = $_GET['id'];
$result = array();
if($id){
  $filter = ['_id' => new MongoDB\BSON\ObjectID($id)];
  $options = [
   'projection' => ['_id' => 0],
];
//. Panggil fungsi query dlm mongo
  $query = new MongoDB\Driver\Query($filter,$options);
  //eksekusi query
  $cursor = $manager->executeQuery("$mongoDBName.$mongoCollName", $query);
  foreach($cursor as $row){
    //sesuaikan dengan kolum
    $result ['nama'] = $row->nama;
    $result ['nim'] = $row->nim;
    $result ['id'] = $id;
  }
  echo json_encode($result);
}

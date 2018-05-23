<?php
  require_once('dbconn.php');
  //buat variabel sesuai coll
  $nim = '';
  $nama = '';
  $flag = 0;
  if(isset($_POST['btn'])){
      $nim = $_POST['nim'];
      $nama = $_POST['nama'];
      $id = $_POST['id'];

      //error handling. cek apakah semua form sudah diisi
      if(!$nim || !$nama){
        $flag = 5;
      }else{
          //menjalankan fungsi insert
          $insRec       = new MongoDB\Driver\BulkWrite;
          //melakukan update sesuai coll
          $insRec->update(['_id'=>new MongoDB\BSON\ObjectID($id)],['$set' =>['nim' =>$nim, 'nama'=>$nama]], ['multi' => false, 'upsert' => false]);
          $writeConcern = new MongoDB\Driver\WriteConcern(MongoDB\Driver\WriteConcern::MAJORITY, 1000);
          $result       = $manager->executeBulkWrite("$mongoDBName.$mongoCollName", $insRec, $writeConcern);
          if($result->getModifiedCount()){
            $flag = 3;
          }else{
            $flag = 2;
          }
      }
  }
  header("Location: index.php?flag=$flag");
  exit;

<?php
  require_once('dbconn.php');
  //buat variabel sesuai coll
  $nim = '';
  $nama = '';
  $flag = 0;
  if(isset($_POST['btn'])){
      //buat variabel sesuai kolum. Ini untuk menggunakan method post pada button
      $nim = $_POST['nim'];
      $nama = $_POST['nama'];

      //error handling. cek apakah semua form sudah diisi
      if(!$nim || !$nama){
        $flag = 5;
      }else{
          //jalankan fungsi melakukan tulis
          $insRec       = new MongoDB\Driver\BulkWrite;
          //melakukan insert sesuai coll
          $insRec->insert(['nim' =>$nim, 'nama'=>$nama]);
          $writeConcern = new MongoDB\Driver\WriteConcern(MongoDB\Driver\WriteConcern::MAJORITY, 1000);
          //eksekusi
          $result       = $manager->executeBulkWrite("$mongoDBName.$mongoCollName", $insRec, $writeConcern);

          //error handling
          if($result->getInsertedCount()){
            $flag = 3;
          }else{
            $flag = 2;
          }
      }
  }
  header("Location: index.php?flag=$flag");
  exit;

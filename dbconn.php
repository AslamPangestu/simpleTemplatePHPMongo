<?php
//error reporting
ini_set('display_errors','true');
error_reporting(E_ALL);

$messages = array(
	1=>'Data berhasil dihapus',
	2=>'Ada masalah. Silahkan coba lagi', 
	3=>'Data berhasil ditambah',
    4=>'Data berhasil diubah', 
    5=>'Mohon isi semua field' );

//otomatis terbuat jika belum ada
$mongoDBName  =  'dbkampus';//masukkan nama database
$mongoCollName =  'mahasiswa';//masukkan nama collection
//koneksi database dengan driver mongodb. Panggil fungsi Manager
$manager     =   new MongoDB\Driver\Manager("mongodb://localhost:27017");
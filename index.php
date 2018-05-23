<?php
require_once('dbconn.php');

$flag    = isset($_GET['flag'])?intval($_GET['flag']):0;
$message ='';
if($flag){
  $message = $messages[$flag];
}
//$filter = ['x' => ['$gt' => 1]];
$filter = [];
$options = [
    'sort' => ['_id' => -1],
];
//. Panggil fungsi query dlm mongo
$query = new MongoDB\Driver\Query($filter, $options);
//masukkan sesuai namadb dan nama coll sebelumnya. eksekusi query
$cursor = $manager->executeQuery("$mongoDBName.$mongoCollName", $query);

?>
<!-- Bagian ini fokus pada tampilan-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Data Mahasiswa</title>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="logo">
                <h3>
                  Input Data Mahasiswa
                </h3>
            </div>
        </div>
        <div class="row">
            <div class="span12">
                <div class="mini-layout">
                <!-- Form untuk menginput data-->
                   <form id="form1" name='form1' action="record_add.php" method="post">
                   <input type='hidden' name='id' id='id' value="" />
                    <table>
                      <tr>
                        <!-- Masukkan sesuai kolom yang akan dimasukkan kedalam collection-->
                        <td><input type='text' name='nim' id='nim' placeholder="Masukkan NIM" /></td>
                        <td><input type='text' name='nama' id='nama' placeholder="Masukkan Nama" /></td>
                        <td><input class='btn' type='submit' name='btn' id='btn' value="Tambah Data" /></td>
                      </tr>
                    </table>
                   </form>                   
                    <h3><!-- Masukkan Judul--></h3>
                    <p>
                    <!-- Error handling-->
                      <?php if($flag == 2 || $flag == 5){ ?>
                        <div class="error"><?php echo $message; ?></div>
                      <?php  } elseif($flag && $flag != 2 ){ ?>
                        <div class="success"><?php echo $message; ?></div>
                      <?php  } ?>
                    </p>
                    <!--Tabel untuk menampilkan data-->
                    <table class='table table-bordered'>
                      <thead>
                        <tr>
                          <th>#</th><!-- ini id. biarin aja-->
                          <!-- Masukkan sesuai kolom yang akan dimasukkan kedalam collection-->
                          <th>NIM</th>
                          <th>Nama</th>
                        </tr>
                     </thead>
                    <?php 
                    $i =1; 
                    //menampilkan semua data
                    foreach ($cursor as $document) { ?>
                      <tr>
                        <td><?php echo $i; ?></td>
                        <!-- Masukkan sesuai kolom yang akan dimasukkan kedalam collection-->
                        <td><?php echo $document->nim;  ?></td>
                        <td><?php echo $document->nama;  ?></td>
                        <td><a class='editlink' data-id=<?php echo $document->_id; ?> href='javascript:void(0)'>Ubah</a> |
                          <a onClick ='return confirm("Apakah anda ingin menghapus data ini?");' href='record_delete.php?id=<?php echo $document->_id; ?>'>Hapus</td>
                      </tr>
                   <?php $i++;  
                    } 
                  ?>
                    </table>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script>
$(function(){
  $('.editlink').on('click', function(){
    var id = $(this).data('id');
    if(id){
      $.ajax({
          method: "GET",
          url: "record_ajax.php",
          data: { id: id}
        })
        .done(function( result ) {
          result = $.parseJSON(result);
          //Masukkan sesuai kolom yang akan dimasukkan kedalam collection
          $('#nim').val(result['nim']);
          $('#nama').val(result['nama']);
          $('#id').val(result['id']);
          $('#btn').val('Update Records');
          $('#form1').attr('action', 'record_edit.php');
        });
      }
    });
});

</script>
</body>
</html>

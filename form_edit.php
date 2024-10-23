<?php
 $_GET['action'] = 'edit';

 require 'functions.php';

 $id_person = $_GET['id'];

 $data_person = myquery("SELECT * FROM tbl_karyawan WHERE id = $id_person");

 $data_alamat = myquery("SELECT * FROM tbl_kendaraan");

//   update condition

 if (isset($_POST['submit_update'])) {
   if (update($_POST) > 0) {
       echo "<script>alert('DATA berhasil di ubah')
        document.location.href = 'index.php';
       </script>";
       
   }else{
       echo "<script>alert('DATA gagal di ubah')
      
       </script>";
       
   }
 }
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form tambah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-sm-12">

                <h3 class="mt-4 mb-2">Formulir Tambah</h3>
                <a href="./index.php" class="d-block mb-4">Kembali</a>

                <?php if (isset($err)): ?>
                    <p><?= $err; ?></p>
                <?php endif; ?>

                <div class="card mb-4">
                    <div class="card-body">

                        <form method="POST">
                            <div class="mb-3">
                                <label>NIK</label>
                                <input type="text" name="txt_nik" class="form-control" placeholder="Input Nomor induk Karyawan" autocomplete="off" />
                            </div>

                            <div class="mb-3">
                                <label>NAMA</label>
                                <input type="text" name="txt_nama" class="form-control" placeholder="Input Nama Karyawan" autocomplete="off" />
                            </div>

                            <div class="mb-3">
                                <label>TANGGAL</label>
                                <input type="date" name="txt_tanggal" class="form-control" autocomplete="off" />
                            </div>

                           
                                <button class="btn btn-primary" name="submit_edit_karyawan">Simpan</button>
                            </div>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
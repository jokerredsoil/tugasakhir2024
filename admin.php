<?php
require 'connection.php';


// session_start();

// if(!isset($_SESSION['username'])){
//     header("Location: login.php");
//     exit();
// }

$data_karyawan  = myquery("SELECT * FROM tbl_karyawan ");






?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>

    <table class="table" border='1'>
        <h3><a href="add.php">tambah data</a></h3>
        <thead>
            <tr>
                <th>nik</th>
                <th>nama karyawan</th>
                <th>tanggal masuk</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data_karyawan as $data): ?>
                <tr>
                    <td><?= $data['nik'] ?></td>
                    <td><?= $data['nama_karyawan'] ?></td>
                    <td><?= $data['tanggal_masuk'] ?></td>
                    <td scope="row">


                        <a href="form_edit.php?id=<?= $data['id'] ?>" class="btn btn-primary">Edit</a>
                  
                       
                       <a href="functions.php?action=delete&id=<?= $data['id'] ?>" class="btn btn-outline-danger" onClick="return confirm('Yakin akan menghapus?')">Hapus</a>

                    </td>

                </tr>

            <?php endforeach; ?>
        </tbody>

    </table>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
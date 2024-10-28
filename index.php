<?php
require 'connection.php';
<<<<<<< HEAD

$data = myquery("SELECT p.id, p.nopol, p.jenis_kendaraan, a.nama_karyawan, p.tanggal, p.masuk, p.keluar
FROM tbl_parkir as p
JOIN tbl_karyawan as a
ON p.pemilik = a.nama_karyawan");

var_dump($data);
=======
// $data =myquery("SELECT * FROM tbl_parkir");
$data = myquery("SELECT p.id, p.nopol, p.jenis_kendaraan, p.pemilik, p.tanggal, p.masuk, p.keluar
FROM tbl_parkir as p
WHERE P.keluar is null
");

// $data_kendaraan = myquery("SELECT ka.nama_karyawan, ke.jenis_kendaraan, ke.nopol
// FROM tbl_kendaraan as ke
// JOIN tbl_karyawan as ka ON ka.id = ke.id");
// var_dump($data);
>>>>>>> dc5e04f86970216b7679ed6a85951cc247c0cfb4

?>

<?php
include('layout/header.php');
?>
<main class="flex-grow-1">
    <div class="container-sm">
        <table class="table table-sm">
            <thead>
                <tr>
                    <th>nopol</th>
                    <th>jenis kendaraan</th>
                    <th>pemilik</th>
                    <!-- <th>tanggal</th> -->
                    <th>masuk</th>
                    <th>keluar</th>
                    <th>aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $row): ?>
                   
                    <tr>
                        <td><?= $row['nopol'] ?></td>
                        <td><?= $row['jenis_kendaraan'] ?></td>
                        <td><?= $row['pemilik'] ?></td>
                        <!-- <td><?= $row['tanggal'] ?></td> -->
                        <td><?= $row['masuk'] ?></td>
                        <td><?= $row['keluar'] ?></td>
                        <td scope="row">
                            <a href="form_edit.php?id=<?=$row['id'] ?>" class="btn btn-primary">Edit</a>
                            <a href="function.php?action=delete&id=<?= $row['id'] ?>" class="btn btn-outline-danger" onClick="return confirm('Yakin akan menghapus?')">Hapus</a>

                        </td>
                    </tr>
                   
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>

</main>

<?php
include('layout/footer.php')
?>
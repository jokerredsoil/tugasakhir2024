<?php
session_start();
require 'connection.php';

if(!isset($_SESSION['username'])){
    header("Location: auth/login.php");
    exit();
}




// Sorting variables
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'nik';
$order = isset($_GET['order']) && $_GET['order'] === 'desc' ? 'desc' : 'asc';
$nextOrder = $order === 'asc' ? 'desc' : 'asc';

// Count total records for pagination


// Fetch records for the current page with sorting
$data = myquery("SELECT kar.id, kar.nik, kar.nama_karyawan, kar.tanggal_masuk, ken.jenis_kendaraan, ken.nopol 
                 FROM tbl_karyawan as kar 
                 LEFT JOIN tbl_kendaraan as ken ON ken.id_karyawan = kar.id 
                 ORDER BY $sort $order ");

?>

<?php
$page = 'data_karyawan';
include('layout/header.php');
?>
<main class="min-vh-100 d-flex align-items-center justify-content-center">
    <div class="container-sm">
        <table class="table table-sm">
            <thead>
                <tr>
                    <th><a href="?sort=nik&order=<?= $nextOrder ?>">NIK</a></th>
                    <th><a href="?sort=nama_karyawan&order=<?= $nextOrder ?>">Nama Karyawan</a></th>
                    <th><a href="?sort=tanggal_masuk&order=<?= $nextOrder ?>">Tanggal Masuk</a></th>
                    <th><a href="?sort=jenis_kendaraan&order=<?= $nextOrder ?>">Kendaraan</a></th>
                    <th><a href="?sort=nopol&order=<?= $nextOrder ?>">Nopol</a></th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['nik']) ?></td>
                        <td><?= htmlspecialchars($row['nama_karyawan']) ?></td>
                        <td><?= htmlspecialchars($row['tanggal_masuk']) ?></td>
                        <td><?= htmlspecialchars($row['jenis_kendaraan'] ?? 'Tidak Ada') ?></td>
                        <td><?= htmlspecialchars($row['nopol'] ?? 'Tidak Ada') ?></td>
                        <td scope="row">
                            <a href="form_edit.php?id=<?= $row['id'] ?>" class="btn btn-primary">Edit</a>
                            <a href="functions.php?action=softdelete&id=<?= $row['id'] ?>" class="btn btn-outline-danger" onClick="return confirm('Yakin akan menghapus?')">Hapus data</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

       
    </div>
</main>

<?php
include('layout/footer.php');
?>

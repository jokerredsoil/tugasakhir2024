<?php

require 'connection.php';

if (!isset($_SESSION['username'])) {
    header("Location: auth/login.php");
    exit();
}

// Allowable sorting columns to prevent SQL injection
$allowedSortColumns = ['nik', 'nama_karyawan', 'tanggal_masuk', 'jenis_kendaraan', 'nopol'];
$sort = isset($_GET['sort']) && in_array($_GET['sort'], $allowedSortColumns) ? $_GET['sort'] : 'nik';
$order = isset($_GET['order']) && $_GET['order'] === 'desc' ? 'desc' : 'asc';
$nextOrder = $order === 'asc' ? 'desc' : 'asc';

// Fetch all records with sorting
$data = myquery("SELECT kar.id, kar.nik, kar.nama_karyawan, kar.tanggal_masuk, ken.jenis_kendaraan, ken.nopol 
                 FROM tbl_karyawan as kar 
                 LEFT JOIN tbl_kendaraan as ken ON ken.id_karyawan = kar.id 
                 ORDER BY $sort $order");

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
                    <th><a href="?sort=nik&order=<?= ($sort === 'nik' && $order === 'asc') ? 'desc' : 'asc' ?>">NIK</a></th>
                    <th><a href="?sort=nama_karyawan&order=<?= ($sort === 'nama_karyawan' && $order === 'asc') ? 'desc' : 'asc' ?>">Nama Karyawan</a></th>
                    <th><a href="?sort=tanggal_masuk&order=<?= ($sort === 'tanggal_masuk' && $order === 'asc') ? 'desc' : 'asc' ?>">Tanggal Masuk</a></th>
                    <th><a href="?sort=jenis_kendaraan&order=<?= ($sort === 'jenis_kendaraan' && $order === 'asc') ? 'desc' : 'asc' ?>">Kendaraan</a></th>
                    <th><a href="?sort=nopol&order=<?= ($sort === 'nopol' && $order === 'asc') ? 'desc' : 'asc' ?>">Nopol</a></th>
                    <?php
                    if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
                        echo '<td>aksi</td>';
                    }
                    ?>
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
                        <?php
                     
                        echo '<td scope="row">';
                        if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
                            echo '<a href="karyawan_edit.php?id=' . $row['id'] . '" class="btn btn-primary">Edit</a>';

                            echo '<a href="functions.php?action=deletepermanent&id=' . $row['id'] . '&table=tbl_karyawan&page=karyawan_data.php" class="btn btn-outline-danger" onClick="return confirm(\'Yakin akan menghapus?\')">Hapus permanent</a>';
                        }                      
                                              
                            

                        echo '</td>';
                        ?>
                        <td scope="row">
                           
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

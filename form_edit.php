<?php



// Define action
$_GET['action'] = 'edit';

// Include required functions
require 'functions.php';

// Fetch the ID for the vehicle record to edit
$id_kendaraan = $_GET['id'] ?? null;

// Fetch data from the database
$data_parkir = myquery("SELECT * FROM tbl_parkir WHERE id = $id_kendaraan ")[0] ?? null;

$data_kendaraan = myquery("SELECT * FROM tbl_kendaraan");

// Check if form is submitted for an update
if (isset($_POST['submit_update'])) {
    $_POST['id'] = $id_kendaraan;  // Ensure ID is included in $_POST
    if (update($_POST) > 0) {
        echo "<script>alert('DATA berhasil di ubah'); document.location.href = 'index.php';</script>";
    } else {
        echo "<script>alert('DATA gagal di ubah');</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Vehicle Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
</head>
<body>

    <?php
    $page = 'edit_form';
    include('layout/header.php');
    ?>

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="mt-4 mb-2">Edit Vehicle Data</h3>

                <?php if (isset($error)): ?>
                    <p style="color: red;"><?= htmlspecialchars($error); ?></p>
                <?php endif; ?>

                <div class="card mb-4">
                    <div class="card-body">
                        <form method="POST">

                        <input type="hidden" value="<?= $id?>" name="id"/>

                            <div class="mb-3">
                                <label>Nopol</label>
                                <input type="text" name="txt_nopol" class="form-control" placeholder="Enter License Plate" value="<?= htmlspecialchars($data_parkir['nopol'] ?? ''); ?>" required />
                            </div>

                            <div class="mb-3">
                                <label>Jenis Kendaraan</label>
                                <select name="txt_jenis_kendaraan" class="form-control" required>
                                    <option value="">Ubah Jenis Kendaraan</option>
                                    <option value="motor" <?= ($data_parkir['jenis_kendaraan'] ?? '') === 'motor' ? 'selected' : ''; ?>>Motor</option>
                                    <option value="mobil" <?= ($data_parkir['jenis_kendaraan'] ?? '') === 'mobil' ? 'selected' : ''; ?>>Mobil</option>
                                    <option value="lainnya" <?= ($data_parkir['jenis_kendaraan'] ?? '') === 'lainnya' ? 'selected' : ''; ?>>Lainnya</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label>pemilik</label>
                                <input type="text" name="txt_pemilik" class="form-control" placeholder="Umum/karyawan" value="<?= htmlspecialchars($data_parkir['pemilik'] ?? ''); ?>" required />
                            </div>

                            <!-- <div class="mb-3">
                                <label>Entry Date</label>
                                <input type="date" name="txt_tanggal" class="form-control" value="<?= htmlspecialchars($data_parkir['tanggal'] ?? ''); ?>" required />
                            </div> -->

                            <div class="mb-3">
                                <label>Entry Time</label>
                                <input type="datetime-local" name="txt_masuk" class="form-control" value="<?= htmlspecialchars(str_replace(' ', 'T', $data_parkir['masuk'] ?? '')); ?>" required />
                            </div>

                            <!-- <div class="mb-3">
                                <label>Exit Time</label>
                                <input type="datetime-local" name="txt_keluar" class="form-control" value="<?= htmlspecialchars(str_replace(' ', 'T', $data_parkir['keluar'] ?? null )); ?>" />
                            </div> -->

                            <button type="submit" class="btn btn-primary" name="submit_update">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include('layout/footer.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>

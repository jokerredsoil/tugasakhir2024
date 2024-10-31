<?php
session_start();

// Connect to the database
require './connection.php';

if (!isset($_SESSION['username'])) {
    header("Location: auth/login.php");
    exit();
}

$nik = '';
$nama_karyawan = '';
$jenis_kendaraan = '';
$karyawan_id = '';
$nopol = '';
$showForm = true;
$error = '';

if (isset($_POST['submit'])) {
    $nik = $_POST['txt_nik'];
    $nama_karyawan = $_POST['txt_namaKaryawan'];
    $nopol = $_POST['txt_nopol'];
    $jenis_kendaraan = $_POST['txt_jenisKendaraan'];

  
    $stmt = $conn->prepare("SELECT kar.id  FROM tbl_karyawan as kar INNER JOIN tbl_kendaraan as ken ON ken.id_karyawan = kar.id WHERE kar.nik = ? OR ken.nopol = ?");
    $stmt->bind_param("ss", $nik, $nopol); 
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        // Employee already exists, retrieve their ID
        $employee = $result->fetch_assoc();
        $karyawan_id = $employee['id'];

        // Now insert data into `tbl_kendaraan`
        $insertKendaraanQuery = "INSERT INTO tbl_kendaraan (id_karyawan, jenis_kendaraan, nopol) VALUES (?, ?, ?)";
        $insertKendaraanStmt = $conn->prepare($insertKendaraanQuery);
        $insertKendaraanStmt->bind_param("iss", $karyawan_id, $jenis_kendaraan, $nopol);

        if ($insertKendaraanStmt->execute()) {
            echo "Data successfully inserted into tbl_kendaraan.";
            $showForm = false; // Hide the form after successful insert
        } else {
            $error = "Error inserting vehicle data: " . $conn->error;
        }

        $insertKendaraanStmt->close();
    } else {
        // If the employee doesn't exist, insert them
        $insertKaryawanQuery = "INSERT INTO tbl_karyawan (nik, nama_karyawan) VALUES (?, ?)";
        $insertKaryawanStmt = $conn->prepare($insertKaryawanQuery);
        $insertKaryawanStmt->bind_param("ss", $nik, $nama_karyawan);
        
        if ($insertKaryawanStmt->execute()) {
            $karyawan_id = $conn->insert_id; // Retrieve the new employee ID

            // Now insert data into `tbl_kendaraan`
            $insertKendaraanQuery = "INSERT INTO tbl_kendaraan (id_karyawan, jenis_kendaraan, nopol) VALUES (?, ?, ?)";
            $insertKendaraanStmt = $conn->prepare($insertKendaraanQuery);
            $insertKendaraanStmt->bind_param("iss", $karyawan_id, $jenis_kendaraan, $nopol);

            if ($insertKendaraanStmt->execute()) {
                echo "Data Berhasil ditambahkan";
                $showForm = false; // Hide the form after successful insert
            } else {
                $error = "Error inserting vehicle data: " . $conn->error;
            }

            $insertKendaraanStmt->close();
        } else {
            $error = "Error inserting employee data: " . $conn->error;
        }

        $insertKaryawanStmt->close();
    }

    $stmt->close();
}

$conn->close();
?>

<?php
$page = 'add_karyawan';
include('layout/header.php');
?>

<div class="container">
    <div class="row">
        <div class="col-sm-12 d-flex flex-column ">
            <h3 class="mt-4 mb-2">TAMBAH DATA KARYAWAN</h3>

            <?php if ($error): ?>
                <p style="color: red;"><?= $error; ?></p>
            <?php endif; ?>

            <div class="card mb-4">
                <div class="card-body">
                    <form method="POST">
                        <div class="mb-3">
                            <label>NIK</label>
                            <input type="text" name="txt_nik" class="form-control" placeholder="Input NIK karyawan" value="<?= htmlspecialchars($nik); ?>" autocomplete="off" required />
                        </div>

                        <div class="mb-3">
                            <label>Nama Karyawan</label>
                            <input type="text" name="txt_namaKaryawan" class="form-control" placeholder="Masukan Nama Karyawan" value="<?= htmlspecialchars($nama_karyawan); ?>" autocomplete="on" required />
                        </div>

                        <div class="mb-3">
                            <label>Nopol</label>
                            <input type="text" name="txt_nopol" class="form-control" placeholder="Input Nopol kendaraan" value="<?= htmlspecialchars($nopol); ?>" autocomplete="off" required />
                        </div>

                        <div class="mb-3">
                            <label>Jenis Kendaraan</label>
                            <select name="txt_jenisKendaraan" class="form-control" required>
                                <option value="">Pilih Jenis Kendaraan</option>
                                <option value="motor" <?= $jenis_kendaraan === 'motor' ? 'selected' : ''; ?>>Motor</option>
                                <option value="mobil" <?= $jenis_kendaraan === 'mobil' ? 'selected' : ''; ?>>Mobil</option>
                                <option value="lainnya" <?= $jenis_kendaraan === 'lainnya' ? 'selected' : ''; ?>>Lainnya</option>
                            </select>
                        </div>

                        <button class="btn btn-primary" name="submit">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include('layout/footer.php');
?>

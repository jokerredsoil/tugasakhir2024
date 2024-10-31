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
$tanggal_masuk = '';
$jenis_kendaraan = '';
$karyawan_id = '';
$nopol = '';
$showForm = true;
$error = '';

if (isset($_POST['submit'])) {
    $nik = $_POST['txt_nik'];
    $nama_karyawan = $_POST['txt_namaKaryawan'];
    $tanggal_masuk = $_POST['txt_tanggalMasuk'];
    $nopol = $_POST['txt_nopol'];
    $jenis_kendaraan = $_POST['txt_jenisKendaraan'];

    // Check if NIK or Nopol already exists
    $stmtCheck = $conn->prepare("SELECT kar.id AS karyawan_id, ken.id_karyawan 
                                 FROM tbl_karyawan AS kar 
                                 LEFT JOIN tbl_kendaraan AS ken ON kar.id = ken.id_karyawan 
                                 WHERE kar.nik = ? OR ken.nopol = ?");
    $stmtCheck->bind_param("ss", $nik, $nopol);
    $stmtCheck->execute();
    $resultCheck = $stmtCheck->get_result();
    
    if ($resultCheck->num_rows > 0) {
        $existingData = $resultCheck->fetch_assoc();
        $error = $existingData['id_karyawan'] ? "Error: Nopol already exists." : "Error: NIK already exists.";
    } else {
        // Insert or update employee and vehicle data
        if ($existingData = $resultCheck->fetch_assoc()) {
            $karyawan_id = $existingData['karyawan_id'];
        } else {
            $stmtInsertKaryawan = $conn->prepare("INSERT INTO tbl_karyawan (nik, nama_karyawan, tanggal_masuk) VALUES (?, ?, ?)");
            $stmtInsertKaryawan->bind_param("sss", $nik, $nama_karyawan, $tanggal_masuk);
            $stmtInsertKaryawan->execute();
            $karyawan_id = $conn->insert_id;
        }

        // Insert vehicle data
        $stmtInsertKendaraan = $conn->prepare("INSERT INTO tbl_kendaraan (id_karyawan, jenis_kendaraan, nopol) VALUES (?, ?, ?)");
        $stmtInsertKendaraan->bind_param("iss", $karyawan_id, $jenis_kendaraan, $nopol);

        if ($stmtInsertKendaraan->execute()) {
            echo "Data successfully added.";
            $showForm = false; // Hide form after success
        } else {
            $error = "Error inserting vehicle data: " . $conn->error;
        }

        $stmtInsertKaryawan->close();
        $stmtInsertKendaraan->close();
    }
    $stmtCheck->close();
}
?>



<?php
$page = 'add_karyawan';
include('layout/header.php');
?>

<div class="container">
    <div class="row">
        <div class="col-sm-12">
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
                            <label>Tanggal Masuk</label>
                            <input type="date" name="txt_tanggalMasuk" class="form-control"  value="<?= htmlspecialchars($tanggal_masuk); ?>" autocomplete="off" required />
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

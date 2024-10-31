<?php
session_start();
require 'connection.php';

if (!isset($_SESSION['username'])) {
    header("Location: auth/login.php");
    exit();
}

// Check if the id is set in the URL
if (!isset($_GET['id'])) {
    // Redirect or handle the error as needed
    header("Location: data_karyawan.php");
    exit();
}

// Get the id from the URL
$id = intval($_GET['id']);

// Fetch the current data for the specified id
$query = "SELECT kar.id, kar.nik, kar.nama_karyawan, kar.tanggal_masuk, 
                 ken.jenis_kendaraan, ken.nopol 
          FROM tbl_karyawan as kar 
          LEFT JOIN tbl_kendaraan as ken ON ken.id_karyawan = kar.id 
          WHERE kar.id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$karyawan = $result->fetch_assoc();

// Check if employee data is found
if (!$karyawan) {
    // Redirect or handle the error as needed
    header("Location: data_karyawan.php");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $nik = $_POST['nik'];
    $nama = $_POST['nama_karyawan'];
    $tanggal_masuk = $_POST['tanggal_masuk'];
    $jenis_kendaraan = $_POST['jenis_kendaraan'];
    $nopol = $_POST['nopol'];

    // Prepare data for update
    $data = [
        'id' => $id,
        'nik' => $nik,
        'nama_karyawan' => $nama,
        'tanggal_masuk' => $tanggal_masuk,
        'jenis_kendaraan' => $jenis_kendaraan,
        'nopol' => $nopol
    ];

    // Call the update function
    list($result1, $result2) = update_karyawan($data);
    
    // Redirect or display a message based on the result
    if ($result1 > 0 && $result2 > 0) {
        header("Location: data_karyawan.php?message=update_success");
        exit();
    } else {
        $error_message = "Failed to update data.";
    }
}
?>

<?php
$page = 'edit_karyawan';
include('layout/header.php');
?>

<main class="flex-grow-1">
    <div class="container-sm">
        <h2>Edit Karyawan</h2>
        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger"><?= $error_message ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="mb-3">
                <label for="nik" class="form-label">NIK</label>
                <input type="text" class="form-control" id="nik" name="nik" value="<?= htmlspecialchars($karyawan['nik']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="nama_karyawan" class="form-label">Nama Karyawan</label>
                <input type="text" class="form-control" id="nama_karyawan" name="nama_karyawan" value="<?= htmlspecialchars($karyawan['nama_karyawan']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="tanggal_masuk" class="form-label">Tanggal Masuk</label>
                <input type="date" class="form-control" id="tanggal_masuk" name="tanggal_masuk" value="<?= htmlspecialchars($karyawan['tanggal_masuk']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="jenis_kendaraan" class="form-label">Jenis Kendaraan</label>
                <input type="text" class="form-control" id="jenis_kendaraan" name="jenis_kendaraan" value="<?= htmlspecialchars($karyawan['jenis_kendaraan']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="nopol" class="form-label">Nomor Polisi</label>
                <input type="text" class="form-control" id="nopol" name="nopol" value="<?= htmlspecialchars($karyawan['nopol']) ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="karyawan_data.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</main>

<?php
include('layout/footer.php');
?>

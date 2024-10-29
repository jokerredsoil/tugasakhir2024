<?php
session_start();



// Connect to the database
require 'connection.php';

if(!isset($_SESSION['username'])){
    header("Location: auth/login.php");
    exit();
}

$nopol = '';
$jenis_kendaraan = '';
$pemilik = '';
$error = '';
$showForm = true;

// Check if "Check nopol" button was clicked
if (isset($_POST['btn_check_nopol'])) {
    $nopol = $_POST['txt_nopol'];

    // Check if `nopol` exists in `tbl_kendaraan`
    $stmt = $conn->prepare("
    SELECT k.nopol, k.jenis_kendaraan, k.id_karyawan, p.nama_karyawan 
    FROM tbl_kendaraan k 
    LEFT JOIN tbl_karyawan p ON k.id_karyawan = p.id
    WHERE k.nopol = ?");
    $stmt->bind_param("s", $nopol);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nopol = $row['nopol'];
        $jenis_kendaraan = $row['jenis_kendaraan'];
        $pemilik = $row['nama_karyawan'];  
    } else {
        $error = "The entered nopol does not exist in tbl_kendaraan.";
        $jenis_kendaraan = ''; 
        $pemilik = 'umum'; 
    }
}

// Handle form submission for inserting into `tbl_parkir`
if (isset($_POST['submit'])) {
    $nopol = $_POST['txt_nopol'];
    $jenis_kendaraan = $_POST['txt_jenisKendaraan']; // Make sure this matches the input name
    $pemilik = $_POST['txt_pemilik']; // Ensure this matches the input name
    $tanggal = date('Y-m-d');

    // connect
    $stmt = $conn->prepare("
    SELECT * FROM tbl_parkir WHERE nopol = ?  AND tanggal = ?");
    $stmt->bind_param("ss", $nopol, $tanggal);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){
        $error = "Sudah ada kendaraan yang patkir.";
    }else{
        // Insert data into tbl_parkir
        $insertQuery = "INSERT INTO tbl_parkir (nopol, jenis_kendaraan, pemilik, tanggal) VALUES (?, ?, ?, ?) ";
        $insertStmt = $conn->prepare($insertQuery);
        $insertStmt->bind_param("ssss", $nopol, $jenis_kendaraan, $pemilik, $tanggal);

        if ($insertStmt->execute()) {
            echo "Data successfully inserted into tbl_parkir.";
            $showForm = false;  

        } else {
            echo "Error inserting data: " . $conn->error;
        }

        $insertStmt->close();
    }

    
    
}

$conn->close();
?>

<?php
$page = 'add_form';
include('layout/header.php');
?>

<div class="container">
    <div class="row">
        <div class="col-sm-12">

            <h3 class="mt-4 mb-2">Formulir Tambah</h3>
           

            <?php if ($error): ?>
                <p style="color: red;"><?= $error; ?></p>
            <?php endif; ?>

            <div class="card mb-4">
                <div class="card-body">

                    <form method="POST">
                        <div class="mb-3 ">
                            <label>nopol</label>
                            <input type="text" name="txt_nopol" class="form-control" placeholder="Masukan Plat Nomor" value="<?= htmlspecialchars($nopol); ?>" autocomplete="off" />
                            <button type="submit" class="btn btn-success" name="btn_check_nopol" autocomplete="on">Check nopol</button>
                        </div>

                        <div class="mb-3">
                            <label>jenis kendaraan</label>
                            <!-- <input type="text" name="txt_jenisKendaraan" class="form-control" placeholder="Input jenis kendaraan" value="<?= htmlspecialchars($jenis_kendaraan); ?>" autocomplete="off" readonly /> -->
                            <select name="txt_jenisKendaraan" class="form-control">
                                <option value="">Pilih Jenis Kendaraan</option>
                                <option value="motor" <?= $jenis_kendaraan === 'motor' ? 'selected' : ''; ?>>Motor</option>
                                <option value="mobil" <?= $jenis_kendaraan === 'mobil' ? 'selected' : ''; ?>>Mobil</option>
                                <option value="lainnya" <?= $jenis_kendaraan === 'lainnya' ? 'selected' : ''; ?>>Lainnya</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>pemilik</label>
                            <input type="text" name="txt_pemilik" class="form-control" placeholder="umum/karyawan" value="<?= htmlspecialchars($pemilik); ?>" autocomplete="off" readonly />
                        </div>

                        <div class="mb-3">
                            <label>masuk</label>
                            <input type="date" name="txt_masuk" class="form-control" autocomplete="off" />
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
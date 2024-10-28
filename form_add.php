<?php
// Connect to the database
require 'connection.php';

$nopol = '';
$jenis_kendaraan = '';
$pemilik = '';
$error = '';
$showForm = true;



// Check if "Check nopol" button was clicked
if (isset($_POST['btn_check_nopol'])) {
    echo 'ok';
    $nopol = $_POST['txt_nopol'];

    // Check if `nopol` exists in `tbl_kendaraan`
    $stmt = $conn->prepare("SELECT nopol, jenis_kendaraan, id_karyawan FROM tbl_kendaraan WHERE nopol = ?");
    $stmt->bind_param("s", $nopol);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nopol = $row['nopol'];
        $jenis_kendaraan = $row['jenis_kendaraan'];
        $pemilik = $row['id_karyawan'];  // Assuming 'id_karyawan' links to owner
    } else {
        $error = "The entered nopol does not exist in tbl_kendaraan.";
    
        $jenis_kendaraan = '';
        $pemilik = 'umum';
    }
}

// Handle form submission for inserting into `tbl_parkir`
if (isset($_POST['submit'])) {
    $nopol = $_POST['txt_nopol'];
    $jenis_kendaraan = $_POST['jenis_kendaraan'];
    $pemilik = $_POST['pemilik'];
    $tanggal = date('Y-m-d');

    // Insert data into tbl_parkir
    $insertQuery = "INSERT INTO tbl_parkir (nopol, jenis_kendaraan, pemilik, tanggal) VALUES (?, ?, ?, ?)";
    $insertStmt = $conn->prepare($insertQuery);
    $insertStmt->bind_param("ssss", $nopol, $jenis_kendaraan, $pemilik, $tanggal);

    if ($insertStmt->execute()) {
        echo "Data successfully inserted into tbl_parkir.";
        $showForm = false;  // Hide form after successful insert
    } else {
        echo "Error inserting data: " . $conn->error;
    }

    $insertStmt->close();
}

$conn->close();
?>
<?php
include('layout/header.php');
?>

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
                        <div class="mb-3 ">
                            <label>nopol</label>
                            <input type="text" name="txt_nopol" class="form-control" placeholder="Masukan Plat Nomor" autocomplete="off" />
                            <button type="button" class="btn btn-success" name="btn_check_nopol">Success</button>
                           
                        </div>

                        <div class="mb-3">
                            <label>jenis kendaraan</label>
                            <input type="text" name="txt_jenisKendaraan" class="form-control" placeholder="Input jenis kendaraan" autocomplete="off" />
                        </div>

                        <div class="mb-3">
                            <label>pemilik</label>
                            <input type="text" name="txt_pemilik" class="form-control" placeholder="umum/karyawan" autocomplete="off" />
                        </div>

                        <div class="mb-3">
                            <label>masuk</label>
                            <input type="date" name="txt_masuk" class="form-control" autocomplete="off" />
                        </div>



                        <!-- <div class="mb-3">
                                <label>JENIS KENDARAAN</label>
                                
                                    <form>
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="options" id="option1" value="mobil" checked>
                                                <label class="form-check-label" for="option1">
                                                    Mobil
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="options" id="option2" value="motor">
                                                <label class="form-check-label" for="option2">
                                                    Motor
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="options" id="option3" value="lainnya">
                                                <label class="form-check-label" for="option3">
                                                    Lainnya
                                                </label>
                                            </div>
                                        </div>
                                        
                                    </form>
                             
                            <div class="mb-3"> -->
                        <button class="btn btn-primary" name="submit_insert_karyawan">Simpan</button>
                </div>
                </form>

            </div>
        </div>

    </div>
</div>
</div>
<?php
include('layout/footer.php')
?>
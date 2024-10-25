<?php
require 'connection.php';


$data_karyawan = myquery("SELECT * FROM tbl_karyawan");
$data_kendaraan = myquery("SELECT * FROM tbl_kendaraan");




if (isset($_POST['submit_insert_karyawan'])) {
    $nopol= $_POST['txt_nopol'];
    $jenis_kendaraan = $_POST['txt_jenisKendaraan'];

    $pemilik= $_POST['txt_pemilik'];
    
    $masuk = $_POST['txt_masuk'];

    // Menformat tanggal
    $tanggal_baru = new DateTime($masuk);
    $formatted_tanggal = $tanggal_baru->format('Y-m-d');

    /// Insert
    $query_insert = "INSERT INTO tbl_parkir VALUE (null, '$nopol', '$jenis_kendaraan', '$pemilik', $formatted_tanggal',null)";

    $res = mysqli_query($conn, $query_insert);

    if ($res) {
        header("Location: index.php");
        exit();
    } else {
        $err = "Data gagal di input";
    }
}
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
                        <div class="mb-3">
                            <label>nopol</label>
                            <input type="text" name="txt_nopol" class="form-control" placeholder="Masukan Plat Nomor" autocomplete="off" />
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
<?php
require 'connection.php';


$data_karyawan = myquery("SELECT * FROM tbl_karyawan");
$data_kendaraan = myquery("SELECT * FROM tbl_kendaraan");



if (isset($_POST['submit_insert_karyawan'])) {
    $nik = $_POST['txt_nik'];
    $nama = $_POST['txt_nama'];

    $tanggal_masuk = $_POST['txt_tanggal'];

    // Menformat tanggal
    $tanggal_baru = new DateTime($tanggal);
    $formatted_tanggal = $tanggal_baru->format('Y-m-d');

    /// Insert
    $query_insert = "INSERT INTO tbl_karyawan VALUE (null, '$nik', '$nama', '$formatted_tanggal')";

    $res = mysqli_query($conn, $query_insert);

    if ($res) {
        header("Location: index.php");
        exit();
    } else {
        $err = "Data gagal di input";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form tambah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>

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
                                <label>NIK</label>
                                <input type="text" name="txt_nik" class="form-control" placeholder="Input Nomor induk Karyawan" autocomplete="off" />
                            </div>

                            <div class="mb-3">
                                <label>NAMA</label>
                                <input type="text" name="txt_nama" class="form-control" placeholder="Input Nama Karyawan" autocomplete="off" />
                            </div>

                            <div class="mb-3">
                                <label>TANGGAL</label>
                                <input type="date" name="txt_tanggal" class="form-control" autocomplete="off" />
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
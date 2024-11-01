<?php
require 'connection.php';


if(!isset($_SESSION['username'])){
    header("Location: auth/login.php");
    exit();
}


// $data =myquery("SELECT * FROM tbl_parkir");
$data = myquery("SELECT p.id, p.nopol, p.jenis_kendaraan, p.pemilik, p.tanggal, p.masuk, p.keluar
FROM tbl_parkir as p
WHERE p.keluar is not null
");

?>

<?php
$page = 'history';
include('layout/header.php');
?>
<main class="flex-grow-1">
    <div class="container-sm">
        <table class="table table-sm">
            <thead>
                <tr>
                    <th>nopol</th>
                    <th>jenis kendaraan</th>
                    <th>pemilik</th>
                    <!-- <th>tanggal</th> -->
                    <th>masuk</th>
                    <th>keluar</th>
                    <?php 
                    if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
                    echo '<th>aksi</th>';}
                    ?>
                </tr>
            </thead>
            <tbody>
                
                <?php foreach ($data as $row): ?>
                    
                   
                    <tr>
                        <td><?= $row['nopol'] ?></td>
                        <td><?= $row['jenis_kendaraan'] ?></td>
                        <td><?= $row['pemilik'] ?></td>
                        <!-- <td><?= $row['tanggal'] ?></td> -->
                        <td><?= $row['masuk'] ?></td>
                        <td><?= $row['keluar'] ?></td>
                        <?php
                     
                        echo '<td scope="row">';
                        if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
                            echo '<a href="functions.php?action=deletepermanent&id='  .$row['id']. '&table=tbl_parkir&page=history.php "class="btn btn-outline-danger" onClick="return confirm(\' Yakin akan Menghapus ?\')">Hapus Permanent</a>';
                        }                      
                                              
                            

                        echo '</td>';
                        ?>
                    </tr>
                   
                <?php endforeach; ?>
            
            </tbody>
        </table>

    </div>

</main>

<?php
include('layout/footer.php')
?>
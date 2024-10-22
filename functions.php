<?php
// require 'connection.php';

  // Jika terdapat 'action' dan 'id' maka melakukan sesuatu
//   if(isset($_GET['action']) && isset($_GET['id'])){
//     $action = $_GET['action'];
//     $id = $_GET['id'];

//     switch($action){
//       case 'delete':
//         delete_data($id);
//         break;
//       case 'edit':
//             echo " ";
//             break;
//       default:
//         echo "Aksi tidak di definisikan!";
//     }
//   }else{
//     echo "Aksi dan ID tidak di definisikan!";
//   }

//   function add_data(){

//   }

//   function delete_data($id){
//     global $conn;
//     $res = mysqli_query($conn, "DELETE FROM tbl_karyawan WHERE id = " . $id);

//     if($res){
//       // Jika true
//       header("Location: index.php?messages=Berhasil dihapus");
//       exit();
//     }else{
//       // Jika false
//       header("Location: index.php?messages=Gagal dihapus");
//       exit();
//     }
//   }

//   function update($data){
//     global $conn;
//     $id = $data['id_person'];
//     $nama = $data['txt_nama'];
//     $ktp = $data['txt_ktp'];
//     $alamat =  $data['select_alamat'];
//     $tanggal = $data['txt_tanggal'];

//     // format tanggal
//     $tanggal_baru = new DateTime($tanggal);
//     $formated_tanggal = $tanggal_baru -> format("Y-m-d");


//     $query = "UPDATE tb_person SET 
//         nama = '$nama',
//         ktp = '$ktp',
//         alamat = '$alamat',
//         tgl_daftar = '$formated_tanggal'
//         WHERE id = $id 
//     ";

//     mysqli_query($conn, $query);
//     return mysqli_affected_rows($conn);

//   }


?>
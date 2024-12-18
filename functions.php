<?php


require 'connection.php';

// $tabel = 'tbl_parkir';

// If 'action' and 'id' are set, perform the corresponding action
if (isset($_GET['action']) && isset($_GET['id'])){
    if (isset($_GET['table'])){
    $tabel = $_GET['table'];
    $page = $_GET['page'];

    }
    $action = $_GET['action'];
    $id = $_GET['id'];

    switch ($action) {
        case 'softdelete':
            soft_delete($id);
            break;
        case 'deletepermanent':
            delete_data_permanent($id, $tabel, $page);
            break;
        case 'edit':
            echo " ";
            break;
        default:
            echo "Undefined action!";
    }
}

function soft_delete($id)
{
    
    global $conn;
   
   
    $currentDateTime = date('Y-m-d H:i:s');

    // Update the record to set the 'keluar' column to the current date and time
    $update_data = "UPDATE tbl_parkir SET keluar = ? WHERE id = ?";

    $stmt = $conn->prepare($update_data);
    $stmt->bind_param("si", $currentDateTime, $id);

    if ($stmt->execute()) {
        echo "Motor berhasil Check-out successfully.";
        header("Location: index.php?messages=Berhasil Checkout");
        exit();
    } else {
        echo "Error: " . $stmt->error;
        header("Location: index.php?messages=Gagal checkout");
        exit();
    }

    $stmt->close();
}

function delete_data_permanent($id, $tabel, $page)
{
    global $conn;
   
 
    $stmt = $conn->prepare("DELETE FROM $tabel WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: $page ?messages=Berhasil dihapus");
        exit();
    } else {
        header("Location: $page ?messages=Gagal dihapus");
        exit();
    }

    $stmt->close();
}

function update_karyawan($data) {
    global $conn;

    $id = $data['id'];
    $nik = $data['nik'];
    $nama = $data['nama_karyawan'];
    $tanggalM = $data['tanggal_masuk'];
    $jenis_kendaraan = $data['jenis_kendaraan'];
    $nopol = $data['nopol'];

    // Format the tanggal_masuk if it's not empty
    if (!empty($tanggalM)) {
        $tanggal_baru = new DateTime($tanggalM);
        $formatted_tanggal = $tanggal_baru->format("Y-m-d");
    } else {
        $formatted_tanggal = null;
    }
   // Update tbl_karyawan
   $update_karyawan = "UPDATE tbl_karyawan SET nik = ?, nama_karyawan = ?, tanggal_masuk = ? WHERE id = ?";
   $stmt1 = $conn->prepare($update_karyawan);
   $stmt1->bind_param("sssi", $nik, $nama, $formatted_tanggal, $id);
   $result1 = ($stmt1->execute()) ? $stmt1->affected_rows : 0;

   // Check if the employee has a vehicle record in tbl_kendaraan
   $check_vehicle = "SELECT id_karyawan FROM tbl_kendaraan WHERE id_karyawan = ?";
   $stmt_check = $conn->prepare($check_vehicle);
   $stmt_check->bind_param("i", $id);
   $stmt_check->execute();
   $stmt_check->store_result();

   // If a record exists, update it; otherwise, insert a new one
   if ($stmt_check->num_rows > 0) {
       $update_kendaraan = "UPDATE tbl_kendaraan SET jenis_kendaraan = ?, nopol = ? WHERE id_karyawan = ?";
       $stmt2 = $conn->prepare($update_kendaraan);
       $stmt2->bind_param("ssi", $jenis_kendaraan, $nopol, $id);
   } else {
       $insert_kendaraan = "INSERT INTO tbl_kendaraan (id_karyawan, jenis_kendaraan, nopol) VALUES (?, ?, ?)";
       $stmt2 = $conn->prepare($insert_kendaraan);
       $stmt2->bind_param("iss", $id, $jenis_kendaraan, $nopol);
   }

   // Execute the insert or update for tbl_kendaraan
   $result2 = ($stmt2->execute()) ? $stmt2->affected_rows : 0;

   // Close statements
   $stmt1->close();
   $stmt_check->close();
   $stmt2->close();

   return [$result1, $result2]; // Return results as an array

}

function update_parkir($data)
{
    global $conn;

    $id = $data['id'];
    $nopol = $data['txt_nopol'];
    $jenis_kendaraan = $data['txt_jenis_kendaraan'];
    $pemilik = $data['txt_pemilik'];
    $tanggal = $data['txt_tanggal'];
    $masuk = $data['txt_masuk'];
    $keluar = $data['txt_keluar'];



   
    if (!empty($tanggal)) {
        $tanggal_baru = new DateTime($tanggal);
        $formatted_tanggal = $tanggal_baru->format("Y-m-d");
    } else {
        $formatted_tanggal = null;
    }

   
    $update_data = "UPDATE tbl_parkir SET nopol = ?, jenis_kendaraan = ?, pemilik = ?, tanggal = ?, masuk = ?, keluar = ? WHERE id = ?";
    $stmt = $conn->prepare($update_data);

    if ($stmt === false) {
        return 0;
    }

   
    $stmt->bind_param("ssssssi", $nopol, $jenis_kendaraan, $pemilik, $formatted_tanggal, $masuk, $keluar, $id);

    // Execute and check if update was successful
    $result = 0;
    if ($stmt->execute()) {
        $result = $stmt->affected_rows;
    }

    // Close the statement
    $stmt->close();

    return $result;
}

function login($username, $password)
{
    global $conn;

    $stmt = $conn->prepare("SELECT id, username, role, password FROM tbl_user WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify the password hash
        if (password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            // Redirect to dashboard
            header("Location: ../index.php");
            exit();
        } else {
            return "Invalid password.";
        }
    } else {
        return "User not found.";
    }
}



function register($username, $password, $role = 'user')
{
    global $conn;

    // Check if the username already exists
    $query = "SELECT * FROM tbl_user WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        return "Username already exists. Please choose a different username.";
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    var_dump($hashed_password);

    // Insert the new user into the database
    $insert_query = "INSERT INTO tbl_user (username, password, role) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($insert_query);
    $stmt->bind_param("sss", $username, $hashed_password, $role);

    if ($stmt->execute()) {
        
        echo "Daftar '$role' dengan username '$username' berhasil.";
        header("Location: login.php");
        exit();
    } else {
        return "Error: " . $stmt->error;
    }

    $stmt->close();
}





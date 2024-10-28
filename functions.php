<?php
require 'connection.php';

$tabel = 'tbl_parkir';

// If 'action' and 'id' are set, perform the corresponding action
if (isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $id = $_GET['id'];

    switch ($action) {
        case 'softdelete':
            soft_delete($id);
            break;
        case 'deletepermanent':
            delete_data_permanent($id);
            break;
        case 'edit':
            echo "Edit action not implemented.";
            break;
        default:
            echo "Undefined action!";
    }
} else {
    echo "Action and ID are not defined!";
}

function soft_delete($id) {
    global $conn;

    // Get the current date and time
    $currentDateTime = date('Y-m-d H:i:s');

    // Update the record to set the 'keluar' column to the current date and time
    $sql = "UPDATE tbl_parkir SET keluar = ? WHERE id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $currentDateTime, $id);

    if ($stmt->execute()) {
        echo "Record soft deleted successfully.";
        header("Location: index.php?messages=Berhasil Checkout");
        exit();
    } else {
        echo "Error: " . $stmt->error;
        header("Location: index.php?messages=Gagal checkout");
        exit();
    }

    $stmt->close();
}

function delete_data_permanent($id) {
    global $conn;

    // Use prepared statements for deletion
    $stmt = $conn->prepare("DELETE FROM tbl_parkir WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Redirect to history.php with success message
        header("Location: history.php?messages=Berhasil dihapus");
        exit();
    } else {
        // Redirect to history.php with error message
        header("Location: history.php?messages=Gagal dihapus");
        exit();
    }

    $stmt->close();
}

function update($data) {
    global $conn;

    $id = $data['id_person'];
    $nama = $data['txt_nama'];
    $ktp = $data['txt_ktp'];
    $alamat = $data['select_alamat'];
    $tanggal = $data['txt_tanggal'];

    // Format date
    $tanggal_baru = new DateTime($tanggal);
    $formatted_tanggal = $tanggal_baru->format("Y-m-d");

    // Update the record using prepared statements
    $sql = "UPDATE tb_person SET nama = ?, ktp = ?, alamat = ?, tgl_daftar = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $nama, $ktp, $alamat, $formatted_tanggal, $id);

    if ($stmt->execute()) {
        return $stmt->affected_rows;
    } else {
        return 0;
    }

    $stmt->close();
}

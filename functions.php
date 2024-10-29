<?php
require 'connection.php';

// $tabel = 'tbl_parkir';

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
            echo " ";
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
    $update_data = "UPDATE tbl_parkir SET keluar = ? WHERE id = ?";

    $stmt = $conn->prepare($update_data);
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

    $id = $data['id'];
    $nopol = $data['txt_nopol'];
    $jenis_kendaraan = $data['txt_jenis_kendaraan'];
    $pemilik = $data['txt_pemilik'];
    $tanggal = $data['txt_tanggal'];
    $masuk = $data['txt_masuk'];
    $keluar = $data['txt_keluar'];

   

    // Format tanggal if not empty
    if (!empty($tanggal)) {
        $tanggal_baru = new DateTime($tanggal);
        $formatted_tanggal = $tanggal_baru->format("Y-m-d");
    } else {
        $formatted_tanggal = null;
    }

    // Prepare the update_data query with placeholders for parameters
    $update_data = "UPDATE tbl_parkir SET nopol = ?, jenis_kendaraan = ?, pemilik = ?, tanggal = ?, masuk = ?, keluar = ? WHERE id = ?";
    $stmt = $conn->prepare($update_data);

    if ($stmt === false) {
        return 0;
    }

    // Bind the parameters
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

?>
